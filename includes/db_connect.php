<?php 

declare(strict_types= 1);

namespace includes;

use PDO, PDOException;

class Database {
public PDO $connection;


    public function __construct
    (string $driver, array $config, string $username, string $password)
    {
       $config = http_build_query(data: $config, arg_separator:";");
       $dsn = "{$driver}:{$config}";
     
       try {
        $this->connection = new PDO($dsn, $username, $password);
       }catch (PDOException $e){
        die("unable to connect to database");
       }
    }
   
}

$db = new Database("mysql",[
    "host" => "localhost",
    "port" => 3306, 
    "dbname" => "shop_db"
], "root", "");

$sqlFile = file_get_contents('../includes/shop_db.sql');
$db->connection->query($sqlFile);
$connDB = $db->connection;