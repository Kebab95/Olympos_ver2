<?php
define('DIR_WEB', __DIR__);

include_once 'includeClasses.php';
$DBTasks = new DBTasks();
session_start();
include_once 'Controller/Controller.php';
ob_start();

