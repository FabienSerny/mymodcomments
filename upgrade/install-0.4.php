<?php

// Update method for version 0.4 of mymodcomments module
function upgrade_module_0_4($module)
{
	// Execute module update MySQL commands
	$sql_file = dirname(__FILE__).'/sql/install-0.4.sql';
	if (!$module->loadSQLFile($sql_file))
		return false;

	// Associate all existing comments with the current shop
	$id_shop = Context::getContext()->shop->id;
	Db::getInstance()->update('mymod_comment', array('id_shop' => (int)$id_shop), '');

	// All went well!
	return true;
}