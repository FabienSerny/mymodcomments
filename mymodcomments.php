<?php

require_once(dirname(__FILE__).'/classes/MyModComment.php');

class MyModComments extends Module
{
	public function __construct()
	{
		$this->name = 'mymodcomments';
		$this->tab = 'front_office_features';
		$this->version = '0.3';
		$this->author = 'Fabien Serny';
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('My Module of product comments');
		$this->description = $this->l('With this module, your customers will be able to grade and comments your products.');
	}

	public function install()
	{
		// Call install parent method
		if (!parent::install())
			return false;

		// Execute module install SQL statements
		$sql_file = dirname(__FILE__).'/install/install.sql';
		if (!$this->loadSQLFile($sql_file))
			return false;

		// Register hooks
		if (!$this->registerHook('displayProductTabContent') ||
			!$this->registerHook('displayBackOfficeHeader') ||
			!$this->registerHook('ModuleRoutes'))
			return false;

		// Preset configuration values
		Configuration::updateValue('MYMOD_GRADES', '1');
		Configuration::updateValue('MYMOD_COMMENTS', '1');

		// All went well!
		return true;
	}

	public function uninstall()
	{
		// Call uninstall parent method
		if (!parent::uninstall())
			return false;

		// Execute module install SQL statements
		// $sql_file = dirname(__FILE__).'/install/uninstall.sql';
		// if (!$this->loadSQLFile($sql_file))
		//	return false;

		// Delete configuration values
		Configuration::deleteByName('MYMOD_GRADES');
		Configuration::deleteByName('MYMOD_COMMENTS');

		// All went well!
		return true;
	}

	public function loadSQLFile($sql_file)
	{
		// Get install SQL file content
		$sql_content = file_get_contents($sql_file);

		// Replace prefix and store SQL command in array
		$sql_content = str_replace('PREFIX_', _DB_PREFIX_, $sql_content);
		$sql_requests = preg_split("/;\s*[\r\n]+/", $sql_content);

		// Execute each SQL statement
		$result = true;
		foreach($sql_requests as $request)
			if (!empty($request))
				$result &= Db::getInstance()->execute(trim($request));

		// Return result
		return $result;
	}

	public function onClickOption($type, $href = false)
	{
		$confirm_reset = $this->l('Reseting this module will delete all comments from your database, are you sure you want to reset it ?');
		$reset_callback = "return mymodcomments_reset('".addslashes($confirm_reset)."');";

		$matchType = array(
			'reset' => $reset_callback,
			'delete' => "return confirm('Confirm delete?')",
		);

		if (isset($matchType[$type]))
			return $matchType[$type];

		return '';
	}

	public function getHookController($hook_name)
	{
		// Include the controller file
		require_once(dirname(__FILE__).'/controllers/hook/'. $hook_name.'.php');

		// Build dynamically the controller name
		$controller_name = $this->name.$hook_name.'Controller';

		// Instanciate controller
		$controller = new $controller_name($this, __FILE__, $this->_path);

		// Return the controller
		return $controller;
	}

	public function hookDisplayProductTabContent($params)
	{
		$controller = $this->getHookController('displayProductTabContent');
		return $controller->run($params);
	}

	public function hookDisplayBackOfficeHeader($params)
	{
		$controller = $this->getHookController('displayBackOfficeHeader');
		return $controller->run($params);
	}

	public function hookModuleRoutes()
	{
		$controller = $this->getHookController('modulesRoutes');
		return $controller->run();
	}

	public function getContent()
	{
		$controller = $this->getHookController('getContent');
		return $controller->run();
	}
}
