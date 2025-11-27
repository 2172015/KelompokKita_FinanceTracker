<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Event;
use App\Models\EventSession;
use App\Models\Registration;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin Event',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        // Member
        $member = User::create([
            'name' => 'Member Satu',
            'email' => 'member@example.com',
            'password' => Hash::make('123456'),
            'role' => 'member',
        ]);

        // Create Event
        $event = Event::create([
            'title' => 'Seminar Teknologi Informatika',
            'description' => 'Seminar tentang perkembangan teknologi terkini.',
            'location' => 'Aula Universitas',
            'price' => 50000,
            'quota' => 300,
            'start_date' => now()->addDays(3),
            'end_date' => now()->addDays(3),
        ]);

        // Sessions
        $s1 = EventSession::create([
            'event_id' => $event->id,
            'name' => 'Pembukaan & Keynote Speaker',
            'start_time' => '09:00',
            'end_time' => '10:30',
        ]);

        $s2 = EventSession::create([
            'event_id' => $event->id,
            'name' => 'Sesi Panel Diskusi',
            'start_time' => '10:45',
            'end_time' => '12:00',
        ]);

        // Registration
        $reg = Registration::create([
            'event_id' => $event->id,
            'user_id' => $member->id,
            'payment_status' => 'disetujui',
            'qr_code_path' => 'dummy_qr.png',
        ]);
    }
}
