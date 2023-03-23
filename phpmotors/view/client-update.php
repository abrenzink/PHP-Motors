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
    <title>Update Account | PHP Motors</title>
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
            if(isset($_SESSION['dataMessage'])){
                print $_SESSION['dataMessage'];
            }
            ?>

            <form id="modAccount" method="post">
                
                 <h1>Update Account</h1>
                 <ul style="list-style: none;">
                    <li>
                        <label for="clientFirstname">First Name:</label><br>
                        <input type="text" id="clientFirstname" class="input" 
                        name="clientFirstname" <?php if(isset($clientFirstname)){
                            echo "value='$clientFirstname'";} 
                            elseif(isset($cltFirstname)) { echo "value='$cltFirstname'"; } ?> 
                        required>
                    </li>
                    <li>
                        <label for="clientLastname">Last Name:</label><br>
                        <input type="text" id="clientLastname" class="input"  name="clientLastname"
                        <?php if(isset($clientLastname)){echo "value='$clientLastname'";} 
                        elseif(isset($cltLastname)) { echo "value='$cltLastname'"; } ?>
                         required>
                    </li>
                    <li>
                        <label for="clientEmail">E-mail:</label><br>
                        <input type="email" id="clientEmail" class="input"  
                        name="clientEmail" placeholder="Enter a valid email address"
                        <?php if(isset($clientEmail)){echo "value='$clientEmail'";} 
                        elseif(isset($cltEmail)) { echo "value='$cltEmail'"; } ?>
                        required>
                    </li>
                    <li>
                        <input type="submit" class="inputBtn" value="Update">
                        <input type="hidden" name="action" value="updateData">
                        <input type="hidden" name="clientId" value="
                        <?php if(isset($cltId)) { echo $cltId;}
                        elseif(isset($clientId)){ echo $clientId;}?>">
                    </li>
                 </ul>   
            </form><br>
            <?php 
            if(isset($_SESSION['passwordMessage'])){
                print $_SESSION['passwordMessage'];
            }
            ?><br>
            <form id="modPassword" method="post">
                <h1>Change Password</h1>
                <ul style="list-style: none;">
                    <li>
                        <label for="clientPassword">Password:</label><br>
                        <input type="password" id="clientPassword" class="input" 
                            name="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" 
                            title="Eight or more characters" placeholder="Enter a valid password" required>
                        <p id="password-inst">Passwords must contain at least 8 character and contain at least 1 number,
                            1 capital letter, and 1 special character.
                        </p>
                        <p>*Note your original password will be changed.</p>
                    </li>
                    <li>
                        <input type="submit" class="inputBtn" value="Change Password">
                        <input type="hidden" name="action" value="updatePassword">
                        <input type="hidden" name="clientId" value="
                        <?php if(isset($cltId)) { echo $cltId;}
                        elseif(isset($clientId)){ echo $clientId;}?>">
                    </li>
                 </ul>
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