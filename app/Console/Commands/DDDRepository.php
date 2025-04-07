<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DDDRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repositoryddd {context} {entity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea el repositorio que implementara los contratos definidos en la capa de dominio';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $uri = base_path('src/'. ucfirst($this->argument('context')) .'/'. ucfirst($this->argument('entity')).'/Infrastructure/Repositories');
        File::makeDirectory($uri, 0755, true, true);
        $this->info("Creación del repositorio {$this -> argument('entity')} ".$uri);
        $entity = ucfirst($this -> argument('entity'));
        $filename = 'Eloquent' . $entity . 'Repository';
        $contextname = ucfirst($this -> argument('context'));
        $import = 'use App\Models\\' . $entity . ' as Eloquent' . $entity . 'Model;';
        $secondImport = 'use Src\\' . $contextname . '\\'.$entity.'\Domain\Contracts\\'.$entity.'RepositoryContract;';
        $implements = $entity . 'RepositoryContract';
        $repo = 'private $eloquentModel;';
        $construct = '$this -> eloquentModel = new Eloquent' . $entity . 'Model;';
        $content = "<?php\n\ndeclare(strict_types=1);\n\nnamespace Src\\" . $contextname . "\\" . $entity . "\\Infrastructure\\Repositories;\n\n{$import}\n{$secondImport}\n\nfinal class " . $filename . " implements {$implements}\n{\n\t{$repo}\n\n\tpublic function __construct()\n\t{\n\t\t{$construct}\n\t}\n}";
        File::put($uri . "/{$filename}.php", $content);
        $this->info('Repositorio creado en ' . $uri . "/{$filename}.php" );

        return Command::SUCCESS;
    }
}
