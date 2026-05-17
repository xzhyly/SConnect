<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ScholarshipAlert;
use App\Models\Scholarship;
use App\Models\SyncLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SyncController extends Controller
{
    /**
     * GET /admin/sync — show the Sync Now page
     */
    public function index()
    {
        $totalSyncs = SyncLog::count();
        $lastSync   = SyncLog::latest()->first();

        return view('admin.sync', compact('totalSyncs', 'lastSync'));
    }

    /**
     * POST /admin/sync — run the sync (called via JS fetch)
     */
    public function run(Request $request)
    {
        $sources = [
            'ched'     => 'http://mock-api:8080/api/ched',
            'dost_sei' => 'http://mock-api:8080/api/dost',
            'lgu'      => 'http://mock-api:8080/api/lgu',
        ];

        $results         = [];
        $newScholarships = collect();

        foreach ($sources as $source => $url) {
            try {
                $response = Http::timeout(15)->get($url);

                if (!$response->successful()) {
                    throw new \Exception("HTTP {$response->status()} from {$url}");
                }

                $data         = $response->json();
                $scholarships = $data['scholarships'] ?? $data;

                if (!is_array($scholarships)) {
                    throw new \Exception("Unexpected response format from {$source}");
                }

                $fetched = count($scholarships);
                $created = 0;
                $updated = 0;

                foreach ($scholarships as $item) {
                    $sourceUrl = $item['source_url'] ?? null;
                    if (!$sourceUrl) continue;

                    $exists = Scholarship::where('source_url', $sourceUrl)->exists();

                    $scholarship = Scholarship::updateOrCreate(
                        ['source_url' => $sourceUrl],
                        [
                            'title'       => $item['title']       ?? 'Untitled Scholarship',
                            'provider'    => $item['provider']    ?? $source,
                            'description' => $item['description'] ?? null,
                            'deadline'    => $item['deadline']    ?? null,
                            'is_active'   => true,
                        ]
                    );

                    if ($exists) {
                        $updated++;
                    } else {
                        $created++;
                        $newScholarships->push($scholarship);
                    }
                }

                SyncLog::create([
                    'source'          => $source,
                    'status'          => 'success',
                    'records_fetched' => $fetched,
                    'records_created' => $created,
                    'records_updated' => $updated,
                    'error_message'   => null,
                ]);

                $results[$source] = [
                    'status'       => 'success',
                    'scholarships' => $fetched,
                    'created'      => $created,
                    'updated'      => $updated,
                    'emails_sent'  => 0,
                    'message'      => "Fetched {$fetched}, created {$created}, updated {$updated}.",
                ];
            } catch (\Exception $e) {
                Log::error("Sync failed for {$source}: " . $e->getMessage());

                SyncLog::create([
                    'source'          => $source,
                    'status'          => 'failed',
                    'records_fetched' => 0,
                    'records_created' => 0,
                    'records_updated' => 0,
                    'error_message'   => $e->getMessage(),
                ]);

                $results[$source] = [
                    'status'       => 'failed',
                    'scholarships' => 0,
                    'emails_sent'  => 0,
                    'message'      => $e->getMessage(),
                ];
            }
        }

        // Match new scholarships to students and send email alerts
        $emailsSent = 0;

        if ($newScholarships->isNotEmpty()) {
            $students = User::where('is_admin', false)
                ->where('email_notifications', true)
                ->get();

            foreach ($students as $student) {
                foreach ($newScholarships as $scholarship) {
                    if ($this->studentMatches($student, $scholarship)) {
                        try {
                            Mail::to($student->email)->send(
                                new ScholarshipAlert($student, $scholarship)
                            );
                            $emailsSent++;
                        } catch (\Exception $e) {
                            Log::error("Email failed for student {$student->id}: " . $e->getMessage());
                        }
                    }
                }
            }
        }

        // Convert keyed results to array format the blade expects
        $sources = [];
        $totalFetched = 0;
        foreach ($results as $source => $result) {
            $sources[] = [
                'source'  => strtoupper($source),
                'status'  => $result['status'],
                'fetched' => $result['scholarships'] ?? 0,
                'created' => $result['created'] ?? 0,
                'updated' => $result['updated'] ?? 0,
                'error'   => $result['message'] ?? null,
            ];
            $totalFetched += $result['scholarships'] ?? 0;
        }

        $totalCreated = array_sum(array_column($sources, 'created'));
$totalUpdated = array_sum(array_column($sources, 'updated'));

return response()->json([
    'success'       => true,
    'sources'       => $sources,
    'total_fetched' => $totalFetched,
    'total_created' => $totalCreated,
    'total_updated' => $totalUpdated,
    'emails_sent'   => $emailsSent,
]);
    }

    /**
     * GET /admin/sync-logs — show logs page
     */
    public function logs()
    {
        $logs            = SyncLog::latest()->paginate(20);
        $totalSyncs      = SyncLog::count();
        $successfulSyncs = SyncLog::where('status', 'success')->count();
        $failedSyncs     = SyncLog::where('status', 'failed')->count();
        $totalFetched    = SyncLog::sum('records_fetched');

        return view('admin.sync-logs', compact(
            'logs',
            'totalSyncs',
            'successfulSyncs',
            'failedSyncs',
            'totalFetched'
        ));
    }

    /**
     * Check if a student matches a scholarship
     */
    private function studentMatches(User $student, Scholarship $scholarship): bool
    {
        if ($scholarship->minimum_gwa && $student->gwa) {
            if ((float) $student->gwa > (float) $scholarship->minimum_gwa) {
                return false;
            }
        }

        if ($scholarship->required_course && $student->course) {
            $required = strtolower(trim($scholarship->required_course));
            $enrolled = strtolower(trim($student->course));
            if ($required !== 'any' && $required !== $enrolled) {
                return false;
            }
        }

        if ($scholarship->municipality && $student->municipality) {
            $schMun = strtolower(trim($scholarship->municipality));
            $stuMun = strtolower(trim($student->municipality));
            if ($schMun !== 'all' && $schMun !== $stuMun) {
                return false;
            }
        }

        return true;
    }
}
