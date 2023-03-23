<?php
    if(!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']){
        $message = "";
    } else {
        $cltId = $_SESSION['clientData']['clientId'];
        $screenName = substr($_SESSION['clientData']['clientFirstname'], 0, 1);
        $screenName .= '. '.$_SESSION['clientData']['clientLastname'];
    }
?><!DOCTYPE html>

<html lang=en>

<head>
    <meta charset="UTF-8">
    <title><?php echo $vehicleId; ?> Details | PHP Motors</title>
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
        <h1><?php echo $vehicleDetails['invMake']; ?> Details</h1>
        <?php 
            if(isset($_SESSION['message'])){
                echo $_SESSION['message'];
            }
            if(isset($vehicleDisplay)){
                echo $vehicleDisplay;
            }
        ?>
        <hr><h3>Costumers' Reviews</h3>
        <?php
            if(isset($reviewsList)){
                echo $reviewsList;
            }
            if(count($reviewsInfo) < 1) { 
                echo "<p>No reviews yet.</p>"; 
            }
            if(!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']){
                echo "<a href='/phpmotors/accounts/index.php?action=login'>Log in to add a review</a>";
            } else { 
                echo "<form action='/phpmotors/reviews/' method='post'>
                <h4>Add you review</h4>
                <ul style='list-style:none;'>
                    <li>
                        <label for=screenName>Customer:</label><br>
                        <input type='text' readonly id='screenName' name='screenName' ";
                    if(isset($screenName)) {
                        echo "value='$screenName'";
                    }
                    echo "></li><li><label for='reviewText'>Review:</label><br>
                        <textarea id='reviewText' class='input' name='reviewText' rows='3' 
                        required>";
                if(isset($reviewText)){
                    echo $reviewText;
                }
                echo "</textarea>
                    </li>
                    <li><input type='submit' class='inputBtn' value='Send Review'>
                        <input type='hidden' name='action' value='addReview'>
                        <input type='hidden' name='vehicleId' value='";
                        if(isset($vehicleId)){ 
                            echo $vehicleId; 
                        } 
                        echo "'><input type='hidden' name='clientId' value='";
                        if(isset($cltId)){ 
                            echo "$cltId"; 
                        } 
                        echo "'></li></ul></form>";
                        }
        ?></main>
        <hr>
        <footer>
           <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php' ?>
        </footer>
    </div>
</body>

</html><?php unset($_SESSION['message']); ?>