<?php

class AdminMyModCommentsController extends ModuleAdminController
{
	public function __construct()
	{
		// Set variables
		$this->table = 'mymod_comment';
		$this->className = 'MyModComment';
		$this->fields_list = array(
			'id_mymod_comment' => array('title' => $this->l('ID'), 'align' => 'center', 'width' => 25),
			'shop_name' => array('title' => $this->l('Shop'), 'width' => 120, 'filter_key' => 's!name'),
			'firstname' => array('title' => $this->l('Firstname'), 'width' => 120),
			'lastname' => array('title' => $this->l('Lastname'), 'width' => 140),
			'email' => array('title' => $this->l('E-mail'), 'width' => 150),
			'product_name' => array('title' => $this->l('Product'), 'width' => 100, 'filter_key' => 'pl!name'),
			'grade_display' => array('title' => $this->l('Grade'), 'align' => 'right', 'width' => 80, 'filter_key' => 'a!grade'),
			'comment' => array('title' => $this->l('Comment'), 'search' => false),
			'date_add' => array('title' => $this->l('Date add'), 'type' => 'date'),
		);

		// Set fields form for form view
		$this->context = Context::getContext();
		$this->context->controller = $this;
		$this->fields_form = array(
			'legend' => array('title' => $this->l('Add / Edit Comment'), 'image' => '../img/admin/contact.gif'),
			'input' => array(
				array('type' => 'text', 'label' => $this->l('Firstname'), 'name' => 'firstname', 'size' => 30, 'required' => true),
				array('type' => 'text', 'label' => $this->l('Lastname'), 'name' => 'lastname', 'size' => 30, 'required' => true),
				array('type' => 'text', 'label' => $this->l('E-mail'), 'name' => 'email', 'size' => 30, 'required' => true),
				array('type' => 'select', 'label' => $this->l('Product'), 'name' => 'id_product', 'required' => true, 'default_value' => 1, 'options' => array('query' => Product::getProducts($this->context->cookie->id_lang, 1, 1000, 'name', 'ASC'), 'id' => 'id_product', 'name' => 'name')),
				array('type' => 'text', 'label' => $this->l('Grade'), 'name' => 'grade', 'size' => 30, 'required' => true, 'desc' => $this->l('Grade must be between 1 and 5')),
				array('type' => 'textarea', 'label' => $this->l('Comment'), 'name' => 'comment', 'cols' => 50, 'rows' => 5, 'required' => false),
			),
			'submit' => array('title' => $this->l('Save'))
		);

		// Enable bootstrap
		$this->bootstrap = true;

		// Call of the parent constructor method
		parent::__construct();

		// Update the SQL request of the HelperList
		$this->_select = "s.`name` as shop_name, pl.`name` as product_name, CONCAT(a.`grade`, '/5') as grade_display";
		$this->_join = 'LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (pl.`id_product` = a.`id_product` AND pl.`id_lang` = '. (int)$this->context->language->id.' AND pl.`id_shop` = a.`id_shop`)
		LEFT JOIN `'._DB_PREFIX_.'shop` s ON (s.`id_shop` = a.`id_shop`)';

		// Add actions
		$this->addRowAction('view');
		$this->addRowAction('delete');
		$this->addRowAction('edit');

		// Add bulk actions
		$this->bulk_actions = array(
			'delete' => array(
				'text' => $this->l('Delete selected'),
				'confirm' => $this->l('Would you like to delete the selected items?'),
			),
			'myaction' => array(
				'text' => $this->l('My Action'), 'confirm' => $this->l('Are you sure?'),
			)
		);

		// Define meta and toolbar title
		$this->meta_title = $this->l('Comments on Product');
		if (Tools::getIsset('viewmymod_comment'))
			$this->meta_title = $this->l('View comment').' #'. Tools::getValue('id_mymod_comment');
		$this->toolbar_title[] = $this->meta_title;
	}

	protected function processBulkMyAction()
	{
		Tools::dieObject($this->boxes);
	}

	public function renderView()
	{
		// Build delete link
		$admin_delete_link = $this->context->link->getAdminLink('AdminMyModComments').'&deletemymod_comment&id_mymod_comment='.(int)$this->object->id;

		// Build admin product link
		$admin_product_link = $this->context->link->getAdminLink('AdminProducts').'&updateproduct&id_product='.(int)$this->object->id_product.'&key_tab=ModuleMymodcomments';

		// If author is known as a customer, build admin customer link
		$admin_customer_link = '';
		$customers = Customer::getCustomersByEmail($this->object->email);
		if (isset($customers[0]['id_customer']))
			$admin_customer_link = $this->context->link->getAdminLink('AdminCustomers').'&viewcustomer&id_customer='.(int)$customers[0]['id_customer'];

		// Add delete shortcut button to toolbar
		$this->page_header_toolbar_btn['delete'] = array(
			'href' => $admin_delete_link,
			'desc' => $this->l('Delete it'),
			'icon' => 'process-icon-delete',
			'js' => "return confirm('".$this->l('Are you sure you want to delete it ?')."');",
		);

		$this->object->loadProductName();
		$tpl = $this->context->smarty->createTemplate(dirname(__FILE__). '/../../views/templates/admin/view.tpl');
		$tpl->assign('mymodcomment', $this->object);
		$tpl->assign('admin_product_link', $admin_product_link);
		$tpl->assign('admin_customer_link', $admin_customer_link);

		return $tpl->fetch();
	}
}