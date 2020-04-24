<?php 
namespace App\Config;

trait Config
{
	public static function getConfigs()
	{
		return [
			'DBNATIVE' => true
		];
	}
}