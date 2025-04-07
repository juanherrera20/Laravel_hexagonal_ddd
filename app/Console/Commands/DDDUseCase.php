<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DDDUseCase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:ucddd {context} {entity} {usecase}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea el caso de uso para el manejo de la estructura de los datos enviados en el request';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $uri = base_path('src/'. ucfirst($this->argument('context')) .'/'. ucfirst($this->argument('entity')).'/Application/UseCase');
        File::makeDirectory($uri, 0755, true, true);
        $this->info("Creación del caso de uso {$this -> argument('usecase')} ".$uri);
        $usecase = ucfirst($this -> argument('usecase'));
        $entity = ucfirst($this -> argument('entity'));
        $contextname = ucfirst($this -> argument('context'));
        $filename = $usecase . 'UseCase';
        $import = 'use Src\\' . $contextname . '\\'.$entity.'\Domain\Contracts\\'.$entity.'RepositoryContract;';
        $repository = '$repository';
        $construct = '$this -> repository = $repository;';
        $content = "<?php\n\ndeclare(strict_types=1);\n\nnamespace Src\\" . $contextname . "\\" . $entity . "\\Application\\UseCase;\n\n{$import}\n\nfinal class " . $filename . "\n{\n\tprivate {$repository};\n\n\tpublic function __construct({$entity}RepositoryContract {$repository})\n\t{\n\t\t{$construct}\n\t}\n\n\tpublic function __invoke()\n\t{\n\t\t//\n\t}\n}";
        File::put($uri . "/{$filename}.php", $content);
        $this->info('Caso de uso creado en ' . $uri . "/{$filename}.php" );

        return Command::SUCCESS;
    }
}
