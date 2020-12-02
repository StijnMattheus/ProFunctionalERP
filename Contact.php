<?php
class Contact {
    public $dbname;
    public $code;
    public $name;
    public $address;
    public $postcode;
    public $city;
    public $countrycode;

    function __construct(){
        $this->dbname = "Contact";
    }

    function insert() {
        insertContact($this);
    }

    function delete() {
        deleteContact($this);
    }

    function modify() {
        modifyContact($this);
    }

    function get() {
        return getContact($this);    
    }

    function findSet(&$contacts) {        
        findContactSet($contacts,$this);
        return (count($contacts));     
    }
    
    function List(&$contacts) {
        return ListHMTML($contacts);
    }
}

function createContactTable($databaseConnection) {        
    try {
        $sql = "CREATE TABLE IF NOT EXISTS Contact (
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

function insertContact($currContact) {
    global $databaseConnection;    
    try {
        $sql = "insert into $currContact->dbname (Code,Name,Address,postCode,City,countryCode) 
            values (\"$currContact->code\",\"$currContact->name\",\"$currContact->address\",\"$currContact->postcode\",\"$currContact->city\",\"$currContact->countrycode\")";
        $databaseConnection->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage() . "<br";
    }
}

function deleteContact($currContact) {
    global $databaseConnection;    
    try {
        $sql = "delete from $currContact->dbname where Code = \"$currContact->code\"";            
        $databaseConnection->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage() . "<br";
    }
}

function modifyContact($currContact) {

}

function getContact($currContact) {
    global $databaseConnection;
    try {
        $sqlRows = array();
        $sql = "select * from $currContact->dbname where Code = \"$currContact->code\"";
        $statement = $databaseConnection->prepare($sql);
        $statement->execute();        
        if (fillSQLRows($sqlRows,$statement)) {                        
            if (count($sqlRows) == 1) {
                return createContactFromSQLRow($currContact,$sqlRows[0]);                     
            } else {
                return false;
            }
        } else {
            return false;
        }     
    } catch (PDOExpecption $e) {
        echo $sql . "<br>" . $e->getMessage() . "<br>";
        return false;
    }
}

function findContactSet(&$contacts,$currContact) {
    global $databaseConnection;
    try {
        $sqlRows = array();
        $sql = "select * from $currContact->dbname";
        $statement = $databaseConnection->prepare($sql);
        $statement->execute();        
        if (fillSQLRows($sqlRows,$statement)) {                        
            foreach ($sqlRows as $sqlRow) {                
                $newContact = new Contact();
                createContactFromSQLRow($newContact,$sqlRow);                     
                $contacts[] = $newContact;
            }            
            return (count($contacts) != 0);     
        } else {
            return false;
        }

    } catch (PDOExpecption $e) {
        echo $sql . "<br>" . $e->getMessage() . "<br>";
        return false;
    }
}

function fillSQLRows(&$sqlRows,$statement) {          
    while ($row = $statement->fetch(PDO::FETCH_NUM,PDO::FETCH_ORI_NEXT)) {
        $sqlRows[] = $row;    
    }    
    return (count($sqlRows) != 0);
}

function createContactFromSQLRow(&$newContact,$sqlData) {
    $newContact = new Contact();
    $newContact->code = $sqlData[0];
    $newContact->name = $sqlData[1];
    $newContact->address = $sqlData[2];
    $newContact->postcode = $sqlData[3];
    $newContact->city = $sqlData[4];
    $newContact->countrycode = $sqlData[5];    
    return true;
}

function ListHMTML(&$contacts) { 
    $HTML = "<table id=List>";
    $HTML = $HTML . "<th>Code</th><th>Name</th><th>Address</th><th>Post Code</th><th>City</th><th>Country Code</th>";
    foreach ($contacts as $contact) {
        $HTML = $HTML . "<tr>";
        $HTML = $HTML . "<td>$contact->code</td>
                <td>$contact->name</td>
                <td>$contact->address</td>
                <td>$contact->postcode</td>
                <td>$contact->city</td>
                <td>$contact->countrycode</td>";
        $HTML = $HTML . "</tr>";
    }
    $HTML = $HTML . "</table>";
    return $HTML;
}
?>