<html>
    <head><link rel="stylesheet" href="ProFunctionalERP.css"></head>
    <body>
        <?php
        include 'databaseEngine.php';
        include 'Contact.php';

        $serverName = "localhost";
        $userName = "Stijn.Mattheus";
        $passWord = "Briek2011";
        $databaseName = "ProFunctionalERP";
        $newDatabaseName = "ProFunctionalERP_TEST";

        openDatabaseConnection($serverName,$databaseName,$userName,$passWord);
        setupNewDatabase($newDatabaseName);
        
        for ($i = 1;$i <= 1000000;$i++) {   
            $currContact = new Contact();
            $currContact->code = "CT$i";
            $currContact->delete();          
        }

        $contacts = array();
        $currContact = new Contact();
        echo ($currContact->findSet($contacts));
        echo $currContact->List($contacts);
        ?>
    </body>
</html>
