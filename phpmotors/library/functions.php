<?php

/*
functions
*/

function checkEmail($clientEmail){
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

// Check the password for a minimum of 8 characters,
// at least one 1 capital letter, at least 1 number and
// at least 1 special character

function checkPassword($clientPassword){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    
    //returns 0 or 1
    return preg_match($pattern, $clientPassword);
}

// Displaying the navigation list
function displayNavlist($carclassifications){
    $navList = '<ul>';
    $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors 
                    home page'>Home</a></li>";

    foreach ($carclassifications as $classification) {
        $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName="
        .urlencode($classification['classificationName']).
        "' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a></li>";
    }

    $navList .= '</ul>';
    return $navList;
}

// Build the classifications select list 
function buildClassificationList($classifications){ 
    $classificationList = '<select name="classificationId" id="classificationList">'; 
    $classificationList .= "<option>Choose a Classification</option>"; 
    foreach ($classifications as $classification) { 
     $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
    } 
    $classificationList .= '</select>'; 
    return $classificationList; 
}

function buildVehiclesDisplay($vehicles){
    $dv = '<ul id="inv-display" style="list-style: none;">';
    foreach ($vehicles as $vehicle) {
        $price = $vehicle['invPrice'];
        $price = number_format($price, 2, ".", ",");
        $image = $vehicle['imgPath'];
        $dv .= '<li>';
        $dv .= "<a href='/phpmotors/vehicles/?action=details&vehicle="
        .urlencode($vehicle['invId'])."'>";
        $dv .= "<img src='$image' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
        $dv .= '<hr>';
        $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
        $dv .= "<span>U$ $price</span>";
        $dv .= '</a>';
        $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}

function buildThumbs($thumbsList){
    $thumbDisplay = '<div id="thumbsWrapper">';
    foreach ($thumbsList as $thumb){
         $thumbDisplay .= "<img src='$thumb[imgPath]' alt=''>";
    }
    $thumbDisplay .= '</div>';
    return $thumbDisplay;
}

function vehicleDisplay($vehicle, $thumbs){
    setlocale(LC_MONETARY,"en_US");
    $price = $vehicle['invPrice'];
    $price = number_format($price, 2, ".", ",");

    //build html
    $dv = "<div id='vehicleWrapper'><div id='imgsWrapper'>";
    $dv.= "<img id='vehicleImg' src='$vehicle[imgPath]' 
        alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
    $dv.= $thumbs;
    $dv.= "</div>";

    $dv.= "<div id='infoWrapper'>";
    $dv.= "<h2 id='vehicleTitle'>$vehicle[invMake] - $vehicle[invModel]</h2>";
    $dv.= "<p id='vehiclePrice'>Price: U$ $price</p>";
    $dv.= "<p id='vehicleDesc'>$vehicle[invDescription]</p>";
    $dv.= "<p id='vehicleColor'>Color: $vehicle[invColor]</p>";
    $dv.= "<p id='vehicleStock'>In stock: $vehicle[invStock]</p>";
    $dv.= "</div></div>";
    return $dv;
}

// Adds "-tn" designation to file name
function makeThumbnailName($image) {
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
}

// Build images display for image management view
function buildImageDisplay($imageArray) {
    // $id = '<ul id="image-display">';
    $id = '<table id="table">';
    $id.= '<tr><th>Large image</th><th>Thumbnail image</th></tr>';
    foreach ($imageArray as $image) {
        $id .= '<tr><td>';
        $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] 
            image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'></td>";
        $id .= "<td><p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' 
            title='Delete the image'>Delete $image[imgName]</a></p></td>";
        $id .= '</tr>';
    }
    $id .= '</table>';
    return $id;
}

// Build the vehicles select list
function buildVehiclesSelect($vehicles) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Vehicle</option>";
    foreach ($vehicles as $vehicle) {
     $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
}

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
        // Gets the actual file name
        $filename = $_FILES[$name]['name'];

        if (empty($filename)) {
            return;
        }

        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'];

        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;

        // Moves the file to the target folder
        move_uploaded_file($source, $target);

        // Send file for further processing
        processImage($image_dir_path, $filename);

        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;
        
        // Returns the path where the file is stored
        return $filepath;
    }
}

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';
   
    // Set up the image path
    $image_path = $dir . $filename;
   
    // Set up the thumbnail image path
    $image_path_tn = $dir.makeThumbnailName($filename);
   
    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);
   
    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
}

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
     
    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];
   
    // Set up the function names
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
            break;
        case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
            break;
        case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
            break;
        default:
            return;
   }
   
    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
   
    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;
   
    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {
   
        // Calculate height and width for the new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);
    
        // Create the new image
        $new_image = imagecreatetruecolor($new_width, $new_height);
    
        // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }
    
        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }
    
        // Copy old image to new image - this resizes the image
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
    
        // Write the new image to a new file
        $image_to_file($new_image, $new_image_path);
        
        // Free any memory associated with the new image
        imagedestroy($new_image);
     } else {
         // Write the old image to a new file
         $image_to_file($old_image, $new_image_path);
     }

     // Free any memory associated with the old image
     imagedestroy($old_image);
}

// Build reviews display
function buildReviewsDisplay($reviewsInfo) { 
    $list = '<ul style="list-style: none; padding: 0;">';
    foreach ($reviewsInfo as $review) {
        $clientName = substr($review['clientFirstname'], 0, 1);
        $clientName .= '. '.$review['clientLastname'];
        $list .= "<li class='revItem'><span class='revText'>$review[reviewText]</span><br>"; 
        $list .= "<span class='revInfo'>$clientName";
        $list .= ' | ';
        $timestamp = strtotime($review['reviewDate']);
        $list .= date("F j, Y, g:i a", $timestamp);
        $list .= "</span>";
        $list .= "</li>";
    }
    $list .= '</ul>';
    return $list;
}

function buildClientReviewsDisplay($clientReviews) { 
    $list = '<ul style="list-style: none; padding: 0;">';
    foreach ($clientReviews as $review) {
        // $list .= "<h4></h4>";
        $list .= "<li class='revItem'><span class='revText'>$review[reviewText]</span><br>"; 
        $timestamp = strtotime($review['reviewDate']);
        $list .= "<span class='revInfo'>";
        $list .= date("F j, Y, g:i a", $timestamp);
        $list .= "</span><br>";
        $list .= "<a class='updateBtn' 
            href='/phpmotors/reviews?action=updateRev&revId=$review[reviewId]' 
            title='Delete update the review'>Update review</a>";
        $list .= "<a class='delBtn'
            href='/phpmotors/reviews?action=deleteRev&revId=$review[reviewId]' 
            title='Delete update the review'>Delete review</a>";
        $list .= "</li>";
    }
    $list .= '</ul>';
    return $list;
}
?>