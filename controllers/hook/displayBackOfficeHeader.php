<?php

class MyModCommentsDisplayBackOfficeHeaderController
{
	public function __construct($module, $file, $path)
	{
		$this->file = $file;
		$this->module = $module;
		$this->context = Context::getContext(); $this->_path = $path;
	}

	public function run($params)
	{
		// If we are not on section modules, we do not add JS file
		if (Tools::getValue('controller') != 'AdminModules')
			return '';

		// Assign module mymodcomments base dir
		$this->context->smarty->assign('pc_base_dir', __PS_BASE_URI__.'modules/'.$this->module->name.'/');

		// Display template
		return $this->module->display($this->file, 'displayBackOfficeHeader.tpl');
	}
}
