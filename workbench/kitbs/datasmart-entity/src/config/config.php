<?php

return array(

	'cache' => true,

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