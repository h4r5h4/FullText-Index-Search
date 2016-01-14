<?
require_once 'DB_Functions.php';


$db = new DB_Functions(); //Object initiation

//Table Creation

if ($db->createTable())
    echo "Succesfully created Table<br>";
else
    echo "Error Creating Table<br>";

//Data Insertion
if ($db->insertRows())
    echo "Insertion Successful<br>";
else
    echo "Error inserting rows<br>";

$t1 = microtime(true); //recording time to calculate execution period 
//Data Search
if (!$db->searchName())
    echo "No Name Found";
else {
    $t2 = microtime(true);
    
    echo $t2 - $t1;
}



?>