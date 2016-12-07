<?php
class Tasks
{
	public static function isLoggedUser(){
		return isset($_SESSION["User"]);
	}
}