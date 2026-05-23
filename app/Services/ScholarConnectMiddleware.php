<?php
namespace App\Services;

use App\Models\Scholarship;
use App\Models\SyncLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScholarConnectMiddleware
{
   protected array $sources;

public function __construct()
{
    $baseUrl = env('MOCK_API_URL', 'http://mock-api:8080');
    $this->sources = [
        'ched' => "{$baseUrl}/api/ched",
        'dost' => "{$baseUrl}/api/dost",
        'lgu'  => "{$baseUrl}/api/lgu",
    ];
}
    public function fetchAll(): array
    {
        $results = [];
        foreach ($this->sources as $source => $url) {
            try {
                $response = Http::timeout(10)->get($url);
                $results[$source] = $response->json();
            } catch (\Exception $e) {
                Log::error("Failed to fetch from {$source}: " . $e->getMessage());
                $results[$source] = [];
            }
        }
        return $results;
    }

    public function syncAll(): void
    {
        $notificationService = app(NotificationService::class);

        foreach ($this->sources as $source => $url) {
            $synced = 0;

            try {
                $response = Http::timeout(10)->get($url);
                $data = $response->json();
                $scholarships = $data['scholarships'] ?? $data;

                foreach ($scholarships as $item) {
                    // --- R2 GUARD: skip if this source_url belongs to a manual entry ---
                    // (In practice manual entries have no source_url, so updateOrCreate
                    //  won't match them. This is an extra safety net.)
                    $existing = Scholarship::where('source_url', $item['source_url'] ?? null)->first();
                    if ($existing && $existing->source_type === 'manual') {
                        continue;
                    }

                    Scholarship::updateOrCreate(
                        ['source_url' => $item['source_url'] ?? null],
                        [
                            'title'            => $item['title'],
                            'provider'         => $item['provider'] ?? $source,
                            'description'      => $item['description'] ?? null,
                            'deadline'         => $item['deadline'] ?? null,
                            'minimum_gwa'      => $item['minimum_gwa'] ?? null,
                            'required_course'  => $item['required_course'] ?? null,
                            'municipality'     => $item['municipality'] ?? null,
                            'benefits'         => $item['benefits'] ?? null,
                            'application_link' => $item['application_link'] ?? null,
                            'source_type'      => 'api',   // always 'api' for synced records
                            'is_active'        => true,
                        ]
                    );
                    $synced++;
                }

                // Dispatch email notifications after sync
                $notificationService->dispatchAlerts();

                SyncLog::create([
                    'source'          => $source,
                    'status'          => 'success',
                    'records_fetched' => $synced,
                    'records_created' => $synced,
                    'records_updated' => 0,
                    'error_message'   => null,
                ]);

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
            }
        }
    }

    public function getSources(): array
    {
        return $this->sources;
    }
}