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
        $uri = base_path('src/'. ucfirst($this->argument('context')) .'/'. ucfirst($this->argument('entity')));
        $this->info('Creando estructura...');

        File::makeDirectory($uri . '/Domain', 0755, true, true);
        $this->info($uri . '/Domain');

        File::makeDirectory($uri . '/Domain/Entities', 0755, true, true);
        $this->info($uri . '/Domain/Entities');

        File::makeDirectory($uri . '/Domain/ValueObjects', 0755, true, true);
        $this->info($uri . '/Domain/ValueObjects');

        File::makeDirectory($uri . '/Domain/Contracts', 0755, true, true);
        $this->info($uri . '/Domain/Contracts');

        File::makeDirectory($uri . '/Application', 0755, true, true);
        $this->info($uri . '/Application');

        File::makeDirectory($uri . '/Application/UseCase', 0755, true, true);
         $this->info($uri . '/Application/UseCase');
 
         File::makeDirectory($uri . '/Application/DTO', 0755, true, true);
         $this->info($uri . '/Application/DTO');

        File::makeDirectory($uri . '/Infrastructure', 0755, true, true);
        $this->info($uri . '/Infrastructure');

        File::makeDirectory($uri . '/Infrastructure/Controllers', 0755, true, true);
        $this->info($uri . '/Infrastructure/Controllers');

        File::makeDirectory($uri . '/Infrastructure/Routes', 0755, true, true);
        $this->info($uri . '/Infrastructure/routes');

        File::makeDirectory($uri . '/Infrastructure/Validators', 0755, true, true);
        $this->info($uri . '/Infrastructure/Validators');

        File::makeDirectory($uri . '/Infrastructure/Repositories', 0755, true, true);
        $this->info($uri . '/Infrastructure/Repositories');

        File::makeDirectory($uri . '/Infrastructure/Mappers', 0755, true, true);
        $this->info($uri . '/Infrastructure/Mappers');

        // api.php
        $content = "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\nuse Src\\" . ucfirst($this->argument('context')) . "\\" . ucfirst($this->argument('entity')) . "\\Infrastructure\\Controllers\\" . ucfirst($this->argument('entity')) . "Controller;\n\n";
        $content .= "Route::prefix('" . strtolower($this->argument('entity')) . "')->controller(" . ucfirst($this->argument('entity')) . "Controller::class)->group(function () {\n\n});";
        File::put($uri . '/Infrastructure/Routes/api.php', $content);
        $this->info('Archivo de rutas añadido en ' . $uri . '/Infrastructure/Routes/api.php');

        // local api.php added to main api.php
        $routesFile = base_path('routes/api.php');
        $contextGroup = "Route::group([], function () { // " . ucfirst($this->argument('context'));
        $requireRoute = "    require base_path('src/" . ucfirst($this->argument('context')) . "/" . ucfirst($this->argument('entity')) . "/Infrastructure/Routes/api.php');";
        $content = File::get($routesFile);
        if (strpos($content, $requireRoute) === false) {
            if (strpos($content, $contextGroup) !== false) {
                // Si el grupo del contexto ya existe, agrega la nueva ruta dentro
                $updatedContent = preg_replace(
                    "/(Route::group\(\[\], function \(\) \{ \/\/ " . ucfirst($this->argument('context')) . "\n)(.*?)\n\}\);/s",
                    "$1$2\n$requireRoute\n});",
                    $content
                );
            } else {
                // Si el grupo del contexto no existe, lo crea y añade la entidad
                $updatedContent = $content . "\n\n$contextGroup\n$requireRoute\n});";
            }
            File::put($routesFile, $updatedContent);
            $this->info('Módulo de rutas referenciado en el archivo api.php de routes.');
        }
        
        // EntityController.php
        $controllerName = ucfirst($this->argument('entity')) . 'Controller';
        $content = "<?php\n\nnamespace Src\\" . ucfirst($this->argument('context'))."\\".ucfirst($this->argument('entity'))."\\Infrastructure\\Controllers;\n\nuse App\\Http\\Controllers\\Controller;\n\nfinal class $controllerName extends Controller { \n\n public function index() { \n // TODO: DDD Controller content here \n }\n}";
        File::put($uri.'/Infrastructure/Controllers/' . $controllerName . '.php', $content);
        $this->info('Controlador añadido');

        $this->info('Estructura ' . $this->argument('entity') . ' DDD creada correctamente.');

        return Command::SUCCESS;
    }
}