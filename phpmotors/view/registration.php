<!DOCTYPE html>

<html lang=en>

<head>
    <meta charset="UTF-8">
    <title>Register | PHP Motors</title>
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
            <form id="login" action="/phpmotors/accounts/index.php" method="post">
                 <h1>Register</h1>
                 <ul style="list-style: none;">
                    <li>
                        <label for="clientFirstname">First Name:</label><br>
                        <input type="text" id="clientFirstname" class="input" 
                        name="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?> 
                        required>
                    </li>
                    <li>
                        <label for="clientLastname">Last Name:</label><br>
                        <input type="text" id="clientLastname" class="input"  name="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  ?>
                         required>
                    </li>
                    <li>
                        <label for="clientEmail">E-mail:</label><br>
                        <input type="email" id="clientEmail" class="input"  
                        name="clientEmail" placeholder="Enter a valid email address" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>
                        required>
                    </li>
                    <li>
                        <label for="clientPassword">Password:</label><br>
                        <input type="password" id="clientPassword" class="input" 
                            name="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" 
                            title="Eight or more characters" placeholder="Enter a valid password" required>
                        <span id="password-inst">Passwords must contain at least 8 character and contain at least 1 number,
                            1 capital letter, and 1 special character.
                        </span>
                    </li>
                    <li>
                        <input type="submit" name="register-btn" class="inputBtn" value="Register">
                        <input type="hidden" name="action" value="register">
                    </li>
                 </ul>
                 <a href="/phpmotors/accounts/index.php?action=login">Already a member? Sign-in</a>
            </form>
        </main>
        <br><hr>
        <footer>
           <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php' ?>
        </footer>
    </div>
</body>

</html><?php unset($_SESSION['message']); ?>