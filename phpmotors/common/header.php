
<img id="header-logo" src="/phpmotors/images/site/logo.png" alt="PHP Motors logo"/>

<?php 
if(!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']){
    echo "<a href='/phpmotors/accounts/index.php?action=login'>My Account</a>"; 
} else {
    echo "<div id='header-links' style='text-align: center;'>
            <a href='/phpmotors/accounts/'>Welcome, ".$_SESSION['clientData']['clientFirstname']."!</a>
            <span> | </span>
            <a href='/phpmotors/accounts/index.php?action=Logout'>Logout</a>
        </div>"; 
}
?>  
