<?php


namespace Acme\Todo;

use PDO;
use PDOException;

class MySQLPooling
{
    public function getConnection()
    {
        $servername = "mysql";
        $username = "magento";
        $password = "123456";
        $dbname = "demo";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
}