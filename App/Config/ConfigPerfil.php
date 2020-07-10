<?php 
namespace App\Config;

trait ConfigPerfil
{
	# Estes valores devem ser os mesmos do banco de dados
	public static $superAdmin = 1;
	public static $administrador = 2;
	public static $gerente = 5;
	public static $vendedor = 4;
}