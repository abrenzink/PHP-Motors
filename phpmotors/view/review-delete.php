<?php

if(!$_SESSION['loggedin']){
    header('Location: /phpmotors/');
} else {
    $cltId = $_SESSION['clientData']['clientId'];
    $cltFirstname = $_SESSION['clientData']['clientFirstname'];
    $cltLastname = $_SESSION['clientData']['clientLastname'];
}
?><!DOCTYPE html>

<html lang=en>

<head>
    <meta charset="UTF-8">
    <title>Review Delete | PHP Motors</title>
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
            if(isset($_SESSION['message'])){
                print $_SESSION['message'];
            }
            ?>

            <form action='/phpmotors/reviews/' method='post'>
                <h2>Delete Review</h2>
                <p class="message">*WARNING: this action can be undone after confirmed.</p>
                <ul style='list-style:none;'>
                    <li>
                    <label for='reviewText'>Review:</label><br>
                    <textarea id='reviewText' class='input' name='reviewText' rows='3' 
                    readonly><?php 
                    if(isset($reviewText)) {
                        echo $reviewText;
                    } elseif(isset($review['reviewText'])){
                        echo $review['reviewText'];
                    } 
                    ?></textarea>
                    </li>
                    <li><input type='submit' class='inputBtn' value='Delete Review'>
                        <input type='hidden' name='action' value='delRev'>
                        <?php
                            echo "<input type='hidden' name='reviewId' value='";
                            if(isset($reviewId)){ 
                                echo $reviewId;
                            }
                            echo "'>";
                        ?>
                    </li></ul>
            </form>
        </main>
        <br><hr>
        <footer>
           <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php' ?>
        </footer>
    </div>
</body>

</html><?php 
unset($_SESSION['dataMessage']);
unset($_SESSION['passwordMessage']);?>