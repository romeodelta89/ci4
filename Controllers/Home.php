<?php namespace Rudi\App\Controllers;

use Rudi\App\Controllers;

class Home extends Controller
{
	public function index()
	{
		return view('home');
	}
}