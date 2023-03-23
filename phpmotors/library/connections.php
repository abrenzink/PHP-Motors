<?php

/* 
*Proxy connection to the phpmotors database
*/
function phpmotorsConnect(){
    $server = 'localhost';
    $dbname = 'phpmotors';
    $username = 'notrealnameduetosecutymatters';
    $password = 'notrealnameduetosecutymatters2';
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try{
        $link = new PDO($dsn, $username, $password, $options);
        return $link;
    }
    catch(PDOException $e){
        // echo "It didn't work, error: ".$e->getMessage();
        header('Location:/phpmotors/view/500.php');
        exit;
    }
}

phpmotorsConnect();

?>
