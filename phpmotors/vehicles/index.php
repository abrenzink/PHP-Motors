<?php
 
/*
* Vehicles controller
*/

// Create or access a Session
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

switch ($action) {
	case 'addClassification':
		$classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

		if(empty($classificationName)){
			$message = "<p class='message'>Please, provide information for all empty form fields.</p>";
			include '../view/add-classification.php';
			exit; 
		}

		$regOutcome = addClassification($classificationName);

		if($regOutcome === 1){
			header('Location: /phpmotors/vehicles/index.php');
		} else {
			$message = "<p class='message'>Sorry, $classificationName could not be added to the table. Please try again.</p>";
			include '../view/add-classification.php';
			exit;
		}
		break;
	case 'regVehicle':
		$invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		
		// echo $invMake,$invModel,$invDescription,$invImage,$invThumbnail,$invPrice,$invStock,$invColor,$classificationId;
		
		if(empty($invMake) || empty($invModel) 
			|| empty($invDescription) || empty($invImage) || empty($invThumbnail) 
			|| empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId) ){
					
			$message = "<p class='message'>Please, provide information for all empty form fields.</p>";
			include '../view/add-vehicles.php';
			exit; 
		}
		

		$regOutcome = regVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

		if($regOutcome === 1){
			$message = "<p class='okMessage'>A new vehicle has been added to the inventory.</p>";
			include '../view/add-vehicles.php';
			exit;
		} else {
			$message = "<p class='message'>Sorry, the new vehicle could not be added to the table. Please try again.</p>";
			include '../view/add-vehicles.php';
			exit;
		}

		break;
	case 'addClass':
		include '../view/add-classification.php';
		break;
	case 'addCar':
		include '../view/add-vehicles.php';
		break;
	case 'getInventoryItems': 
		// Get the classificationId 
		$classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
		// Fetch the vehicles by classificationId from the DB 
		$inventoryArray = getInventoryByClassification($classificationId); 
		// Convert the array to a JSON object and send it back 
		echo json_encode($inventoryArray); 
		break;
	case 'mod':
		$invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
		$invInfo = getInvItemInfo($invId);
		if(count($invInfo)<1){
			$message = "<p class='message'>Sorry, no vehicle information could be found.</p>";
		}
		include '../view/vehicle-update.php';
		exit;
		break;
	case 'updateVehicle':
		$invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

		if(empty($invMake) || empty($invModel) 
			|| empty($invDescription) || empty($invImage) || empty($invThumbnail) 
			|| empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId) || empty($invId)){
					
			$message = "<p class='message'>Please, provide information for all empty form fields.</p>";
			include '../view/vehicle-update.php';
			exit; 
		}        

		$updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
		
		if ($updateResult) {
			$message = "<p class='okMessage'>Congratulations, the $invMake $invModel was successfully updated.</p>";
			$_SESSION['message'] = $message;
			header('location: /phpmotors/vehicles/');
			exit;
		} else {
			$message = "<p class='message'>Sorry, the $invMake $invModel vehicle could not be updated. Please, try again.</p>";
			include '../view/vehicle-update.php';
			exit;
		}
		break;
	case 'del':
		$invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
		$invInfo = getInvItemInfo($invId);
		if(count($invInfo)<1){
			$message = "<p class='message'>Sorry, no vehicle information could be found.</p>";
		}
		include '../view/vehicle-delete.php';
		exit;
		break;
	case 'deleteVehicle':
		$invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);      

		$deleteResult = deleteVehicle($invId);        
		if ($deleteResult) {
			$message = "<p class='okMessage'>The $invMake $invModel was successfully delete from the table.</p>";
			$_SESSION['message'] = $message;
			header('location: /phpmotors/vehicles/');
			exit;
		} else {
			$message = "<p class='message'>Error: the $invMake $invModel vehicle could not be deleted. Please try again.</p>";
			include '../view/vehicle-delete.php';
			exit;
		}            
		break;
	case 'classification':
		$classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$classificationList = buildClassificationList($classifications);
		$vehicles = getVehiclesByClassification($classificationName);
		// echo print_r($vehicles);
		
		if(!count($vehicles)){
			$message = "<p class='notice'>Sorry, no $classificationName vehicles could be found.</p>";
		} else {
			$vehicleDisplay = buildVehiclesDisplay($vehicles);
		}

		include '../view/classification.php';
		break;
	case 'details':
		$vehicleId = filter_input(INPUT_GET, 'vehicle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$vehicleDetails = getVehicleInfoAndImg($vehicleId);
		$thumbnails = getThumbnails($vehicleId);
		$thumbsDisplay = buildThumbs($thumbnails);
		$reviewsInfo = getReviewByInvId($vehicleId);
		$reviewsList = buildReviewsDisplay($reviewsInfo);

		if(!isset($vehicleDetails)){
			$message = "<p class='message'>Sorry, no vehicle could be found.</p>";
		} else {
			$vehicleDisplay = vehicleDisplay($vehicleDetails, $thumbsDisplay);
		}
		include '../view/vehicle-detail.php';
		break;
	default:
		$classificationList = buildClassificationList($classifications);
		include '../view/vehicle-management.php';
		break;
}?>