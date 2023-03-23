<?php

if(!$_SESSION['loggedin']){
    header('Location: /phpmotors/');
} else {
    $cltId = $_SESSION['clientData']['clientId'];
    $cltFirstname = $_SESSION['clientData']['clientFirstname'];
    $cltLastname = $_SESSION['clientData']['clientLastname'];
    $cltEmail = $_SESSION['clientData']['clientEmail'];
    $cltLevel = $_SESSION['clientData']['clientLevel'];
}

?><!DOCTYPE html>

<html lang=en>

<head>
    <meta charset="UTF-8">
    <title>Admin | PHP Motors</title>
    <link href="../css/small.css" type="text/css" rel="stylesheet">
    <link href="../css/large.css" type="text/css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div id="wrapper">
    <header id="top-header">
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/header.php'?>
        </header>
        <nav>
            <?php echo $navDisplay; ?>
        </nav>
        <main>
            <h1>
                <?php 
                    $clientFullname = $_SESSION['clientData']['clientFirstname'];
                    $clientFullname .= ' '.$_SESSION['clientData']['clientLastname'];
                    echo  $clientFullname;
                ?>
            </h1>
            <?php 
            if(isset($_SESSION['message'])){
                print $_SESSION['message'];
            }
            ?>
            <ul>
                <?php 
                    echo "<li>First Name: ".$_SESSION['clientData']['clientFirstname']."</li>";
                    echo "<li>Last Name: ".$_SESSION['clientData']['clientLastname']."</li>";
                    echo "<li>Email: ".$_SESSION['clientData']['clientEmail']."</li>";
                ?>
            </ul>
            <h2>Account Management</h2>
            <p>Use this link to update account information.</p>
            <a href="/phpmotors/accounts/index.php?action=up">Update Account Information</a>
            <?php  if($cltLevel > 1){
                echo "<h2>Inventory Management</h2>
                        <p>Use this link to manage inventory.</p>
                        <a href='/phpmotors/vehicles/'>Click here to add vehicles</a>";
                }; 
            ?>
            <h2>Your reviews</h2>
            <?php 
            if(isset($clientReviews)){
                echo $reviewsList;
            }
            if (count($clientReviews)<1) {
                echo "You don't have reviews yet.";
            }
            ?>
        </main>
        <hr>
        <footer>
           <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php' ?>
        </footer>
    </div>
</body>

</html><?php unset($_SESSION['message']); ?>