<?php

class DB_Functions
{
    
    private $db;
    
    
    // constructor
    function __construct()
    {
        require_once 'DB_Connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }
    
    
    
    //Table Creation; Declaring a new fulltext Index for full_name to optimize selecton performance
    public function createTable()
    {
        $sql = "DROP TABLE IF EXISTS `users`"; //Making sure the table doesn't exist
        mysql_query($sql);
        $sql = "CREATE TABLE `users` (
          `id` int(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          `full_name` VARCHAR(30) NOT NULL,
          `email` VARCHAR(30) NOT NULL,
          `city` VARCHAR(15) NOT NULL,
          FULLTEXT fIdx(`full_name`)
       )";
        if (!mysql_query($sql)) {
            mysql_query("DROP TABLE IF EXISTS `$table`"); //Dropping table if it's not created successfully
            return false;
        }
        return true;
    }
    
    //Data Insertion
    public function insertRows()
    {
        
        
        
        $query = "INSERT INTO users(`full_name`, `email`, `city`) VALUES ";
        for ($i = 1; $i <= 10000000; $i++) { //Had to reduce the number to 250k and loop it 40 times given my resources
            if ($i != 1)
                $query .= ",";
            $fName    = $this->getName(); //generating first name randomly
            $lName    = $this->getName(); ////generating last name randomly
            $email    = $fName . "." . $lName . "@gmail.com";
            $fullName = $fName . " " . $lName;
            $city     = $this->getCity(); //generating city randomly
            
            $query .= "('$fullName', '$email', '$city')"; //appending all values into the query first, so that we don't have to execute query multiple times
            
        }
        
        $result = mysql_query($query);
        
        if ($result)
            return true;
        else
        //echo mysql_error();
            return false;
        
    }
    
    //Function to Search data
    public function searchName()
    {
        $query = 'SELECT * from `users` WHERE MATCH(`full_name`) AGAINST ("john*" IN BOOLEAN MODE)'; //FULLTEXT Search in Boolean Mode
        
        $result = mysql_query($query);
        
        $no_of_rows = mysql_num_rows($result);
        echo $no_of_rows;
        if ($no_of_rows > 0) { //Making sure we have results for the search criteria
            
            while ($row = mysql_fetch_assoc($result))
                echo $row['id'] . "-" . $row['full_name'] . "<br>"; //Displaying the results
            return true;
        } else {
            return false;
        }
        
    }
    
    
    
    //Function to generate a name randomly
    function getName()
    {
        $fn   = rand(3, 6);
        $name = "";
        for ($fI = 0; $fI < $fn; $fI++) {
            if ($fI == 0)
                $name .= chr(rand(65, 90));
            else
                $name .= chr(rand(97, 122));
        }
        return $name;
    }
    
    
    //Function to generate a city randomly
    public function getCity()
    {
        $fn   = rand(3, 10);
        $name = "";
        for ($fI = 0; $fI < $fn; $fI++)
            $name .= chr(rand(97, 122));
        return $name;
    }
    
    
}
?>