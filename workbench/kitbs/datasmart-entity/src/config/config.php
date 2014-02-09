<?php

return array(

	'cache' => true,

	'apikey' => array(
		'abrlookup' => '79384bf8-8837-4cfd-964c-a20aee8cc91a'
		),

	'entities' => array(

		'@default' => array(
			// 'namespace' => 'Kitbs\\Datasmart\\Entity\\',
			'class'     => 'AbstractEntity',
			'allowed'    => array(
				'validate'  => TRUE,
				'format'    => TRUE,
				'lookup'    => TRUE,
				'transform' => TRUE,
				'convert'   => TRUE,
				'derive'    => TRUE,
				'barcode'   => TRUE,
				),
			),

		'abn' => array(
			// 'namespace' => 'Kitbs\\Datasmart\\Entity\\',
			'class'     => 'Abn',
			'allowed'    => array(
				'validate'  => TRUE,
				'format'    => TRUE,
				'lookup'    => TRUE,
				'transform' => FALSE,
				'convert'   => FALSE,
				'derive'    => FALSE,
				'barcode'   => FALSE,
				),
			),


		)
	);