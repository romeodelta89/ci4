<?php namespace Rudi\App\Controllers\Authentication;

use Rudi\App\Controllers\BaseController;

use Rudi\App\Models\UserModel;

class Auth extends BaseController
{
	protected $user;

	public function __construct()
	{
		session();
		$this->validation 	= \Config\Services::validation();
		$this->user			= new UserModel();
	}
	
	public function login()
	{
		return $this->view('login');
	}

	public function saveLogin()
	{
		if (! $this->validate($this->user->getvalidationRules(['only'=>['email','password']]))) {
			return redirect()->back()->withinput();
		}
		
		if (! $this->user->save($this->request->getPost(['email','password']))) {
			return redirect()->back()->withinput();
		}
		
		session()->setFlashdata('login','berhasil');
		return redirect()->to('/');
	}

	
	//--------------------------------------------------------------------
	public function register()
	{
		return $this->view('register');
	}

	public function saveRegister()
	{

		if(! $this->validate($this->user->validationRules)){
			return redirect()->back()->withinput();
		};
		
		if (! $this->user->save($this->request->getPost(['username','email','password','password_confirmation']))) {
			return redirect()->back()->withinput();
		}
		session()->setFlashdata('login','berhasil');
		return redirect()->to('login')->withinput();
	}
	//--------------------------------------------------------------------
	//--------------------------------------------------------------------
	//--------------------------------------------------------------------
	public function view($file, $data = [])
	{
		$data =['title'=>$file, 'validation'=>$this->validation];
		return view("Rudi\\App\\Views\\auth\\$file", $data);
	}
}