<!DOCTYPE html>

<html lang=en>

<head>
    <meta charset="UTF-8">
    <title>Login | PHP Motors</title>
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
            <form id="login" action="/phpmotors/accounts/" method="post">
                 <h1>Sign In</h1>
                 <ul style="list-style: none;">
                    <li>
                        <label for="clientEmail">E-mail:</label><br>
                        <input type="email" id="clientEmail" class="input" 
                        name="clientEmail" placeholder="Enter a valid email address" 
                        <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?> required>
                    </li>
                    <li>
                        <label for="clientPassword">Password:</label><br>
                        <input type="password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                            id="clientPassword" class="input" name="clientPassword" 
                            placeholder="Enter your password" required>
                    </li>
                    <li>
                        <input type="submit" class="inputBtn" value="Sign In">
                        <input type="hidden" name="action" value="Login">
                    </li>
                 </ul>
                 <a href="/phpmotors/accounts/index.php?action=registration">Not a member yet? Sign-up</a>
            </form>
        </main>
        <hr>
        <footer>
           <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php' ?>
        </footer>
    </div>
</body>

</html><?php unset($_SESSION['message']); ?>