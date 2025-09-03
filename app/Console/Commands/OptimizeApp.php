<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize the application for better performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Optimizing ArtConnect application...');

        // Clear all caches first
        $this->call('cache:clear');
        $this->call('view:clear');
        $this->call('config:clear');
        $this->call('route:clear');

        // Optimize autoloader
        $this->info('📦 Optimizing Composer autoloader...');
        exec('composer dump-autoload --optimize');

        // Cache configurations
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');

        // Cache events and discovery
        $this->call('event:cache');
        
        $this->info('✅ Application optimization completed!');
        $this->info('🎯 Your app should now run faster!');

        return 0;
    }
}
