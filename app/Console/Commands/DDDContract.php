<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DDDContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:contractddd {context} {entity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea la interface de los contratos de las funcionalidades que se implementarán más adelante';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $uri = base_path('src/'. $this->argument('context') .'/'. $this->argument('entity').'/domain/contracts');
        File::makeDirectory($uri, 0755, true, true);
        $this->info("Creación del contrato {$this -> argument('entity')} ".$uri);
        $filename = ucfirst($this -> argument('entity'));
        $contextname = ucfirst($this -> argument('context'));
        $content = "<?php\n\ndeclare(strict_types=1);\n\nnamespace Src\\" . $contextname . "\\" . $filename . "\\Domain\\Contracts;\n\ninterface " . ucfirst($this->argument('entity')) . "RepositoryContract\n{\n    //\n}";
        File::put($uri . "/{$filename}RepositoryContract.php", $content);
        $this->info('Contrato creado en ' . $uri . "/{$filename}RepositoryContract.php" );

        return Command::SUCCESS;
    }
}
