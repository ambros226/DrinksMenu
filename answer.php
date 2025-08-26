<?php

?>
<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="animation.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=check" />
    <title>Thanks</title>
</head>
<body>
<section>
    <div>
        <h1 id="check-head">Order sent</h1>
    </div>


    <div class="pipe">
        <span class="material-symbols-outlined check-icon">check</span>
    </div>

    <div id="check-info">
        <?php
        session_start();

        $name = $_SESSION['user-info']['name'];
        $phone = $_SESSION['user-info']['phone'];
        $drink = $_SESSION['user-info']['drink'];
        $phone= "+420 ". trim(chunk_split($phone, 3, " "));
        echo '<p><b>name: </b>' . $name . '</p>';
        echo '<p><b>drink: </b>' . $drink . '</p>';
        echo '<p><b>phone: </b>' . $phone . '</p>';

        ?>
    </div>

    <div id="check-back">
        <a href="menu.php" >Order another</a>
    </div>

</section>
</body>
</html>
