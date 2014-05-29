<?php
session_start();
setlocale(LC_ALL, 'sv_SE.UTF-8');

require_once 'registry.php';	

$fc = IoC::resolve('FrontController');
$fc->start();


