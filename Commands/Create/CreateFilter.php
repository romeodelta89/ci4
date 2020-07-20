<?php namespace Rudi\App\Commands\Create;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

use Rudi\App\Commands\Template;

class CreateFilter extends BaseCommand
{
	protected $group 		= 'Create';
	protected $name 		= 'create:filter';
	protected $description 	= 'Creates a new filter file.';
	protected $usage 		= 'create:filter [filter_name] [Options]';
	protected $arguments 	= [
			'filter_name' => 'The filter file name',
		];
	protected $options 		= [
			'-n' => 'Set filter namespace',
		];
		
	public function run(array $params = [])
	{
		helper('inflector');
		$name = array_shift($params);

		if (empty($name))
		{
			// $name = CLI::prompt(lang('Migrations.nameMigration'));
			$name = CLI::prompt('Name the filter file');
		}

		if (empty($name))
		{
			// CLI::error(lang('Migrations.badCreateName'));
			CLI::error('You must provide a filter file name.');
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
		$path = $homepath . '/Filters/' . $name . '.php';

		$data = [
			'namespace' => CLI::getOption('n') ?? $ns ?? 'App',
			'className' => $name,
		];

		$template = <<<EOD
<?php namespace $ns\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class {name} implements FilterInterface
{
    public function before(RequestInterface {s}request)
    {
        // Do something here
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface {s}request, ResponseInterface {s}response)
    {
        // Do something here
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