<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\WordImporter;
use App\Services\Wordbase\RemoteFileImporter;

class WordImporterProvider extends ServiceProvider
{
    /**
     * Register bindings.
     */
    public $bindings = [
        WordImporter::class => RemoteFileImporter::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(RemoteFileImporter::class)
            ->needs('$url')
            ->give(config('services.remote_word_importer.url', null));
    }
}