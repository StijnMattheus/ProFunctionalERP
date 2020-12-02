<?php
function createContactBusinessRelationTable($databaseConnection) {    
    $tableName = "contactBusinessRelation";
    try {
        $sql = "CREATE TABLE IF NOT EXISTS $tableName (
            contactCode varchar(20) NOT NULL,
            customerCode varchar(20) DEFAULT NULL,
            vendorCode varchar(20) DEFAULT NULL,
            PRIMARY KEY (contactCode),
            KEY Customer_idx (customerCode),
            KEY Vendor_idx (vendorCode),
            CONSTRAINT Contact FOREIGN KEY (contactCode) REFERENCES Contact (Code),
            CONSTRAINT Customer FOREIGN KEY (customerCode) REFERENCES Customer (Code),
            CONSTRAINT Vendor FOREIGN KEY (vendorCode) REFERENCES Vendor (Code))";
            $databaseConnection->exec($sql);        
        echo "Table $tableName has been created<br>";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage() . "<br";
    }
}
?>