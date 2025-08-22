<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WorkExperience;

class WorkExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the existing artist user
        $artist = User::where('email', 'sarah@example.com')->first();

        if ($artist) {
            // Create sample work experiences for the artist
            WorkExperience::create([
                'user_id' => $artist->id,
                'company_name' => 'Café Bella Vista',
                'position' => 'Mural Artist',
                'description' => 'Designed and painted a large-scale nature-themed mural for the restaurant\'s main dining area. The project involved creating a 20ft x 15ft wall painting featuring local flora and fauna, completed within 3 weeks.',
                'project_type' => 'Restaurant Wall Painting',
                'location' => 'Downtown, City Center',
                'start_date' => '2024-01-15',
                'end_date' => '2024-02-05',
                'is_current' => false,
            ]);

            WorkExperience::create([
                'user_id' => $artist->id,
                'company_name' => 'TechStart Inc.',
                'position' => 'Digital Illustrator',
                'description' => 'Created digital illustrations and graphics for the company\'s marketing materials, website, and mobile app. Worked closely with the design team to maintain brand consistency across all platforms.',
                'project_type' => 'Digital Art & Branding',
                'location' => 'Remote',
                'start_date' => '2023-06-01',
                'end_date' => '2024-01-31',
                'is_current' => false,
            ]);

            WorkExperience::create([
                'user_id' => $artist->id,
                'company_name' => 'Local Art Gallery',
                'position' => 'Freelance Artist',
                'description' => 'Currently working on commissioned pieces for private clients and participating in local art exhibitions. Specializing in digital art and traditional watercolor techniques.',
                'project_type' => 'Commissioned Artwork',
                'location' => 'Local Community',
                'start_date' => '2024-03-01',
                'end_date' => null,
                'is_current' => true,
            ]);

            $this->command->info('Work experience data created successfully!');
        } else {
            $this->command->error('Artist user not found. Please run TestDataSeeder first.');
        }
    }
}
