<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $client = User::firstOrCreate(
            ['email' => 'client@garudahub.id'],
            [
                'name'     => 'PT Nusantara Digital (Client)',
                'password' => Hash::make('password'),
                'role'     => 'client',
            ]
        );

        $freelancer1 = User::firstOrCreate(
            ['email' => 'caesya@garudahub.id'],
            [
                'name'     => 'Caesya Valenzi (Freelancer)',
                'password' => Hash::make('password'),
                'role'     => 'freelancer',
            ]
        );

        User::firstOrCreate(
            ['email' => 'andi@garudahub.id'],
            [
                'name'     => 'Andi Pratama (Freelancer)',
                'password' => Hash::make('password'),
                'role'     => 'freelancer',
            ]
        );

        $project = Project::firstOrCreate(
            ['title' => 'Pembuatan Sistem Informasi Akademik Kampus'],
            [
                'user_id'     => $client->id,
                'description' => 'Membutuhkan developer Laravel untuk membangun portal KRS dan nilai mahasiswa berbasis web.',
                'budget'      => 5000000,
                'deadline'    => now()->addDays(30)->format('Y-m-d'),
                'status'      => 'open',
            ]
        );

        $project->bids()->firstOrCreate(
            ['user_id' => $freelancer1->id],
            [
                'amount'   => 4500000,
                'proposal' => 'Saya berpengalaman membangun aplikasi Laravel + MySQL dan siap menyelesaikan dalam 3 minggu.',
                'status'   => 'pending',
            ]
        );
    }
}