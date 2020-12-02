<?php
include "companyInformationTable.php";
include "CustomerTable.php";
include "VendorTable.php";
include "contactBusinessRelationTable.php";

$currServerName;
$currUserName;
$currPassWord;
$currDatabaseName;
$databaseConnection;

function openDatabaseConnection($serverName,$databaseName,$userName,$passWord) {
    global $currServerName,$currDatabaseName,$currUserName,$currPassWord,$databaseConnection;
    try {     
        $currServerName = $serverName;
        $currDatabaseName = $databaseName;
        $currUserName = $userName;
        $currPassWord = $passWord;
        if ($currDatabaseName == "") {
            $databaseConnection = new PDO("mysql:host=$currServerName", $currUserName, $currPassWord);
        } else {
            $databaseConnection = new PDO("mysql:host=$currServerName;dbname=$currDatabaseName", $currUserName, $currPassWord);
        }
        // set the PDO error mode to exception
        $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($currDatabaseName != "") {
            echo "Connected successfully to Server $currServerName database $currDatabaseName<br>"; 
        } else {
            echo "Connected successfully to Server $currServerName <br>"; 
        }
    
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage() . "<br>";
    }      
}

function closeDatabaseConnection() {
    global $currServerName,$currDatabaseName,$databaseConnection;
    $databaseConnection = null;
    echo "Connection with database $currDatabaseName on $currServerName has been closed<br>";
}

function setupNewDatabase($newDatabaseName) {
    global $currServerName,$currDatabaseName,$currUserName,$currPassWord,$databaseConnection;
    closeDatabaseConnection();
    createNewDatabase($newDatabaseName);
    openDatabaseConnection($currServerName,$newDatabaseName,$currUserName,$currPassWord);
    createDabaseSchema();
}

function createNewDatabase($newDatabaseName) {
    global $currServerName,$currDatabaseName,$currUserName,$currPassWord,$databaseConnection;
    try {    
        openDatabaseConnection($currServerName,"",$currUserName,$currPassWord);
        echo "creating new database $newDatabaseName ....<br>";
        $sql = "CREATE DATABASE IF NOT EXISTS $newDatabaseName";        
        $databaseConnection->exec($sql);
        echo "Database $newDatabaseName has been created<br>";        
        $currDatabaseName = $newDatabaseName;
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage() . "<br>";
    }
}

function createDabaseSchema() {
    global $databaseConnection;
    createContactTable($databaseConnection);
    createCompanyInformationTable($databaseConnection);    
    createCustomerTable($databaseConnection);
    createVendorTable($databaseConnection);
    createContactBusinessRelationTable($databaseConnection);
} 
?>