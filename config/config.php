<?php

$default = 'active';

$config['active']['host'] = 'localhost';
$config['active']['user'] = 'root';
$config['active']['password'] = 'admin';
$config['active']['dbname'] = 'odo';
$config['active']['port'] = 3306;
$config['active']['charset'] = 'utf8';
$config['active']['prefix'] = 'odo_';





return $config[$default];