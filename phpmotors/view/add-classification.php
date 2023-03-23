<?php

if(!$_SESSION['loggedin']){
    header('Location: /phpmotors/');
} else {
    if($_SESSION['clientData']['clientLevel'] <= 1){
        header('Location: /phpmotors/');
    }
}
?><!DOCTYPE html>

<html lang=en>

<head>
    <meta charset="UTF-8">
    <title>Add Vehicle Classification| PHP Motors</title>
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
            <?php 
                if(isset($message)){
                    print $message;
                }
            ?>
            <form id="addClass" method="post">
                 <h1>Add Vehicle Classification</h1>
                 <p>*Note all fields are required</p>
                 <ul style="list-style: none;">
                    <li>
                        <label for="classificationName">Classification Name:</label><br>
                        <input type="text" id="classificationName" class="input" name="classificationName" 
                        <?php if(isset($classificationName)){echo "value='$classificationName'";}?>
                        maxlength="30" required>
                        <span id="password-inst">Classification name should be limited to 30 characters.
                        </span>
                    </li>
                    <li>
                        <input type="submit" class="inputBtn" value="Add Classification">
                        <input type="hidden" name="action" value="addClassification">
                    </li>
                 </ul>
            </form>
        </main>
        <hr>
        <footer>
           <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php' ?>
        </footer>
    </div>
</body>

</html>