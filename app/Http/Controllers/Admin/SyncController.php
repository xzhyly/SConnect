<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ScholarshipAlert;
use App\Models\Notification;
use App\Models\Scholarship;
use App\Models\SyncLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SyncController extends Controller
{
    public function index()
    {
        $totalSyncs = SyncLog::count();
        $lastSync   = SyncLog::latest()->first();
        return view('admin.sync', compact('totalSyncs', 'lastSync'));
    }

    public function run(Request $request)
    {
       $baseUrl = env('MOCK_API_URL', 'http://mock-api:8080');
$sources = [
    'ched'     => "{$baseUrl}/api/ched",
    'dost_sei' => "{$baseUrl}/api/dost",
    'lgu'      => "{$baseUrl}/api/lgu",
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
                            'title'            => $item['title']            ?? 'Untitled Scholarship',
                            'provider'         => $item['provider']         ?? $source,
                            'description'      => $item['description']      ?? null,
                            'deadline'         => $item['deadline']         ?? null,
                            'minimum_gwa'      => $item['minimum_gwa']      ?? null,
                            'required_course'  => $item['required_course']  ?? null,
                            'municipality'     => $item['municipality']     ?? null,
                            'year_level'       => $item['year_level']       ?? null,
                            'benefits'         => $item['benefits']         ?? null,
                            'application_link' => $item['application_link'] ?? null,
                            'is_active'        => true,
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
                    'status'  => 'success',
                    'fetched' => $fetched,
                    'created' => $created,
                    'updated' => $updated,
                    'message' => "Fetched {$fetched}, created {$created}, updated {$updated}.",
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
                    'status'  => 'failed',
                    'fetched' => 0,
                    'created' => 0,
                    'updated' => 0,
                    'message' => $e->getMessage(),
                ];
            }
        }

        // Notify eligible students for new scholarships only
        $emailsSent = 0;

       if (false && $newScholarships->isNotEmpty()) {
            $students = User::where('is_admin', false)
                ->where('email_notifications', true)
                ->get();

            foreach ($students as $student) {
                foreach ($newScholarships as $scholarship) {
                    if ($this->studentMatches($student, $scholarship)) {

                        $alreadyNotified = Notification::where('user_id', $student->id)
                            ->where('scholarship_id', $scholarship->id)
                            ->exists();

                        if ($alreadyNotified) continue;

                        $notification = Notification::create([
                            'user_id'        => $student->id,
                            'scholarship_id' => $scholarship->id,
                            'type'           => 'new_scholarship',
                            'is_read'        => false,
                            'email_sent'     => false,
                        ]);

                        try {
                            Mail::to($student->email)->send(new ScholarshipAlert($student, $scholarship));
                            $notification->update(['email_sent' => true]);
                            $emailsSent++;
                        } catch (\Exception $e) {
                            Log::error("Email failed for student {$student->id}: " . $e->getMessage());
                        }
                    }
                }
            }
        }

        $formattedSources = [];
        $totalFetched = 0;
        foreach ($results as $source => $result) {
            $formattedSources[] = [
                'source'  => strtoupper($source),
                'status'  => $result['status'],
                'fetched' => $result['fetched'] ?? 0,
                'created' => $result['created'] ?? 0,
                'updated' => $result['updated'] ?? 0,
                'error'   => $result['message'] ?? null,
            ];
            $totalFetched += $result['fetched'] ?? 0;
        }

        $totalCreated = array_sum(array_column($formattedSources, 'created'));
        $totalUpdated = array_sum(array_column($formattedSources, 'updated'));

        return response()->json([
            'success'       => true,
            'sources'       => $formattedSources,
            'total_fetched' => $totalFetched,
            'total_created' => $totalCreated,
            'total_updated' => $totalUpdated,
            'emails_sent'   => $emailsSent,
            'timestamp'     => now()->format('M d, Y h:i A'),
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // NOTIFY ALL STUDENTS — manual trigger by admin
    // Does NOT re-sync API data — just re-dispatches notifications
    // Skips students already notified for each scholarship (no duplicates)
    // ─────────────────────────────────────────────────────────────────────────
    public function notifyAll(): JsonResponse
    {
        $scholarships = Scholarship::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('deadline')->orWhere('deadline', '>=', now());
            })
            ->get();

        $students = User::where('is_admin', false)
            ->where('email_notifications', true)
            ->get();

        $notified  = 0;
        $skipped   = 0;
        $emailsSent = 0;

        foreach ($scholarships as $scholarship) {
            foreach ($students as $student) {
                if (!$this->studentMatches($student, $scholarship)) {
                    continue;
                }

                // Skip if already notified
                $alreadyNotified = Notification::where('user_id', $student->id)
                    ->where('scholarship_id', $scholarship->id)
                    ->exists();

                if ($alreadyNotified) {
                    $skipped++;
                    continue;
                }

                // Create notification record
                $notification = Notification::create([
                    'user_id'        => $student->id,
                    'scholarship_id' => $scholarship->id,
                    'type'           => 'new_scholarship',
                    'is_read'        => false,
                    'email_sent'     => false,
                ]);

                $notified++;

                // Send email - disabled for deployment
// try {
//     Mail::to($student->email)->send(new ScholarshipAlert($student, $scholarship));
//     $notification->update(['email_sent' => true]);
//     $emailsSent++;
// } catch (\Exception $e) {
//     Log::error("Notify All — email failed for student {$student->id}: " . $e->getMessage());
// }
            }
        }

        return response()->json([
            'success'     => true,
            'notified'    => $notified,
            'skipped'     => $skipped,
            'emails_sent' => $emailsSent,
            'message'     => $notified > 0
                ? "{$notified} student" . ($notified !== 1 ? 's' : '') . " notified. {$skipped} already up to date."
                : "All students are already up to date. No new notifications sent.",
        ]);
    }

    public function logs()
    {
        $logs            = SyncLog::latest()->paginate(20);
        $totalSyncs      = SyncLog::count();
        $successfulSyncs = SyncLog::where('status', 'success')->count();
        $failedSyncs     = SyncLog::where('status', 'failed')->count();
        $totalFetched    = SyncLog::sum('records_fetched');

        return view('admin.sync-logs', compact(
            'logs', 'totalSyncs', 'successfulSyncs', 'failedSyncs', 'totalFetched'
        ));
    }

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

        if ($scholarship->year_level && $student->year_level) {
            if ((int) $scholarship->year_level !== (int) $student->year_level) {
                return false;
            }
        }

        return true;
    }
}