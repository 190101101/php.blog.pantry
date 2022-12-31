<?php 

use \Pattern\Creational\Singleton\Singleton;
use \library\cookie;

class content extends Singleton
{
	public static function __callStatic($method, $arg)
	{
		$type = langType(cookie::read('lang') ?? 3);
        $return = require "../tmp/lang/{$type}/content.php";
        return $return->$method ?? NULL;
	}
}
