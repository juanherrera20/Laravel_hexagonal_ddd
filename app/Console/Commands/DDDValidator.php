<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DDDValidator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:validatorddd {context} {entity} {validator}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un request personalizado para hacer las validaciones respectivas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $uri = base_path('src/'. ucfirst($this->argument('context')) .'/'. ucfirst($this->argument('entity')).'/Infrastructure/Validators');
        File::makeDirectory($uri, 0755, true, true);
        $this->info("Creación del request personalizado {$this -> argument('entity')} ".$uri);
        $entity = ucfirst($this -> argument('entity'));
        $validator = ucfirst($this -> argument('validator'));
        $filename = $validator . 'Request';
        $contextname = ucfirst($this -> argument('context'));
        $function = 'Validator $validator';
        $parameters = '"Error de validacion", $validator->errors()->toArray()';
        $content = "<?php\n\nnamespace Src\\" . $contextname . "\\" . $entity . "\\Infrastructure\\Validators;\n\nuse App\\Traits\\HttpResponseHelper;\nuse Illuminate\\Contracts\\Validation\\Validator;\nuse Illuminate\\Foundation\\Http\\FormRequest;\nuse Illuminate\Http\Exceptions\HttpResponseException;\n\nclass " . $filename . " extends FormRequest\n{\n\t/**\n\t * Determine if the user is authorized to make this request.\n\t */\n\tpublic function authorize(): bool\n\t{\n\t\treturn true;\n\t}\n\n\t/**\n\t * Get the validation rules that apply to the request.\n\t *\n\t * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>\n\t */\n\tpublic function rules(): array\n\t{\n\t\treturn [\n\t\t\t//\n\t\t];\n\t}\n\n\tprotected function failedValidation({$function})\n\t{\n\t\tthrow new HttpResponseException(\n\t\t\tHttpResponseHelper::make()\n\t\t\t\t->validationErrorResponse({$parameters})\n\t\t\t\t->send()\n\t\t);\n\t}\n}";
        File::put($uri . "/{$filename}.php", $content);
        $this->info('Modelo creado en ' . $uri . "/{$filename}.php" );
    }
}
