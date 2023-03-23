<?php
 
 /*
 * Main controller
 */

// Create or access a Session
session_start();

require_once 'library/connections.php';
require_once 'model/main-model.php';
require_once 'library/functions.php';

$classifications = getClassifications();
$navDisplay = displayNavlist($classifications);
$action = filter_input(INPUT_POST, 'action');

if($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
}

// Checking for the cookie existance
if(isset($_COOKIE['firstname'])){
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

switch ($action) {
    case 'template':
        include 'view/template.php';
    break;
    default:
        include 'view/home.php';
    break;
   }

?>