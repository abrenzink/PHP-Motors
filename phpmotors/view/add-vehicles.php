<?php
//Build select list
$dropList = '<select id="classificationId" name="classificationId" class="input">';

foreach ($classifications as $dropOption) {
    $dropList .= "<option value='$dropOption[classificationId]'";

    if(isset($classificationId)){
        if($dropOption['classificationId'] == $classificationId){
            $dropList .= ' selected ';
        }
    }

    $dropList.= ">$dropOption[classificationName]</option>";
}

$dropList .= "</select>";

if(!$_SESSION['loggedin']){
    header('Location: /phpmotors/');
} else {
    if($_SESSION['clientData']['clientLevel'] <= 1){
        header('Location: /phpmotors/');
    }
}
?><!DOCTYPE html>

<html lang=en>

<head>
    <meta charset="UTF-8">
    <title>Add Vehicle | PHP Motors</title>
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
                if(isset($message)){
                    print $message;
                }
            ?>
            <form id="addVehicle" method="post">
                 <h1>Add Vehicle</h1>
                 <p>*Note all fields are required</p>
                 <ul style="list-style: none;">
                    <li>
                        <label for="classificationId">Car classification:</label><br>
                        <?php echo $dropList; ?>
                    </li>
                    <li>
                        <label for="invMake">Make:</label><br>
                        <input type="text" id="invMake" class="input" name="invMake" 
                        <?php if(isset($invMake)){echo "value='$invMake'";}?> required>
                    </li>
                    <li>
                        <label for="invModel">Model:</label><br>
                        <input type="text" id="invModel" class="input" name="invModel" 
                        <?php if(isset($invModel)){echo "value='$invModel'";}?> required>
                    </li>
                    <li>
                        <label for="invDescription">Description:</label><br>
                        <textarea id="invDescription" class="input" name="invDescription" rows="3" 
                        required><?php if(isset($invDescription)){echo $invDescription;}?></textarea>
                    </li>
                    <li>
                        <label for="invImage">Image Path:</label><br>
                        <input type="text" id="invImage" class="input" name="invImage" 
                        <?php if(isset($invImage)){echo "value='$invImage'";}?> required>
                    </li>
                    <li>
                        <label for="invThumbnail">Thumbnail Path:</label><br>
                        <input type="text" id="invThumbnail" class="input" name="invThumbnail"
                        <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}?> required>
                    </li>
                    <li>
                        <label for="invPrice">Price:</label><br>
                        <input type="number" id="invPrice" class="input" name="invPrice"
                        <?php if(isset($invPrice)){echo "value='$invPrice'";}?> required>
                    </li>
                    <li>
                        <label for="invStock">In Stock:</label><br>
                        <input type="number" id="invStock" class="input" name="invStock" 
                        <?php if(isset($invStock)){echo "value='$invStock'";}?> required>
                    </li>
                    <li>
                        <label for="invColor">Color:</label><br>
                        <input type="text" id="invColor" class="input" name="invColor"
                        <?php if(isset($invColor)){echo "value='$invColor'";}?> required>
                    </li>
                    <li>
                        <input type="submit" class="inputBtn" value="Add Vehicle">
                        <input type="hidden" name="action" value="regVehicle">
                    </li>
                 </ul>
            </form>
        </main>
        <hr>
        <footer>
           <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php' ?>
        </footer>
    </div>
</body>

</html>