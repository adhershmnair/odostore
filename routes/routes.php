<?php


$router->get('/',array());

$router->get(
			'/about',
			array(
				'platform'		=> 'home',
				'controller'	=> 'About',
				'action' 		=> 'index',
			)
	);


