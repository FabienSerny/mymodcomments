<?php

function upgrade_module_0_2($module)
{
	// Execute module update SQL statements
	$sql_file = dirname(__FILE__).'/sql/install-0.2.sql';
	if (!$module->loadSQLFile($sql_file))
		return false;

	// All went well!
	return true;
}