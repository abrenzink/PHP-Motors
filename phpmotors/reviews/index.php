<?php

/*
 * reviews controller
 */
session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/vehicles-model.php';
require_once '../model/uploads-model.php';
require_once '../model/reviews-model.php';
require_once '../library/functions.php';

$classifications = getClassifications();

$navDisplay = displayNavlist($classifications);

$action = filter_input(INPUT_POST, 'action');

if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
}

switch($action){
    case 'addReview':
        $invId = filter_input(INPUT_POST, 'vehicleId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(empty($reviewText)){                
            $message = "<p class='message'>Please, write the review.</p>";
            $_SESSION['message'] = $message;
            header("location: /phpmotors/vehicles/?action=details&vehicle=$invId");
            exit; 
        } 

        $addedReview = insertReview($invId, $clientId, $reviewText);

        if ($addedReview) {
			$message = "<p class='okMessage'>Thanks for contributing with your review.</p>";
			$_SESSION['message'] = $message;
            header("location: /phpmotors/vehicles/?action=details&vehicle=$invId");
			exit;
		} else {
			$message = "<p class='message'>Sorry, your review could not be added. Please, try again.</p>";
            $_SESSION['message'] = $message;
            header("location: /phpmotors/vehicles/?action=details&vehicle=$invId");
			exit;
		}

        break;
    case 'updateRev':
        $reviewId = filter_input(INPUT_GET, 'revId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $review = getReview($reviewId);
        
        if(count($review)<1){
			$message = "<p class='message'>Sorry, no vehicle information could be found.</p>";
		}

        include '../view/review-update.php';
		exit;
        break;
    case 'upRev':
        // echo "WORKS.";
        $newReview = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
     
        if(empty($newReview)){
			$message = "<p class='message'>Please, provide a new review text.</p>";
			$_SESSION['message'] = $message;
            header("location: /phpmotors/reviews/?action=updateRev&revId=$reviewId");
			exit; 
		}

        $updateResult = updateReview($reviewId, $newReview, $clientId, $invId);
        
        if ($updateResult) {
			$message = "<p class='okMessage'>Your review was successfully updated to
                    $newReview.</p>";
			$_SESSION['message'] = $message;
			header('location: /phpmotors/reviews/');
			exit;
		} else {
			$message = "<p class='message'>Sorry, your review could not be updated. Please, try again.</p>";
			$_SESSION['message'] = $message;
            header("location: /phpmotors/reviews/?action=updateRev&revId=$reviewId");
			exit;
		}
        break;
    case 'deleteRev':
        $reviewId = filter_input(INPUT_GET, 'revId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $review = getReview($reviewId);
        
        if(count($review)<1){
			$message = "<p class='message'>Sorry, no vehicle information could be found.</p>";
		}

        include '../view/review-delete.php';
		exit;
        break;
    case 'delRev':
        $reviewId = trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $deleteResult = deleteReview($reviewId);        
		if ($deleteResult) {
			$message = "<p class='okMessage'>The review was successfully delete from the table.</p>";
			$_SESSION['message'] = $message;
			header('location: /phpmotors/reviews/');
			exit;
		} else {
			$message = "<p class='message'>Error: the review has not been deleted. Please, try again.</p>";
			header("location: /phpmotors/reviews/?action=deleteRev&revId=$reviewId");
			exit;
		}  
        break;
    default:
        if(!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']){
            header('location: /phpmotors/');
        } else {
            $clientId = $_SESSION['clientData']['clientId'];
            $clientReviews = getReviewByClientId($clientId);
            $reviewsList = buildClientReviewsDisplay($clientReviews);
            include '../view/admin.php';
        }  
        break;
}

?>