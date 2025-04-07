<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DDDEntity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:entityddd {context} {entity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea la entidad de un contexto en específico';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $uri = base_path('src/'. ucfirst($this->argument('context')) .'/'. ucfirst($this->argument('entity')).'/Domain/Entities');
        File::makeDirectory($uri, 0755, true, true);
        $this->info("Creación del modelo {$this -> argument('entity')} ".$uri);
        $filename = ucfirst($this -> argument('entity'));
        $contextname = ucfirst($this -> argument('context'));
        $content = "<?php\n\nnamespace Src\\" . $contextname . "\\" . $filename . "\\Domain\\Entities;\n\nclass " . ucfirst($this->argument('entity')) . "\n{\n    //\n}";
        File::put($uri . "/{$filename}.php", $content);
        $this->info('Modelo creado en ' . $uri . "/{$filename}.php" );

        return Command::SUCCESS;
    }
}
