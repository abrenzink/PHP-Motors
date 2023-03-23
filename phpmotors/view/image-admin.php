<?php

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}

if(!$_SESSION['loggedin']){
    header('Location: /phpmotors/');
} else {
    if($_SESSION['clientData']['clientLevel'] < 2){
        header('Location: /phpmotors/');
    }
}

?><!DOCTYPE html>

<html lang=en>

<head>
    <meta charset="UTF-8">
    <title>Image Management | PHP Motors</title>
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
            <h1>Image Management</h1>
            <p>Welcome to the image management page. Choose one of the options presented below.</p>
            
            <?php
            if (isset($message)) {
            echo $message;
            } ?>
            <hr><br>
            <form action="/phpmotors/uploads/" method="post" enctype="multipart/form-data">
                <h2>Add New Vehicle Image</h2>    
                <label for="invItem">Vehicle</label>
                <?php echo $prodSelect; ?>
                <fieldset>
                    <label>Is this the main image for the vehicle?</label>
                    <label for="priYes" class="pImage">Yes</label>
                    <input type="radio" name="imgPrimary" id="priYes" class="pImage" value="1">
                    <label for="priNo" class="pImage">No</label>
                    <input type="radio" name="imgPrimary" id="priNo" class="pImage" value="0" checked>
                </fieldset>
                <label>Upload Image:</label>
                <input type="file" name="file1">
                <input class="inputBtn" type="submit" class="regbtn" value="Upload">
                <input type="hidden" name="action" value="upload">
            </form>
            <br><hr>
            <h2>Existing Images</h2>
            <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
            <?php
                if (isset($imageDisplay)) {
                    echo $imageDisplay;
                } ?>
        </main>
        <hr>
        <footer>
           <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php' ?>
        </footer>
    </div>
</body>

</html><?php unset($_SESSION['message']); ?>