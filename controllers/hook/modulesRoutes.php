<?php

class MyModCommentsModulesRoutesController
{
	public function run()
	{
		return array(
			'module-mymodcomments-comments' => array(
				'controller' => 'comments',
				'rule' => 'product-comments{/:module_action}{/:product_rewrite}{/:id_product}/page{/:page}',
				'keywords' => array(
					'id_product' => array(
						'regexp' => '[\d]+',
						'param' => 'id_product'
					),
					'page' => array(
						'regexp' => '[\d]+',
						'param' => 'page'
					),
					'module_action' => array(
						'regexp' => '[\w]+',
						'param' => 'module_action'
					),
					'product_rewrite' => array(
						'regexp' => '[\w-_]+',
						'param' => 'product_rewrite'
					),
				),
				'params' => array(
					'fc' => 'module',
					'module' => 'mymodcomments',
					'controller' => 'comments'
				)
			)
		);
	}
}
