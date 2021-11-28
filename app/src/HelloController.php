<?php

namespace Acme\Todo;


use PDO;
use React\Http\Message\Response;

class HelloController
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

   public function createDatabase()
   {
       $sqlCreateDB = "CREATE DATABASE demo";
       $this->connection->getConnection()->exec($sqlCreateDB);
   }

   public function createTable()
   {
       // sql to create table
       $sqlCreateTable = "CREATE TABLE MyGuests (
       id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
       firstname VARCHAR(30) NOT NULL,
       lastname VARCHAR(30) NOT NULL,
       email VARCHAR(50),
       reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
       )";
        $this->connection->getConnection()->exec($sqlCreateTable);
   }

    public function insertMyGuest()
    {
        $sqlInsert = "INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'it.tinhngo@gmail.com')";
        $this->connection->getConnection()->query($sqlInsert);
    }

    public function selectMyGuest()
    {
        $data = [];
        $sql = "SELECT id, firstname, lastname, reg_date FROM MyGuests";
        if (!$this->connection) {
            return $data;
        }
        $stmt = $this->connection->getConnection()->prepare("SELECT id, firstname, lastname, reg_date FROM MyGuests LIMIT 1000");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $data[] = [
                'id' => $row["id"],
                'firstname' => $row["firstname"],
                'lastname' => $row["lastname"],
                'reg_date' => $row["reg_date"]
            ];
        }
        return $data;
    }

    
    public function __invoke()
    {
        // create new a database: demo
        // $this->createTable();
        // $this->insertMyGuest();

        $time_start = microtime(true); 


        $myGuest = $this->selectMyGuest();

        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start);

        $count = count($myGuest);
        $data = [
            'count' => $count,
            'time_start' => $time_start,
            'time_end' => $time_end,
            'execution_time' => $execution_time
        ];
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode($data)
        );
    }
}