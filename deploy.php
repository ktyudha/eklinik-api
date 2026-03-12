<?php

namespace Deployer;

require 'recipe/laravel.php';

// ─── Konfigurasi Project ──────────────────────────────────────────────────────
set('application', 'api-eklinik.inb.my.id');
set('repository', 'git@github.com:ktyudha/eklinik-api.git');
set('git_tty', false);
set('keep_releases', 5);  // simpan 5 release terakhir untuk rollback
set('writable_mode', 'chmod');

// ─── Shared files & dirs (antar release) ─────────────────────────────────────
set('shared_files', [
    '.env',
]);

set('shared_dirs', [
    'storage',
]);

set('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

// ─── Server Production (main) ─────────────────────────────────────────────────
host('production')
    ->set('hostname', '127.0.0.1')   // lokal karena pakai self-hosted runner
    ->set('remote_user', 'inbework')
    ->set('branch', 'main')
    ->set('deploy_path', '/var/www/api-eklinik.inb.my.id')
    ->set('labels', ['stage' => 'production']);

// ─── Server Staging (develop) ────────────────────────────────────────────────
host('staging')
    ->set('hostname', '127.0.0.1')
    ->set('remote_user', 'inbework')
    ->set('branch', 'develop')
    ->set('deploy_path', '/var/www/api-eklinik-dev.inb.my.id')
    ->set('labels', ['stage' => 'staging']);

// ─── Tasks ───────────────────────────────────────────────────────────────────

// Composer install tanpa dev dependencies
task('deploy:composer', function () {
    run('cd {{release_path}} && composer install --no-dev --optimize-autoloader --no-interaction');
});

// Jalankan artisan commands
task('artisan:commands', function () {
    run('cd {{release_path}} && php artisan migrate --force');
    run('cd {{release_path}} && php artisan optimize:clear');
    run('cd {{release_path}} && php artisan optimize');
    run('cd {{release_path}} && php artisan storage:link || true');
    run('cd {{release_path}} && php artisan queue:restart || true');
});

// ─── Deploy Flow ──────────────────────────────────────────────────────────────
task('deploy', [
    'deploy:prepare',
    'deploy:composer',
    'artisan:commands',
    'deploy:publish',
]);

// Kalau deploy gagal, rollback otomatis
after('deploy:failed', 'deploy:unlock');
