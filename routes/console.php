<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('clear:all', function () {
    $this->info('Clearing config cache...');
    Artisan::call('config:clear');
    $this->info(Artisan::output());

    $this->info('Clearing application cache...');
    Artisan::call('cache:clear');
    $this->info(Artisan::output());

    $this->info('Clearing route cache...');
    Artisan::call('route:clear');
    $this->info(Artisan::output());

    $this->info('Clearing view cache...');
    Artisan::call('view:clear');
    $this->info(Artisan::output());

    $this->info('All caches cleared!');
})->purpose('Clear config, cache, route, and view caches for development');

Artisan::command('storage:clear', function () {
    $path = public_path('storage');

    if (!File::exists($path)) {
        $this->error('storage folder not found');
        return;
    }

    File::deleteDirectory($path);
    File::makeDirectory($path, 0755, true);

    $this->info('All files in public/storage deleted');
})->purpose('Delete ALL files in public/storage');


Artisan::command('local:first', function () {
    // Copy .env if not exists
    if (!file_exists(base_path('.env'))) {
        copy(base_path('.env.example'), base_path('.env'));
        $this->info('.env file created');

        // Generate APP_KEY
        $this->info('Generating APP_KEY...');
        Artisan::call('key:generate');
        $this->info(Artisan::output());
    } else {
        $this->comment('.env already exists');
    }

    // Composer install
    $this->info('Installing composer dependencies...');
    exec('composer install', $composerOutput);
    $this->line(implode("\n", $composerOutput));

    // Migrations
    $this->info('Running migrations...');
    Artisan::call('migrate', ['--force' => true]);
    $this->info(Artisan::output());

    // Seed database
    $this->info('Seeding database...');
    Artisan::call('db:seed', ['--force' => true]);
    $this->info(Artisan::output());

    // Storage link
    $this->info('Linking storage...');
    Artisan::call('storage:link');
    $this->info(Artisan::output());

    // NPM install
    $this->info('Installing npm packages...');
    exec('npm install', $npmOutput);
    $this->line(implode("\n", $npmOutput));

    // Build assets
    $this->info('Building frontend assets...');
    exec('npm run build', $buildOutput);
    $this->line(implode("\n", $buildOutput));

    $this->info('Full local setup complete!');
})->purpose('Setup Laravel project: copy .env, install composer, migrate, seed, link storage, npm install & build');
