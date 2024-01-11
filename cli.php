<?php

//DNS creation - DATA SOURCE NAME
//driver:key=value format
//REFACTOR ===> LOGIC MOVED TO Database.php

//$driver = 'mysql'; //compatible with mariaDB
//
////http_build_query function builds url, can be used DNS string to
//$config = http_build_query([
//    'host' => 'localhost', //key value pair
//    'port' => 3306,
//    'dbname' => 'phppiggy'
//], arg_separator: ';');
//
//$dsn = "{$driver}:{$config}";
//$username = 'root';
//$password = '';
//
//try{
//    $db = new PDO($dsn, $username, $password);
//} catch (PDOException $e) {
//    die("Could not connect to dtb"); //stops the script
//}
//echo "connected to database";

include __DIR__ . "/src/Framework/Database.php";

use \Framework\Database;

//use the class

$db = new Database(
    'mysql',
    ['host' => 'localhost', 'port' => 3306, 'dbname' => 'phppiggy'],
    'root',
    ""
);

//TRANSACTION query example
try {
//    creates the transaction, everything under will be inside the transaction
    $db->connection->beginTransaction();

    $db->connection->query("INSERT INTO products VALUES (5, 'shirt')");

    $item = "caps";
    $search2 = "SELECT * FROM products WHERE name=:name";
    $stmt = $db->connection->prepare($search2,);
    $stmt->bindValue("name", $item, PDO::PARAM_STR);
    $stmt->execute();

    //if above code was successful, then its saved into database + End transaction
    $db->connection->commit();
} catch (Exception $e) {
    //if fails, but check active transaction first to save rollbac
    if ($db->connection->inTransaction()) {
        $db->connection->rollback();
    }

    echo "Transaction failed: " . $e->getMessage();
}


echo "connected to database";

$query = "SELECT * FROM products";
//save return value, many fetch modes available - FETCH_NUM, FETCH_
$stmt = $db->connection->query($query, PDO::FETCH_ASSOC);
$query = "SELECT * FROM products WHERE name =:name";
//prepared statement for safe queries
$stmt2 = $db->connection->prepare($query);

//bind method sets parameters without executing, query can be executed later
$stmt2->bindValue(':name', 'hat', PDO::PARAM_STR);
//execute with parameters
$stmt2->execute([
    'name' => "hat"
]);

//here fetch mode overrides fetch mode above, this is normal
var_dump($stmt->fetchAll(PDO::FETCH_OBJ));