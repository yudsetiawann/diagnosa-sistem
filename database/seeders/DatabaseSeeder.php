<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Disease;
use App\Models\Patient;
use App\Models\Symptom;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Ardeco',
            'email' => 'deco@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory(40)->create();

        // --- Data Gejala Realistis ---
        $symptomsData = [
            ['name' => 'Demam', 'description' => 'Suhu tubuh di atas 37.5°C'],
            ['name' => 'Batuk Kering', 'description' => 'Batuk tanpa dahak'],
            ['name' => 'Sakit Tenggorokan', 'description' => 'Nyeri atau gatal di tenggorokan'],
            ['name' => 'Hidung Tersumbat', 'description' => 'Kesulitan bernapas melalui hidung'],
            ['name' => 'Pilek', 'description' => 'Keluarnya lendir dari hidung'],
            ['name' => 'Sakit Kepala', 'description' => 'Nyeri di bagian kepala'],
            ['name' => 'Nyeri Otot', 'description' => 'Pegal-pegal pada tubuh'],
            ['name' => 'Kelelahan', 'description' => 'Rasa lemas dan kurang energi'],
            ['name' => 'Mual', 'description' => 'Perasaan ingin muntah'],
            ['name' => 'Diare', 'description' => 'Buang air besar encer'],
            ['name' => 'Sesak Napas', 'description' => 'Kesulitan bernapas'],
            ['name' => 'Ruam Kulit', 'description' => 'Kemerahan atau bintik di kulit'],
        ];
        foreach ($symptomsData as $s) {
            Symptom::create($s);
        }
        // Tambah 25 gejala acak lagi
        for ($i = 0; $i < 25; $i++) {
            Symptom::create(['name' => 'Gejala ' . fake()->unique()->word(), 'description' => fake()->sentence()]);
        }

        // --- Data Penyakit Realistis ---
        $diseasesData = [
            ['name' => 'Influenza (Flu)', 'description' => 'Infeksi virus pada sistem pernapasan.'],
            ['name' => 'Tonsilitis (Radang Amandel)', 'description' => 'Peradangan pada amandel.'],
            ['name' => 'Covid-19', 'description' => 'Penyakit akibat virus SARS-CoV-2.'],
            ['name' => 'Common Cold (Pilek Biasa)', 'description' => 'Infeksi virus ringan.'],
            ['name' => 'Gastroenteritis (Flu Perut)', 'description' => 'Peradangan pada lambung dan usus.'],
        ];
        foreach ($diseasesData as $d) {
            Disease::create($d);
        }
        // Tambah 30 penyakit acak lagi
        for ($i = 0; $i < 30; $i++) {
            Disease::create(['name' => 'Penyakit ' . fake()->unique()->word(), 'description' => fake()->sentence()]);
        }

        // --- Hubungkan Relasi Many-to-Many ---
        $symptomCache = Symptom::pluck('id', 'name');

        $flu = Disease::where('name', 'Influenza (Flu)')->first();
        $flu->symptoms()->attach([
            $symptomCache['Demam'],
            $symptomCache['Batuk Kering'],
            $symptomCache['Sakit Kepala'],
            $symptomCache['Nyeri Otot']
        ]);

        $tonsilitis = Disease::where('name', 'Tonsilitis (Radang Amandel)')->first();
        $tonsilitis->symptoms()->attach([
            $symptomCache['Sakit Tenggorokan'],
            $symptomCache['Demam']
        ]);

        $cold = Disease::where('name', 'Common Cold (Pilek Biasa)')->first();
        $cold->symptoms()->attach([
            $symptomCache['Pilek'],
            $symptomCache['Hidung Tersumbat'],
            $symptomCache['Sakit Tenggorokan']
        ]);

        $covid = Disease::where('name', 'Covid-19')->first();
        $covid->symptoms()->attach([
            $symptomCache['Demam'],
            $symptomCache['Batuk Kering'],
            $symptomCache['Sesak Napas'],
            $symptomCache['Kelelahan']
        ]);

        // Hubungkan data acak lainnya
        $allSymptoms = Symptom::all();
        $allDiseases = Disease::whereNotIn('name', ['Influenza (Flu)', 'Tonsilitis (Radang Amandel)', 'Common Cold (Pilek Biasa)', 'Covid-19'])->get();

        foreach ($allDiseases as $disease) {
            $disease->symptoms()->attach(
                $allSymptoms->random(rand(2, 5))->pluck('id')->toArray()
            );
        }
    }
}
