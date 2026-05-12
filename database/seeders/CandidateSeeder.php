<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidate;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $putra = [
            'Nafiri Wahid Hidayat', 'Mohammad Sirojuddin', 'Achmadi', 'Alif Rafiansyah', 
            'Ach.Fauzi Bowo', 'Moh.Rafi\'i Rohman', 'Alfin Hidayatullah', 
            'Ach.Daris Rizqi Amrullah', 'Achmad Maulana', 'M.Pathan Agustiana'
        ];

        $putri = [
            'Shofiah Nuril Izzah', 'Anis Fitriya Oktafia', 'Khoiria Isnania Imami', 
            'Iklimatil Udhiyah', 'Siti Nur Musyafira', 'Meida Yanuarti Fariqoh', 
            'Azzahrah Rindu Ilahi', 'Ramadhani Gita Gunawan', 'Ikfina Aulina', 'Dewi Putri Kesha'
        ];

        foreach ($putra as $name) {
            Candidate::create([
                'name' => $name,
                'category' => 'putra',
                'description' => 'Kandidat Duta Kampus UIN Madura 2026 kategori Putra.',
                'total_votes' => rand(10, 50),
            ]);
        }

        foreach ($putri as $name) {
            Candidate::create([
                'name' => $name,
                'category' => 'putri',
                'description' => 'Kandidat Duta Kampus UIN Madura 2026 kategori Putri.',
                'total_votes' => rand(10, 50),
            ]);
        }
    }
}
