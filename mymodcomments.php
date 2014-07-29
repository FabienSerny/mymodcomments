<?php

class MyModComments extends Module
{
	public function __construct()
	{
		$this->name = 'mymodcomments';
		$this->tab = 'front_office_features';
		$this->version = '0.1';
		$this->author = 'Fabien Serny';
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('My Module of product comments');
		$this->description = $this->l('With this module, your customers will be able to grade and comments your products.');
	}

	public function install()
	{
		parent::install();
		$this->registerHook('displayProductTabContent');
		return true;
	}

	public function processProductTabContent()
	{
		if (Tools::isSubmit('mymod_pc_submit_comment'))
		{
			$id_product = Tools::getValue('id_product');
			$grade = Tools::getValue('grade');
			$comment = Tools::getValue('comment');
			$insert = array(
				'id_product' => (int)$id_product,
				'grade' => (int)$grade,
				'comment' => pSQL($comment),
				'date_add' => date('Y-m-d H:i:s'),
			);
			Db::getInstance()->insert('mymod_comment', $insert);
			$this->context->smarty->assign('new_comment_posted', 'true');
		}
	}

	public function assignProductTabContent()
	{
		$enable_grades = Configuration::get('MYMOD_GRADES');
		$enable_comments = Configuration::get('MYMOD_COMMENTS');

		$id_product = Tools::getValue('id_product');
		$comments = Db::getInstance()->executeS('
		SELECT * FROM `'._DB_PREFIX_.'mymod_comment`
		WHERE `id_product` = '.(int)$id_product);

		$this->context->controller->addCSS($this->_path.'views/css/star-rating.css', 'all');
		$this->context->controller->addJS($this->_path.'views/js/star-rating.js');

		$this->context->controller->addCSS($this->_path.'views/css/mymodcomments.css', 'all');
		$this->context->controller->addJS($this->_path.'views/js/mymodcomments.js');

		$this->context->smarty->assign('enable_grades', $enable_grades);
		$this->context->smarty->assign('enable_comments', $enable_comments);
		$this->context->smarty->assign('comments', $comments);
	}

	public function hookDisplayProductTabContent($params)
	{
		$this->processProductTabContent();
		$this->assignProductTabContent();
		return $this->display(__FILE__, 'displayProductTabContent.tpl');
	}

	public function processConfiguration()
	{
		if (Tools::isSubmit('mymod_pc_form'))
		{
			$enable_grades = Tools::getValue('enable_grades');
			$enable_comments = Tools::getValue('enable_comments');
			Configuration::updateValue('MYMOD_GRADES', $enable_grades);
			Configuration::updateValue('MYMOD_COMMENTS', $enable_comments);
			$this->context->smarty->assign('confirmation', 'ok');
		}
	}

	public function assignConfiguration()
	{
		$enable_grades = Configuration::get('MYMOD_GRADES');
		$enable_comments = Configuration::get('MYMOD_COMMENTS');
		$this->context->smarty->assign('enable_grades', $enable_grades);
		$this->context->smarty->assign('enable_comments', $enable_comments);
	}

	public function getContent()
	{
		$this->processConfiguration();
		$this->assignConfiguration();
		return $this->display(__FILE__, 'getContent.tpl');
	}
}
