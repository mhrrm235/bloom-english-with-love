<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\User;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $instructor = User::whereHas('role', fn($q) => $q->where('name', 'instructor'))->first()
                     ?? User::first();

        $course1 = Course::firstOrCreate(
            ['slug' => 'mastering-business-english-speaking'],
            [
                'instructor_id' => $instructor->id,
                'title' => 'Mastering Business English Speaking',
                'description' => 'Tingkatkan rasa percaya diri dan aksen profesional Anda dalam berkomunikasi bisnis, presentasi, dan negosiasi internasional.',
                'level' => 'Intermediate',
                'is_published' => true,
            ]
        );

        CourseMaterial::firstOrCreate(
            ['course_id' => $course1->id, 'order_sequence' => 1],
            [
                'title' => 'Introduction to Professional English Tone',
                'content' => 'Dalam modul ini, kita akan mempelajari perbedaan formal, semi-formal, dan informal tone saat berbicara dengan klien luar negeri.',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ]
        );

        CourseMaterial::firstOrCreate(
            ['course_id' => $course1->id, 'order_sequence' => 2],
            [
                'title' => 'Handling Q&A Sessions in International Meetings',
                'content' => 'Strategi menjawab pertanyaan sulit dengan diplomatis dan percaya diri dalam bahasa Inggris.',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ]
        );

        $course2 = Course::firstOrCreate(
            ['slug' => 'english-grammar-foundations-for-beginners'],
            [
                'instructor_id' => $instructor->id,
                'title' => 'English Grammar Foundations for Beginners',
                'description' => 'Pahami struktur dasar tenses, susunan kalimat, dan tata bahasa Inggris tanpa kebingungan.',
                'level' => 'Beginner',
                'is_published' => true,
            ]
        );

        CourseMaterial::firstOrCreate(
            ['course_id' => $course2->id, 'order_sequence' => 1],
            [
                'title' => 'Simple Present vs Present Continuous Tense',
                'content' => 'Pelajari penggunaan tenses sehari-hari dengan rumus intuitif dan contoh kontekstual.',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ]
        );
    }
}
