<?php
if (isset($_GET['drinks-list'])) {
    $drink_list = "drinks.txt";
    $menu = file_exists($drink_list) ? file($drink_list, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

    function DrinksList($menu)
    {
        foreach ($menu as $line) {
            $drink_line = explode("|", $line);
            $set = $drink_line[0];
            $drink = $drink_line[1];
            $value = ucfirst($drink);
            if ($set == "on") {
                echo "<label for='" . htmlspecialchars($drink) . "'>
                        <input type='radio' name='drink' id='" . htmlspecialchars($drink) . "' value='" . htmlspecialchars($value) . "'> $value
                      </label>";
            }
        }
    }

    DrinksList($menu);
    exit;
}
function UsernameTest($name)
{
    $correct = true;
    if (contNum($name)) {
        $correct = false;
    }
    if (contSymb($name)) {
        $correct = false;
    }
    return $correct;
}

function error_print($error)
{
    echo "<div class='error-field'><p>$error</p></div>";
}

function contSymb($name)
{
    $name_list = preg_split('//u', $name, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($name_list as $char) {
        if (in_array($char, ["@", "#", "$", "~", "&", ".", ",", "_", "!", "?", "§"])) {
            $error = "The username can't contains symbols.";
            error_print($error);
            return true;
        }
    }
    return false;
}

;

function contNum($name)
{
    $name_list = preg_split('//u', $name, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($name_list as $char) {
        if (in_array($char, ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"])) {
            $error = "The username can't contains numbers.";
            error_print($error);
            return true;
        }
    }
    return false;
}

function LongNum($phone)
{
    $phone_list = str_split($phone);
    if (count($phone_list) > 9) {
        $error = "The Phone number can't be longer.";
        error_print($error);
        return false;
    } else if (count($phone_list) < 9) {
        $error = "The Phone number can't be shorter.";
        error_print($error);
        return false;
    }
    return true;

}

function CutPhoneNum($phone)
{
    $phone_list = str_split($phone);
    if (count($phone_list) > 9) {
        if (implode("", array_slice($phone_list, 0, 3)) == "420") {
            $phone_list = array_slice($phone_list, 3);

        }
    }
    return implode("", $phone_list);
}


$drink_list = "order-list.txt";

if (isset($_POST["drink"]) && !empty($_POST["name"]) && !empty($_POST["phone-num"])) {
    if (UsernameTest($_POST["name"])) {
        $drink = $_POST["drink"];
        $name = htmlspecialchars($_POST["name"]);

        $phone = $_POST["phone-num"];
        $phone = str_replace(" ", "", $phone);
        $phone = CutPhoneNum($phone);
        if (LongNum($phone)) {
            $time = date("m-d H:i");

            $txtInput = $name . "|" . $phone . "|" . $time . "|" . "$drink";

            file_put_contents($drink_list, $txtInput . "\n", FILE_APPEND);
            header("Location:answer.php");
            exit;
        }

    }

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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once "header.php";
?>
<div class="menu-box">
    <form method="post">
        <div class="drink-box">

            

        </div>
        <div class="sign-data-box">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            <label for="phone-num">Phone-num:</label>
            <input type="text" name="phone-num" id="phone-num"
                   oninput="this.value = this.value.replace(/[^0-9],' '/g, '')" required
                   value="<?= htmlspecialchars($_POST['phone-num'] ?? '') ?>">
            <input type="submit" value="ORDER">
        </div>


    </form>
</div>
<script>
    setInterval(() => {
        fetch('menu.php?drinks-list')
            .then(response => response.text())
            .then(html => {
                document.querySelector('.drink-box').innerHTML = html;
            })
            .catch(error => console.error('Chyba:', error));
    }, 10000);

    // Pro okamžité načtení při startu stránky:
    fetch('menu.php?drinks-list')
        .then(response => response.text())
        .then(html => {
            document.querySelector('.drink-box').innerHTML = html;
        });
</script>
<?php
require_once "footer.php";
?>

</body>
</html>
