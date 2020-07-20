<?php namespace Rudi\App\Commands\Create;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

use Rudi\App\Commands\Template;

class CreateHelper extends BaseCommand
{
	protected $group 		= 'Create';
	protected $name 		= 'create:helper';
	protected $description 	= 'Creates a new helper file.';
	protected $usage 		= 'create:helper [helper_name] [Options]';
	protected $arguments 	= [
			'helper_name' => 'The helper file name',
		];
	protected $options 		= [
			'-n' => 'Set helper namespace',
		];
		
	public function run(array $params = [])
	{
		helper('inflector');
		$name = array_shift($params);

		if (empty($name))
		{
			// $name = CLI::prompt(lang('Migrations.nameMigration'));
			$name = CLI::prompt('Name the helper file');
		}

		if (empty($name))
		{
			// CLI::error(lang('Migrations.badCreateName'));
			CLI::error('You must provide a helper file name.');
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
		$path = $homepath . '/Helpers/' . $name . '_helper.php';

		$data = [
			'namespace' => CLI::getOption('n') ?? $ns ?? 'App',
			'className' => $name,
		];

		$template = <<<EOD
<?php namespace $ns\Helpers;

if (! function_exists('myhelper')) {
    function myhelper({s}var = null){
        # code...
    }
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