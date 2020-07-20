<?php namespace Rudi\App\Commands\Create;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

use Rudi\App\Commands\Template;

class CreateModel extends BaseCommand
{
	protected $group 		= 'Create';
	protected $name 		= 'create:model';
	protected $description 	= 'Creates a new model file.';
	protected $usage 		= 'create:model [model_name] [Options]';
	protected $arguments 	= [
			'model_name' => 'The model file name',
		];
	protected $options 		= [
			'-n' => 'Set model namespace',
		];
		
	public function run(array $params = [])
	{
		helper('inflector');
		$name = array_shift($params);

		if (empty($name))
		{
			// $name = CLI::prompt(lang('Migrations.nameMigration'));
			$name = CLI::prompt('Name the model file');
		}

		if (empty($name))
		{
			// CLI::error(lang('Migrations.badCreateName'));
			CLI::error('You must provide a model file name.');
			return;
		}

		$ns       = $params['-n'] ?? CLI::getOption('n');
		$homepath = APPPATH;

		if (! empty($ns))
		{
			// Get all namespaces
			$namespaces = Services::autoloader()->getNamespace();

			foreach ($namespaces as $namespace => $path)
			{
				if ($namespace === $ns)
				{
					$homepath = realpath(reset($path));
					break;
				}
			}
		}
		else
		{
			$ns = 'App';
		}

		// full path
		$name = pascalize($name);
		$path = $homepath . '/Models/' . $name . '.php';

		$data = [
			'namespace' => CLI::getOption('n') ?? $ns ?? 'App',
			'className' => $name,
		];

		$template = <<<EOD
<?php namespace $ns\Models;

use CodeIgniter\Model;

class {name} extends Model
{
	protected {s}table      = 'tablename';
    protected {s}primaryKey = 'id';
    protected {s}allowedFields = [];
    protected {s}beforeInsert = [];
    protected {s}beforeUpdate = [];

    protected {s}returnType     = 'array';
    protected {s}useSoftDeletes = true;


    protected {s}useTimestamps = true;
    protected {s}createdField  = 'created_at';
    protected {s}updatedField  = 'updated_at';
    protected {s}deletedField  = 'deleted_at';

    protected {s}validationRules    = [];
    protected {s}validationMessages = [];
    protected {s}skipValidation     = false;

}

EOD;
		$template = str_replace('{name}', $name, $template);
		$template = str_replace('{s}', '$', $template);

		// Write the file out.
		helper('filesystem');
		if (! write_file($path, $template))
		{
			CLI::error(lang('Migrations.writeError', [$path]));
			// CLI::error("Error trying to create {0} file, check if the directory is writable. " . [$path]);
			return;
		}

		CLI::write('Created file: ' . CLI::color(str_replace($homepath, $ns, $path), 'green'));
	}
}