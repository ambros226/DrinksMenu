<?php


$drink_list="drink-list.txt";

if (isset($_POST["drink"]) && isset($_POST["name"]) && isset($_POST["phone-num"])) {

    $drink=$_POST["drink"];
    $name=htmlspecialchars( $_POST["name"]);

    $phone=$_POST["phone-num"];
    $phone=str_replace(" ", "", $phone);

    $time=date("m-d H:i");

    $txtInput= $name . "|" . $phone . "|" . $time ."|". "$drink";

    file_put_contents($drink_list, $txtInput . "\n", FILE_APPEND);
    echo "Formulář odeslán";
    header("Location:answer.php");
    exit;
}

$zaznamy = file_exists($drink_list) ? file($drink_list, FILE_SKIP_EMPTY_LINES) : [];


?>
<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menu</title>
</head>
<body>
<h1>Menu</h1>
<div class="menu-box">
    <form method="post">
        <input type="radio" name="drink" id="mojito" value="Mojito">
        <label for="mojito">Mojito</label>

        <input type="radio" name="drink" id="cuba-libre" value="Cuba-Libre">
        <label for="cuba-libre">Cuba Libre</label>

        <input type="radio" name="drink" id="margarita" value="Margarita">
        <label for="margarita">Margarita</label>

        <div class="sign-data-box">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
            <label for="phone-num">Phone-num:</label>
            <input type="text" name="phone-num" id="phone-num" oninput="this.value = this.value.replace(/[^0-9],' '/g, '')">
        </div>

        <input type="submit">
    </form>
</div>

</body>
</html>
