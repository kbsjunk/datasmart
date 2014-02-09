<?php

return array(

	'cache' => true,

	'entities' => array(

		'@default' => array(
			'namespace' => 'Kitbs\\Datasmart\\Entity\\',
			'class'     => 'Default',
			'allows'    => array(
				'validate'  => TRUE,
				'lookup'    => TRUE,
				'transform' => TRUE,
				'derive'    => TRUE,
				'barcode'   => TRUE,
				),
			),

		'abn' => array(
			'namespace' => 'Kitbs\\Datasmart\\Entity\\',
			'class'     => 'Abn',
			'allows'    => array(
				'validate'  => TRUE,
				'lookup'    => TRUE,
				'transform' => FALSE,
				'derive'    => FALSE,
				'barcode'   => FALSE,
				),
			),


		)
	);