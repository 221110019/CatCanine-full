<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Artisan::command('custom:clear', function () {
    $this->question('Clearing config cache...');
    Artisan::call('config:clear');
    $this->line(Artisan::output());

    $this->question('Clearing application cache...');
    Artisan::call('cache:clear');
    $this->line(Artisan::output());

    $this->question('Clearing route cache...');
    Artisan::call('route:clear');
    $this->line(Artisan::output());

    $this->question('Clearing view cache...');
    Artisan::call('view:clear');
    $this->line(Artisan::output());

    $this->info('✅ All caches cleared!');
})->purpose('Clear config, cache, route, and view caches for development');

Artisan::command('custom:storage', function () {

    if (! $this->confirm('This will DELETE storage/app/public/posts and public/storage. Continue?')) {
        $this->error('Aborted!');
        return;
    }

    $realPath = storage_path('app/public/posts');
    if (File::exists($realPath)) {
        File::deleteDirectory($realPath);
        $this->question('File removed...');
    }

    $this->question('Unlink storage...');
    $publicStorage = public_path('storage');
    if (is_link($publicStorage) || File::exists($publicStorage)) {
        File::deleteDirectory($publicStorage);
        $this->question('Unlink...');
    }

    $this->question('Link storage...');
    Artisan::call('storage:link');
    $this->line(Artisan::output());
    $this->alert('✅ Folder storage/app/public/posts and public/storage reset success!');
})->purpose('Reset uploaded posts storage');


Artisan::command('custom:setup', function () {
    $this->question('Do you want to install composer dependencies?');
    if ($this->confirm('Run composer install?', true)) {
        $this->question('Installing composer dependencies...');
        exec('composer install', $out, $code);
        if ($code !== 0) return $this->error('Composer install failed');
    }

    if (!file_exists(base_path('.env'))) {
        copy(base_path('.env.example'), base_path('.env'));
        $this->info('.env created');
    }

    $this->question('Generating APP_KEY...');
    Artisan::call('key:generate');
    $this->line(Artisan::output());

    $this->question('Running migrations...');
    Artisan::call('migrate', ['--force' => true]);
    $this->line(Artisan::output());

    $this->question('Seeding database...');
    Artisan::call('db:seed');
    $this->line(Artisan::output());

    $this->question('Linking storage...');
    Artisan::call('storage:link');

    $this->question('Installing frontend dependencies...');
    exec('npm install', $o, $c);
    if ($c !== 0) return $this->error('npm install failed');
    $this->question('Building frontend assets...');
    exec('npm run build', $o2, $c2);
    if ($c2 !== 0) return $this->error('npm build failed');
    $this->info('✅ Local setup complete!');
})->purpose('One-command local Laravel setup after clone');
