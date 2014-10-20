<?php

class MyModCommentsDisplayProductTabContentController
{
	public function __construct($module, $file, $path)
	{
		$this->file = $file;
		$this->module = $module;
		$this->context = Context::getContext();
		$this->_path = $path;
		$this->cache_id = $this->module->smartyGetCacheId($this->module->name.(int)Tools::getValue('id_product'));
	}

	public function processProductTabContent()
	{
		if (Tools::isSubmit('mymod_pc_submit_comment'))
		{
			$id_product = Tools::getValue('id_product');
			$firstname = Tools::getValue('firstname');
			$lastname = Tools::getValue('lastname');
			$email = Tools::getValue('email');
			$grade = Tools::getValue('grade');
			$comment = Tools::getValue('comment');

			if (!Validate::isName($firstname) || !Validate::isName($lastname) || !Validate::isEmail($email))
			{
				$this->context->smarty->assign('new_comment_posted', 'error');
				return false;
			}

			$MyModComment = new MyModComment();
			$MyModComment->id_shop = (int)$this->context->shop->id;
			$MyModComment->id_product = (int)$id_product;
			$MyModComment->firstname = $firstname;
			$MyModComment->lastname = $lastname;
			$MyModComment->email = $email;
			$MyModComment->grade = (int)$grade;
			$MyModComment->comment = nl2br($comment);
			$MyModComment->add();

			$this->context->smarty->assign('new_comment_posted', 'success');

			$this->module->smartyClearCache('displayProductTabContent.tpl', $this->cache_id);
		}
	}

	public function assignProductTabContent()
	{
		$enable_grades = Configuration::get('MYMOD_GRADES');
		$enable_comments = Configuration::get('MYMOD_COMMENTS');

		$this->context->controller->addCSS($this->_path.'views/css/star-rating.css', 'all');
		$this->context->controller->addJS($this->_path.'views/js/star-rating.js');

		$this->context->controller->addCSS($this->_path.'views/css/mymodcomments.css', 'all');
		$this->context->controller->addJS($this->_path.'views/js/mymodcomments.js');

		if (!$this->module->isCached('displayProductTabContent.tpl', $this->cache_id))
		{
			$id_product = Tools::getValue('id_product');
			$comments = MyModComment::getProductComments($id_product, 0, 3);
			$product = new Product((int)$id_product, false, $this->context->cookie->id_lang);

			$this->context->smarty->assign('enable_grades', $enable_grades);
			$this->context->smarty->assign('enable_comments', $enable_comments);
			$this->context->smarty->assign('comments', $comments);
			$this->context->smarty->assign('product', $product);
		}
	}

	public function run($params)
	{
		$this->processProductTabContent();
		$this->assignProductTabContent();
		return $this->module->display($this->file, 'displayProductTabContent.tpl', $this->cache_id);
	}
}
