<?php

class MyModCommentsGetContentController
{
	public function __construct($module, $file, $path)
	{
		$this->file = $file;
		$this->module = $module;
		$this->context = Context::getContext(); $this->_path = $path;
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

	public function renderForm()
	{
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->module->l('My Module configuration'),
					'icon' => 'icon-envelope'
				),
				'input' => array(
					array(
						'type' => 'switch',
						'label' => $this->module->l('Enable grades:'),
						'name' => 'enable_grades',
						'desc' => $this->module->l('Enable grades on products.'),
						'values' => array(
							array('id' => 'enable_grades_1', 'value' => 1, 'label' => $this->module->l('Enabled')),
							array('id' => 'enable_grades_0', 'value' => 0, 'label' => $this->module->l('Disabled'))
						),
					),
					array(
						'type' => 'switch',
						'label' => $this->module->l('Enable comments:'), 'name' => 'enable_comments',
						'desc' => $this->module->l('Enable comments on products.'),
						'values' => array(
							array('id' => 'enable_comments_1', 'value' => 1, 'label' => $this->module->l('Enabled')),
							array('id' => 'enable_comments_0', 'value' => 0, 'label' => $this->module->l('Disabled'))
						),

					),
				),
				'submit' => array('title' => $this->module->l('Save'))
			)
		);

		$helper = new HelperForm();
		$helper->table = 'mymodcomments';
		$helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
		$helper->allow_employee_form_lang = (int)Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
		$helper->submit_action = 'mymod_pc_form';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->module->name.'&tab_module='.$this->module->tab.'&module_name='.$this->module->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => array(
				'enable_grades' => Tools::getValue('enable_grades', Configuration::get('MYMOD_GRADES')),
				'enable_comments' => Tools::getValue('enable_comments', Configuration::get('MYMOD_COMMENTS')),
			),
			'languages' => $this->context->controller->getLanguages()
		);

		return $helper->generateForm(array($fields_form));
	}

	public function run()
	{
		$this->processConfiguration();
		$html_confirmation_message = $this->module->display($this->file, 'getContent.tpl');
		$html_form = $this->renderForm();
		return $html_confirmation_message.$html_form;
	}
}
