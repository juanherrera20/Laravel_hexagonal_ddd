<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DDDStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:ddd {context : The bounded context, such as admin, lms or job_request} {entity : The entity to create the DDD structure, books for example}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea la estructura básica de la arquitectura hexagonal para una entidad de un contexto en específico';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $uri = base_path('src/'. $this->argument('context') .'/'. $this->argument('entity'));
        $this->info('Creando estructura...');

        File::makeDirectory($uri . '/domain', 0755, true, true);
        $this->info($uri . '/domain');

        File::makeDirectory($uri . '/domain/entities', 0755, true, true);
        $this->info($uri . '/domain/entities');

        File::makeDirectory($uri . '/domain/value_objects', 0755, true, true);
        $this->info($uri . '/domain/valueObjects');

        File::makeDirectory($uri . '/domain/contracts', 0755, true, true);
        $this->info($uri . '/domain/contracts');

        File::makeDirectory($uri . '/application', 0755, true, true);
        $this->info($uri . '/application');

        File::makeDirectory($uri . '/infrastructure', 0755, true, true);
        $this->info($uri . '/infrastructure');

        File::makeDirectory($uri . '/infrastructure/controllers', 0755, true, true);
        $this->info($uri . '/infrastructure/controllers');

        File::makeDirectory($uri . '/infrastructure/routes', 0755, true, true);
        $this->info($uri . '/infrastructure/routes');

        File::makeDirectory($uri . '/infrastructure/validators', 0755, true, true);
        $this->info($uri . '/infrastructure/validators');

        File::makeDirectory($uri . '/infrastructure/repositories', 0755, true, true);
        $this->info($uri . '/infrastructure/repositories');

        File::makeDirectory($uri . '/infrastructure/listeners', 0755, true, true);
        $this->info($uri . '/infrastructure/listeners');

        File::makeDirectory($uri . '/infrastructure/events', 0755, true, true);
        $this->info($uri . '/infrastructure/events');

        // api.php
        $content = "<?php\n\nuse Src\\".$this->argument('context')."\\".$this->argument('entity')."\\infrastructure\controllers\\" . ucfirst($this->argument('entity')) . "Controller;";
        File::put($uri . '/infrastructure/routes/api.php', $content);
        $this->info('Archivo de rutas añadido en ' . $uri . 'infrastructure/routes/api.php' );

        // local api.php added to main api.php
        $content = "\nRoute::prefix('" . $this->argument('entity') . "')->group(base_path('src/". $this->argument('context') . "/" .$this->argument('entity') ."/infrastructure/routes/api.php'));\n";
        File::append(base_path('routes/api.php'), $content);
        $this->info('Modulo de rutas referenciado en el archivo api.php de routes.');

        // EntityController.php
        $controllerName = ucfirst($this->argument('entity')) . 'Controller';
        $content = "<?php\n\nnamespace Src\\" . $this->argument('context')."\\".$this->argument('entity')."\\infrastructure\\controllers;\n\nuse App\\Http\\Controllers\\Controller;\n\nfinal class $controllerName extends Controller { \n\n public function index() { \n // TODO: DDD Controller content here \n }\n}";
        File::put($uri.'/infrastructure/controllers/' . $controllerName . '.php', $content);
        $this->info('Controlador añadido');

        $this->info('Estructura ' . $this->argument('entity') . ' DDD creada correctamente.');

        return Command::SUCCESS;
    }
}