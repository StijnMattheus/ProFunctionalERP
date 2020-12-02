<?php
function createCompanyInformationTable($databaseConnection) {    
    $tableName = "companyInformation";
    try {
        $sql = "CREATE TABLE IF NOT EXISTS $tableName (
            Name varchar(100) NOT NULL,
            Address varchar(100) DEFAULT NULL,
            postCode varchar(30) DEFAULT NULL,
            City varchar(50) DEFAULT NULL,
            countryCode varchar(10) DEFAULT NULL,
            contactCode varchar(20) DEFAULT NULL,
            VATRegistrationNo varchar(25) DEFAULT NULL,
            PRIMARY KEY (Name),
            KEY FK_Contact_idx (contactCode),
            CONSTRAINT FK_Contact FOREIGN KEY (contactCode) REFERENCES Contact (Code))";
        $databaseConnection->exec($sql);        
        echo "Table $tableName has been created<br>";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage() . "<br";
    }
}
?>