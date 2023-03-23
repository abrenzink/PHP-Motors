<!DOCTYPE html>

<html lang=en>

<head>
    <meta charset="UTF-8">
    <title>Home | PHP Motors</title>
    <link href="/phpmotors/css/small.css" type="text/css" rel="stylesheet">
    <link href="/phpmotors/css/large.css" type="text/css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div id="wrapper">
        <header id="top-header">
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/header.php'?>
        </header>
        <nav>
            <?php //require $_SERVER['DOCUMENT_ROOT'] .'/PHPMOTORS/COMMON/NAV.PHP' 
            echo $navDisplay; ?>
        </nav>
        <main>
            <div id=main-wrapper>
                <div class="del-wrapper">
                    <h1>Welcome to PHP Motors!</h1>
                    <img id="delorean" src="/phpmotors/images/delorean.jpg" alt="Deloran illustrated model"/>
                    <p><b>DMC Deloran</b><br>3 Cup holder<br>Superman doors<br>Fuzzy dice!</p>
                    <button id="own-button">
                        <img src="/phpmotors/images/site/own_today.png" alt="Own-today image button"/>
                    </button>
                </div>
                
                <div id="home-reviews">
                    <h2>DMC Delorean Reviews</h2>
                    <ul>
                        <li>"So fast its almost like travaleing in time."</li>
                        <li>"Coolest ride on the road."</li>
                        <li>"I'm feeling MartMcFly!."</li>
                        <li>"The most futuristic ride of our day."</li>
                        <li>"80's livin and I love it!"</li>
                    </ul>
                </div>
            
                <div id="home-upgrades">
                <h2>Delorean Upgrades</h2>
                    <div id="items-wrapper">
                        <div class="up-item">
                            <div class="item-img">
                                <img src="/phpmotors/images/upgrades/flux-cap.png" alt="Flux Capacitor image"/>
                            </div>
                            <a href=#>Flux Capacitor</a>
                        </div>
                        <div class="up-item">
                            <div class="item-img">
                                <img src="/phpmotors/images/upgrades/flame.jpg" alt="Flame Decals image"/>
                            </div>
                            <a href=#>Flame Decals</a>
                        </div>
                        <div class="up-item">
                            <div class="item-img">
                                <img src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt="Bumper Stickers Image"/>
                            </div>
                            <a href=#>Bumper Stickers</a>
                        </div>
                        <div class="up-item">
                            <div class="item-img">
                                <img src="/phpmotors/images/upgrades/hub-cap.jpg" alt="Hub Caps image"/>
                            </div>
                            <a href=#>Hub Caps</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <hr>
        <footer>
           <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php' ?>
        </footer>
    </div>
</body>

</html>