<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DDDValueObject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:voddd {context} {entity} {atributte} {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un archivo de valor-objeto para un entidad en especifico';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $uri = base_path('src/'. $this->argument('context') .'/'. $this->argument('entity').'/domain/valueObjects');
        File::makeDirectory($uri, 0755, true, true);
        $this->info("Creación del valor-objeto {$this -> argument('entity')} ".$uri);
        $entity = ucfirst($this -> argument('entity'));
        $filename = $entity . ucfirst($this -> argument('atributte'));
        $contextname = ucfirst($this -> argument('context'));
        $value = '$value';
        $param = '$' . $this -> argument('atributte');
        $construct = '$this -> value = ' . $param . ';';
        $getter = 'return $this -> value;';
        $content = "<?php\n\ndeclare(strict_types=1);\n\nnamespace Src\\" . $contextname . "\\" . $entity . "\\Domain\\ValueObjects;\n\nfinal class " . $filename . "\n{\n\tprivate {$value};\n\n\tpublic function __construct({$this -> argument('type')} {$param})\n\t{\n\t\t{$construct}\n\t}\n\n\tpublic function value(): {$this -> argument('type')}\n\t{\n\t\t{$getter}\n\t}\n}";
        File::put($uri . "/{$filename}.php", $content);
        $this->info('Modelo creado en ' . $uri . "/{$filename}.php" );

        return Command::SUCCESS;
    }
}
