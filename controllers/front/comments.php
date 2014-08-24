<?php

class MyModCommentsCommentsModuleFrontController extends ModuleFrontController
{
	public $product;

	public function setMedia()
	{
		// We call the parent method
		parent::setMedia();

		// Save the module path in a variable
		$this->path = __PS_BASE_URI__.'modules/mymodcomments/';

		// Include the module CSS and JS files needed
		$this->context->controller->addCSS($this->path.'views/css/star-rating.css', 'all');
		$this->context->controller->addJS($this->path.'views/js/star-rating.js');
		$this->context->controller->addCSS($this->path.'views/css/mymodcomments.css', 'all');
		$this->context->controller->addJS($this->path.'views/js/mymodcomments.js');
	}

	protected function initList()
	{
		// Get number of comments
		$nb_comments = MyModComment::getProductNbComments($this->product->id);

		// Init
		$nb_per_page = 10;
		$nb_pages = ceil($nb_comments / $nb_per_page);
		$page = 1;
		if (Tools::getValue('page') != '')
			$page = (int)$_GET['page'];
		$limit_start = ($page - 1) * $nb_per_page;
		$limit_end = $nb_per_page;

		// Get comments
		$comments = MyModComment::getProductComments($this->product->id, $limit_start, $limit_end);

		// Assign comments and product object
		$this->context->smarty->assign('comments', $comments);
		$this->context->smarty->assign('product', $this->product);
		$this->context->smarty->assign('page', $page);
		$this->context->smarty->assign('nb_pages', $nb_pages);

		$this->setTemplate('list.tpl');
	}

	public function initContent()
	{
		parent::initContent();

		$actions_list = array('list' => 'initList');
		$id_product = (int)Tools::getValue('id_product');
		$module_action = Tools::getValue('module_action');
		$this->product = new Product((int)$id_product, false, $this->context->cookie->id_lang);

		if ($id_product > 0 && isset($actions_list[$module_action]))
			$this->$actions_list[$module_action]();
	}
}