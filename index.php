<?php
define('DIR_WEB', __DIR__."/");

include_once 'includeClasses.php';
$DBTasks = new DBTasks();

DBLoad::init();

session_start();
//echo "<pre>";
include_once 'Controller/Controller.php';
ob_start();

