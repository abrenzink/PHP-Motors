<!DOCTYPE html>

<html lang=en>

<head>
    <meta charset="UTF-8">
    <title><?php echo $classificationName; ?> vehicles | PHP Motors, Inc.</title>
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
            <h1><?php echo $classificationName; ?> Vehicles</h1>
            <?php if(isset($message)){
                echo $message; }
            ?>
            <?php if(isset($vehicleDisplay)){
                echo $vehicleDisplay;
            } ?>
        </main>
        <hr>
        <footer>
           <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php' ?>
        </footer>
    </div>
</body>

</html>