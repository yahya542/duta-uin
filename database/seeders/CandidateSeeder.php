<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidates = [
            [
                'name' => 'Ahmad Fauzi',
                'description' => 'Mewujudkan kampus digital yang inovatif dan inklusif bagi seluruh mahasiswa.',
                'total_votes' => 150,
                'percentage' => 45.5,
            ],
            [
                'name' => 'Siti Aminah',
                'description' => 'Meningkatkan kesejahteraan mahasiswa melalui kolaborasi industri dan riset.',
                'total_votes' => 120,
                'percentage' => 36.4,
            ],
            [
                'name' => 'Budi Santoso',
                'description' => 'Mengembangkan bakat minat mahasiswa dalam bidang seni dan olahraga prestasi.',
                'total_votes' => 60,
                'percentage' => 18.2,
            ],
        ];

        foreach ($candidates as $candidate) {
            \App\Models\Candidate::create($candidate);
        }
    }
}
