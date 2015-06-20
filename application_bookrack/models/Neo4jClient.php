<?php

use Everyman\Neo4j\Client;

error_reporting(-1);
ini_set('display_errors', 1);
spl_autoload_register(function ($sClass) {
	$sLibPath = __DIR__;
	$sClassFile = str_replace('\\',DIRECTORY_SEPARATOR,$sClass).'.php';
	$sClassPath = $sLibPath.$sClassFile;
	if (file_exists($sClassPath)) {
		require($sClassPath);
	}
});


class Neo4jClient
{
    protected static $client = null;

    public static function client()
    {
    	self::$client = new Client();
        self::$client->getTransport()->setAuth('neo4j', 'bookrack');
        return self::$client;
    }
}