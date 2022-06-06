<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeBladeCommand extends Command
{
    protected $signature = 'make:blade {model}';

    protected $description = 'Make Blade Files Command';

    public function handle()
    {
        $model = $this->argument('model');

        $plural = Str::plural($model);

        $path = base_path(self::normalize_path('resources/views/' . $plural));

        (new Filesystem)->ensureDirectoryExists($path,0777);

        self::createBladeFiles($plural);

        $this->info('Files created Successfully');
    }

    private static function createBladeFiles($folder)
    {
        $index  = __DIR__ . '/../../../resources/views/default/index.blade.php';
        $create = __DIR__ . '/../../../resources/views/default/create.blade.php';
        $edit   = __DIR__ . '/../../../resources/views/default/edit.blade.php';
        $form   = __DIR__ . '/../../../resources/views/default/form.blade.php';

        copy($index, resource_path(self::normalize_path('views/' . $folder . '/index.blade.php')));
        copy($create, resource_path(self::normalize_path('views/' . $folder . '/create.blade.php')));
        copy($edit, resource_path(self::normalize_path('views/' . $folder . '/edit.blade.php')));
        copy($form, resource_path(self::normalize_path('views/' . $folder . '/form.blade.php')));
    }

    private static function normalize_path($path)
    {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }
}
