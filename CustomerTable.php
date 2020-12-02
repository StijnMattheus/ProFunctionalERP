<?php
function createCustomerTable($databaseConnection) {    
    $tableName = "Customer";
    try {
        $sql = "CREATE TABLE IF NOT EXISTS $tableName (
            Code varchar(20) NOT NULL,
            Name varchar(100) DEFAULT NULL,
            Address varchar(100) DEFAULT NULL,
            postCode varchar(30) DEFAULT NULL,
            City varchar(50) DEFAULT NULL,
            countryCode varchar(10) DEFAULT NULL,
            PRIMARY KEY (Code))";
          
        $databaseConnection->exec($sql);        
        echo "Table $tableName has been created<br>";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage() . "<br";
    }
}
?>