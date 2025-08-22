<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Artwork;
use App\Models\ArtworkRating;
use App\Models\Commission;
use App\Models\ArtworkLike;
use App\Models\Comment;
use App\Models\WorkExperience;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test artist user
        $artist = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@example.com',
            'password' => Hash::make('password123'),
            'role' => 'artist',
            'bio' => 'Passionate digital artist with 5+ years of experience creating stunning illustrations and concept art. I specialize in fantasy and sci-fi themes, bringing imagination to life through vibrant colors and intricate details.',
            'profile_picture' => 'profile-pictures/sarah.jpg',
        ]);

        // Create test client user
        $client = User::create([
            'name' => 'Michael Chen',
            'email' => 'michael@example.com',
            'password' => Hash::make('password123'),
            'role' => 'client',
            'bio' => 'Creative director looking for talented artists to collaborate on exciting projects. I love discovering new artistic styles and supporting emerging artists.',
            'profile_picture' => 'profile-pictures/michael.jpg',
        ]);

        // Create sample artworks for the artist
        $artworkTitles = [
            'Mystical Forest',
            'Cyberpunk Cityscape',
            'Ocean Dreams',
            'Desert Sunset',
            'Floating Islands',
            'Neon Lights'
        ];

        $categories = ['digital', 'traditional', 'oil', 'watercolor', 'glass painting', 'sketches'];

        $artworks = [];
        foreach ($artworkTitles as $index => $title) {
            $artwork = Artwork::create([
                'user_id' => $artist->id,
                'title' => $title,
                'description' => 'A beautiful piece showcasing artistic creativity and technical skill.',
                'category' => $categories[$index % count($categories)],
                'image' => 'artworks/sample-' . ($index + 1) . '.jpg', // Placeholder path
            ]);
            $artworks[] = $artwork;
        }

        // Add sample commissions for the artworks
        $commissionRatings = [5, 4, 5, 4, 5, 4]; // Sample commission ratings
        foreach ($artworks as $index => $artwork) {
            // Create commission
            Commission::create([
                'client_id' => $client->id,
                'artist_id' => $artist->id,
                'artwork_id' => $artwork->id,
                'status' => 'completed',
                'price' => rand(50, 500),
                'description' => 'Commission for ' . $artwork->title,
                'rating' => $commissionRatings[$index % count($commissionRatings)],
                'review' => 'Amazing work! Love the creativity and attention to detail.',
            ]);

            // Add likes to artworks
            ArtworkLike::create([
                'user_id' => $client->id,
                'artwork_id' => $artwork->id,
            ]);

            // Add comments to artworks
            Comment::create([
                'user_id' => $client->id,
                'artwork_id' => $artwork->id,
                'content' => 'Beautiful work! I love the style and colors.',
            ]);
        }

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

        $this->command->info('Test data created successfully!');
        $this->command->info('Artist: sarah@example.com / password123');
        $this->command->info('Client: michael@example.com / password123');
    }
}
