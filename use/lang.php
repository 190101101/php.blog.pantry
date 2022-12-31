<?php 

use \Pattern\Creational\Singleton\Singleton;
use \library\cookie;

class lang extends Singleton
{
	public static function __callStatic($method, $arg)
	{
		return self::read($arg)->{$method} ?? NULL;
	}

	public static function read($arg)
	{
		$type = langType(cookie::read('lang'));
        $return = require "../tmp/lang/{$type}/response.php";
        return $return->$arg;
	}	
}
