<?php

/*
 * accounts controller
 */

// Create or access a Session
session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/accounts-model.php';
require_once '../model/reviews-model.php';
require_once '../library/functions.php';

$classifications = getClassifications();

$navDisplay = displayNavlist($classifications);

$action = filter_input(INPUT_POST, 'action');

if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'register':
        //Filter and store the data
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        // Checking for existing email
        $existingEmail = checkExistingEmail($clientEmail);

        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            $_SESSION['message'] = '<p class="message">Please, provide information for all empty form fields.</p>';
            include '../view/registration.php';
            exit; 
        }

         // Deal with existing email during registration
        if($existingEmail){
            $_SESSION['message'] = '<p class="message">The email adress already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send the data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        // Check and report the result
        if($regOutcome === 1){
            // Setting a cookie to greet visitor when registring
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "<p class='okMessage'>Thanks for registering, $clientFirstname. 
                Please use your email and password to login.</p>";
            header('Location: /phpmotors/accounts/?action=login');
            exit;
        } else {
            $_SESSION['message'] = "<p class='Message'>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }
        
        break;
    case 'Login':
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientEmail = checkEmail($clientEmail);

        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // Check for missing data
        if (empty($clientEmail)) {
            $_SESSION['message'] = "<p class='message'>Please, provide information for all empty fields.</p>";
            include '../view/login.php';
            exit; 
        } 

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        if(empty($clientData)){
            $_SESSION['message'] = "<p class='message'>This email is not linked to an account.
            Would you like to regiter?</p>";
            include '../view/registration.php';
            exit;
        }

        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);

        // If the hashes don't match, create an error and return to the login view
        if(!$hashCheck) {
            $_SESSION['message'] = "<p class='message'>Wrong password. Please, check and try again.</p>";
            include '../view/login.php';
            exit;
        } else {
            // A valid user exists, log them in.
            $_SESSION['loggedin'] = TRUE;
            
            // Remove the password from the array's last position.
            array_pop($clientData);

            // Store the client data array into the session.
            $_SESSION['clientData'] = $clientData;

            $_SESSION['message'] = "<p class='okMessage'>You are logged in.</p>";

            // Send them to the admin view.
            header('location: /phpmotors/accounts/');
            exit;
        }
        
        break;
    case 'registration':
        include '../view/registration.php';
        break;
    case 'login':
        include '../view/login.php';
        break;
    case 'Logout':
        unset($_SESSION);
        session_destroy();
        header('Location: /phpmotors/');
        break;
    case 'up':
        include '../view/client-update.php';
        break;
    case 'updateData':
        unset($_SESSION['passwordMessage']);
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
        
        if($clientEmail != $_SESSION['clientData']['clientEmail']){
            $existingEmail = checkExistingEmail($clientEmail);
            if($existingEmail){
                $_SESSION['dataMessage'] = '<p class="message">The chosen email is already taken. Try another.</p>';
                include '../view/client-update.php';
                exit;
            } 
        }

        $clientEmail = checkEmail($clientEmail);
        
        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)){
            $_SESSION['dataMessage'] = '<p class="message">Please, provide information for all empty form fields.</p>';
            include '../view/client-update.php';
            exit; 
        }
        
        $updateClientResult = updateClientData($clientFirstname, $clientLastname, $clientEmail, $clientId);

        if ($updateClientResult) {
            $clientUpdatedData = getClientById($clientId);

            // Remove the password from the array's last position.
            array_pop($clientUpdatedData);

            // Store the new client data array into the session.
            $_SESSION['clientData'] = $clientUpdatedData;
 
            $_SESSION['message'] = "<p class='okMessage'>Congratulations, your info was successfully updated.</p>";
            header('location: /phpmotors/accounts/');
            exit;
        } else {
            $message = "<p class='message'>Sorry, your info could not be updated. Please try again.</p>";
            $_SESSION['dataMessage'] = $message;
            include '../view/client-update.php';
            exit;
        }
        break;
    case 'updatePassword':
        unset($_SESSION['dataMessage']);
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $checkPassword = checkPassword($clientPassword);

        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));

        if($checkPassword){
            $newHashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
            updatePassword($newHashedPassword, $clientId);
            $_SESSION['message'] = "<p class='okMessage'>Congratulations, your password has been successfully updated.</p>";
            header('location: /phpmotors/accounts/');
            exit;

        } else {
            $_SESSION['passwordMessage'] = "<p class='message'>Sorry, your password does not
            meet the minimun requirements. Please, try again.</p>";
            include '../view/client-update.php';
            exit;
        }

        break;
    default:
        $clientId = $_SESSION['clientData']['clientId'];
        $clientReviews = getReviewByClientId($clientId);
        $reviewsList = buildClientReviewsDisplay($clientReviews);

        include '../view/admin.php';
        break;
   }

?>