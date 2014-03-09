<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends Authenticated_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		Template::render();
	}
}