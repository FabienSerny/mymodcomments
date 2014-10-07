<?php

class MyModComment extends ObjectModel
{
	public $id_mymod_comment;
	public $id_shop;
	public $id_product;
	public $product_name;
	public $firstname;
	public $lastname;
	public $email;
	public $grade;
	public $comment;
	public $date_add;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'mymod_comment', 'primary' => 'id_mymod_comment', 'multilang' => false,
		'fields' => array(
			'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
			'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
			'firstname' => array('type' => self::TYPE_STRING, 'validate' => 'isName', 'size' => 20),
			'lastname' => array('type' => self::TYPE_STRING, 'validate' => 'isName', 'size' => 20),
			'email' => array('type' => self::TYPE_STRING, 'validate' => 'isEmail'),
			'grade' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
			'comment' => array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml'),
			'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false),
		),
	);

	public function loadProductName()
	{
		$product = new Product($this->id_product, true, Context::getContext()->cookie->id_lang);
		$this->product_name = $product->name;
	}

	public static function getProductNbComments($id_product)
	{
		$nb_comments = Db::getInstance()->getValue('
		SELECT COUNT(`id_product`)
		FROM `'._DB_PREFIX_.'mymod_comment`
		WHERE `id_shop` = '.(int)Context::getContext()->shop->id.'
		AND `id_product` = '.(int)$id_product);

		return $nb_comments;
	}

	public static function getProductComments($id_product, $limit_start, $limit_end = false)
	{
		$limit = (int)$limit_start;
		if ($limit_end)
			$limit = (int)$limit_start.','.(int)$limit_end;

		$comments = Db::getInstance()->executeS('
		SELECT * FROM `'._DB_PREFIX_.'mymod_comment`
		WHERE `id_shop` = '.(int)Context::getContext()->shop->id.'
		AND `id_product` = '.(int)$id_product.'
		ORDER BY `date_add` DESC
		LIMIT '.$limit);

		return $comments;
	}

	public static function getCustomerNbComments($email)
	{
		$nb_comments = Db::getInstance()->getValue('
		SELECT COUNT(`id_product`)
		FROM `'._DB_PREFIX_.'mymod_comment`
		WHERE `id_shop` = '.(int)Context::getContext()->shop->id.'
		AND `email` = \''.pSQL($email).'\'');

		return $nb_comments;
	}

	public static function getCustomerComments($email, $limit_start, $limit_end = false)
	{
		$limit = (int)$limit_start;
		if ($limit_end)
			$limit = (int)$limit_start.','.(int)$limit_end;

		$comments = Db::getInstance()->executeS('
		SELECT pc.*, pl.`name` as product_name
		FROM `'._DB_PREFIX_.'mymod_comment` pc
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (
			pl.`id_product` = pc.`id_product` AND
			pl.`id_lang` = '.(int)Context::getContext()->language->id.'
		)
		WHERE pc.`id_shop` = '.(int)Context::getContext()->shop->id.'
		AND pc.`email` = \''.pSQL($email).'\'
		ORDER BY pc.`date_add` DESC
		LIMIT '.$limit);

		return $comments;
	}

	public static function getInfosOnProductsList($id_product_list)
	{
		$grades_comments = Db::getInstance()->executeS('
		SELECT `id_product`, AVG(`grade`) as grade_avg, count(`id_mymod_comment`) as nb_comments
		FROM `'._DB_PREFIX_.'mymod_comment`
		WHERE `id_shop` = '.(int)Context::getContext()->shop->id.'
		AND `id_product` IN ('.implode(',', $id_product_list).')
		GROUP BY `id_product`');

		return $grades_comments;
	}
}