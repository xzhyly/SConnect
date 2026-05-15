<?php
namespace App\Services;

use App\Models\Scholarship;
use App\Models\SyncLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScholarConnectMiddleware
{
    protected array $sources = [
        'ched' => 'http://mock-api:8080/api/ched',
        'dost' => 'http://mock-api:8080/api/dost',
        'lgu'  => 'http://mock-api:8080/api/lgu',
    ];

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
                    Scholarship::updateOrCreate(
                        ['source_url' => $item['source_url']],
                        [
                            'title'            => $item['title'],
                            'provider'         => $item['provider'],
                            'description'      => $item['description'] ?? null,
                            'deadline'         => $item['deadline'] ?? null,
                            'minimum_gwa'      => $item['minimum_gwa'] ?? null,
                            'required_course'  => $item['required_course'] ?? null,
                            'municipality'     => $item['municipality'] ?? null,
                            'benefits'         => $item['benefits'] ?? null,
                            'application_link' => $item['application_link'] ?? null,
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