<?php

namespace App\Services;

use App\Mail\ScholarshipAlert;
use App\Models\Notification;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function notifyMatchingStudents(Scholarship $scholarship): void
    {
        $query = User::where('email_notifications', true)
            ->where('is_admin', false);

        if ($scholarship->minimum_gwa) {
            $query->where('gwa', '<=', $scholarship->minimum_gwa);
        }

        if ($scholarship->required_course) {
            $query->where('course', $scholarship->required_course);
        }

        if ($scholarship->municipality) {
            $query->where('municipality', $scholarship->municipality);
        }

        $users = $query->get();

        foreach ($users as $user) {
            $notification = Notification::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'scholarship_id' => $scholarship->id,
                ],
                [
                    'type' => 'new_scholarship',
                    'is_read' => false,
                    'email_sent' => false,
                ]
            );

            if (! $notification->email_sent) {
                try {
                    Mail::to($user->email)->send(new ScholarshipAlert($user, $scholarship));
                    $notification->update(['email_sent' => true]);
                } catch (\Exception $e) {
                    Log::error("Email failed for user {$user->id}: " . $e->getMessage());
                }
            }
        }
    }

    /**
     * Dispatch alerts for scholarships created or updated in the last 24 hours.
     */
    public function dispatchAlerts(): void
    {
        $cutoff = now()->subDay();
        $scholarships = Scholarship::where('created_at', '>=', $cutoff)
            ->orWhere('updated_at', '>=', $cutoff)
            ->get();

        foreach ($scholarships as $scholarship) {
            $query = User::where('email_notifications', true)
                ->where('is_admin', false);

            // Eligibility filters – only apply when the scholarship field is not null.
            if ($scholarship->minimum_gwa !== null) {
                $query->where('gwa', '<=', $scholarship->minimum_gwa);
            }
            if ($scholarship->required_course) {
                $query->where('course', $scholarship->required_course);
            }
            if ($scholarship->municipality) {
                $query->where('municipality', $scholarship->municipality);
            }

            $eligibleUsers = $query->get();

            foreach ($eligibleUsers as $user) {
                // Skip if a notification already exists for this user‑scholarship pair.
                $exists = Notification::where('user_id', $user->id)
                    ->where('scholarship_id', $scholarship->id)
                    ->exists();
                if ($exists) {
                    continue;
                }

                $notification = Notification::create([
                    'user_id' => $user->id,
                    'scholarship_id' => $scholarship->id,
                    'type' => 'new_scholarship',
                    'is_read' => false,
                    'email_sent' => false,
                ]);

                if ($user->email_notifications) {
                    try {
                        Mail::to($user->email)->send(new ScholarshipAlert($user, $scholarship));
                        $notification->update(['email_sent' => true]);
                    } catch (\Exception $e) {
                        Log::error("Email failed for user {$user->id}: " . $e->getMessage());
                    }
                }
            }
        }
    }
}