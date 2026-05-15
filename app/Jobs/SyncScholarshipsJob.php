<?php

namespace App\Jobs;

use App\Models\Scholarship;
use App\Models\SyncLog;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncScholarshipsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $source;
    protected string $url;

    public function __construct(string $source, string $url)
    {
        $this->source = $source;
        $this->url    = $url;
    }

    public function handle(NotificationService $notificationService): void
    {
        $created = 0;
        $updated = 0;
        $fetched = 0;

        try {
            $response = Http::timeout(10)->get($this->url);
            if (! $response->successful()) {
                throw new \Exception('HTTP error: ' . $response->status());
            }
            $data     = $response->json();
            $fetched  = count($data);

            foreach ($data as $item) {
                $exists = Scholarship::where('source_url', $item['source_url'])->exists();

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
                        'is_active'        => $item['is_active'] ?? true,
                    ]
                );

                if (!$exists) {
                    $created++;
                    $notificationService->notifyMatchingStudents(
                        Scholarship::where('source_url', $item['source_url'])->first()
                    );
                } else {
                    $updated++;
                }
            }

            SyncLog::create([
                'source'          => $this->source,
                'records_fetched' => $fetched,
                'records_created' => $created,
                'records_updated' => $updated,
                'status'          => 'success',
            ]);

        } catch (\Exception $e) {
            Log::error("SyncScholarshipsJob failed for {$this->source}: " . $e->getMessage());

            SyncLog::create([
                'source'          => $this->source,
                'records_fetched' => $fetched,
                'records_created' => $created,
                'records_updated' => $updated,
                'status'          => 'failed',
                'error_message'   => $e->getMessage(),
            ]);
        }
    }
}