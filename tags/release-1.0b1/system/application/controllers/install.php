<?php

class Install extends Controller {

	function Install()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->model('InstallModel', 'installer');
		$this->installer->create_database_tables();
	}
}
?>