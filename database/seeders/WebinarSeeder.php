<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Webinar;
use App\Models\User;

class WebinarSeeder extends Seeder
{
    public function run(): void
    {
        $instructor = User::whereHas('role', fn($q) => $q->where('name', 'instructor'))->first()
                     ?? User::first();

        Webinar::firstOrCreate(
            ['slug' => 'unlocking-ielts-speaking-band-8-strategies'],
            [
                'instructor_id' => $instructor->id,
                'title' => 'Unlocking IELTS Speaking Band 8+ Strategies',
                'description' => 'Webinar interaktif eksklusif mengupas rahasia lancar ujian IELTS Speaking bersama instruktur berpengalaman.',
                'schedule_time' => now()->addDays(3)->setHour(19)->setMinute(0),
                'duration_minutes' => 90,
                'meeting_link' => 'https://zoom.us/j/1234567890?pwd=bloomenglishlove',
                'max_participants' => 100,
                'status' => 'upcoming',
            ]
        );

        Webinar::firstOrCreate(
            ['slug' => 'confidence-in-public-speaking-with-love'],
            [
                'instructor_id' => $instructor->id,
                'title' => 'Building Confidence in English Public Speaking',
                'description' => 'Bagaimana mengatasi ketakutan dan anxiety saat berbicara di depan umum menggunakan bahasa Inggris.',
                'schedule_time' => now()->addDays(7)->setHour(14)->setMinute(0),
                'duration_minutes' => 60,
                'meeting_link' => 'https://meet.google.com/abc-defg-hij',
                'max_participants' => 50,
                'status' => 'upcoming',
            ]
        );
    }
}
