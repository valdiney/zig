<?php
namespace System\Database;

use PDO;
use PDOException;

/**
* --------------------------------------------------------------------------
* This class is used to make the connection with the database
* --------------------------------------------------------------------------
* @var $pdo : Object : Stored the instance of PDO
*/

class Native
{
    private static $pdo;

    public static function connect()
    {
        if ( ! isset($pdo)) {
            try {
                self::$pdo = new PDO(
                    "mysql:" . "host=" . getenv('HOST_NAME') . ";" .
                    "dbname=" . getenv('HOST_DBNAME'), getenv('HOST_USERNAME'), getenv('HOST_PASSWORD'),
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                // exibe erro somente em diplay_errors=true
                $errorType = getenv('APP_DISPLAY_ERRORS', false)==false? PDO::ERRMODE_SILENT: PDO::ERRMODE_WARNING;
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, $errorType);

            } catch (PDOException $e) {
                if ($e->getCode() == 2002) {
                    echo "<b>Database configuration Error:</b> This Localhost not exist in this server";
                    exit;
                } elseif ($e->getCode() == 1049) {
                    echo "<b>Database configuration Error:</b> This Database not exist in this server";
                    exit;
                } elseif ($e->getCode() == 1044) {
                    echo "<b>Database configuration Error:</b> Database username not exist in this server";
                    exit;
                } elseif ($e->getCode() == 1045) {
                    echo "<b>Database configuration Error:</b> Database Password are incorrect";
                    exit;
                }
            }
        }

        return self::$pdo;
    }
}
