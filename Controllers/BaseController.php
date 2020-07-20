<?php namespace Rudi\App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{

	protected $helpers = [];
	
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
		
	}

	public function tampil($file){
		return view("Rudi\\App\\Views\\$file");

	}

}