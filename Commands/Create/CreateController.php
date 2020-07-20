<?php namespace Rudi\App\Commands\Create;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

use Rudi\App\Commands\Template;

class CreateController extends BaseCommand
{
	protected $group 		= 'Create';
	protected $name 		= 'create:controller';
	protected $description 	= 'Creates a new controller file.';
	protected $usage 		= 'create:controller [controller_name] [Options]';
	protected $arguments 	= [
			'controller_name' => 'The controller file name',
		];
	protected $options 		= [
			'-n' => 'Set controller namespace',
		];
		
	public function run(array $params = [])
	{
		helper('inflector');
		$name = array_shift($params);

		if (empty($name))
		{
			$name = CLI::prompt('Name the controller file');
		}

		if (empty($name))
		{
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
		$path = $homepath . '/Controllers/' . $name . '.php';

		$data = [
			'namespace' => CLI::getOption('n') ?? $ns ?? 'App',
			'className' => $name,
		];

		$template = <<<EOD
<?php namespace $ns\Controllers;

use CodeIgniter\Controller;

class {name} extends Controller
{
	public function index()
	{
		//
	}
}

EOD;
		$template = str_replace('{name}', $name, $template);

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