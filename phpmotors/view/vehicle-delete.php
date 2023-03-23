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
    <title><?php if(isset($invInfo['invMake'])){ 
	            echo "Delete $invInfo[invMake] $invInfo[invModel]";}?> | PHP Motors</title>
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
            <form id="modVehicle" method="post">
                <h1><?php if(isset($invInfo['invMake'])){ 
	                echo "Delete $invInfo[invMake] $invInfo[invModel]"; }?></h1>
                 <p>Confirm Vehicle Deletion. The delete is permanent.</p>
                 <ul style="list-style: none;">
                    <li>
                        <label for="invMake">Make:</label><br>
                        <input type="text" readonly id="invMake" class="input" name="invMake" 
                        <?php if(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>>
                    </li>
                    <li>
                        <label for="invModel">Model:</label><br>
                        <input type="text" readonly id="invModel" class="input" name="invModel" 
                        <?php if(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>>
                    </li>
                    <li>
                        <label for="invDescription">Description:</label><br>
                        <textarea readonly id="invDescription" class="input" name="invDescription"><?php 
                        if(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea>
                    </li>
                    <li>
                        <input type="submit" class="inputBtn" value="Delete Vehicle">
                        <input type="hidden" name="action" value="deleteVehicle">
                        <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){
                            echo $invInfo['invId'];} ?>">
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