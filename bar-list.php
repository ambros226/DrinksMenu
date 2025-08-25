<?php
$order_list = "order-list.txt";
$zaznamy = file_exists($order_list) ? file($order_list, FILE_SKIP_EMPTY_LINES) : [];
if(isset($_GET['orders-list'])){
    function OrderList($zaznamy)
    {

        $num_order = 0;
        if (!empty($zaznamy)) {
            foreach ($zaznamy as $order) {
                $order_line = explode("|", $order);
                $index = $num_order;
                $num_order++;
                $name = $order_line[0];
                $phone = $order_line[1];
                $date = $order_line[2];
                $drink = $order_line[3];
                echo "
<article>
<h4>$num_order</h4>
<p><b>Name:</b> $name | <b>Phone-num:</b> $phone | <b>Date:</b> $date</p>
<div class='drink-text'>
<p ><b>Drink:</b>  $drink</p>
<form method='get'>
<input type='hidden' name='index' value='$index'>
<input type='submit' name='finished' >
</form>
</div>
</article>
";

            }
        };
    }

    OrderList($zaznamy);
    exit();
}
?>
<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Barman-Terminal</title>
</head>
<body>
<?php
require_once 'header.php';
?>

<section id="sc-order">
    <h2>Orders</h2>
    <div class="order-box">
        <?php



        if (isset($_GET['finished']) && isset($_GET['index'])) {
            $index = $_GET['index'];
            DeletingOrder($zaznamy, $index);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;

        }
        function DeletingOrder($zaznamy, $index)
        {
            unset($zaznamy[$index]);
            file_put_contents("order-list.txt", implode(PHP_EOL, $zaznamy));
        }

        ;


        ?>
    </div>
</section>


<section id="sc-drinks">
    <?php
    $drink_list = "drinks.txt";
    $menu = file_exists($drink_list) ? file($drink_list, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

    function SetDrink(&$menu, $index)
    {
        $drink = $menu[$index];
        $drink_line = explode("|", $drink);
        if ($drink_line[0] == "on") {
            $drink_line[0] = "off";
        } elseif ($drink_line[0] == "off") {
            $drink_line[0] = "on";
        }
        $menu[$index] = implode("|", $drink_line);
        file_put_contents("drinks.txt", implode(PHP_EOL, $menu));
    }
    function DeletingMenuDrink(&$menu, $index){

        unset($menu[$index]);
        file_put_contents("drinks.txt", implode(PHP_EOL, $menu));
    }

    if (isset($_GET['drink'])) {
        SetDrink($menu, $_GET['index_d']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    if(isset($_GET['delete'])){
        DeletingMenuDrink($menu, $_GET['index_d']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    function DrinkList($menu)
    {
        $index = 0;
        foreach ($menu as $drink) {
            $drink_line = explode("|", $drink);
            $set = $drink_line[0];
            $drink = $drink_line[1];
            echo "
        <article> 
        <p>Drink: <b>$drink</b></p>
        <form method='get'>
            <input type='hidden' name='index_d' value='$index'>
            <input type='submit' value='$set' name='drink'> 
            <input type='submit' name='delete' value='x'>
        </form>
        </article>
        ";
            $index++;
        }
    }
    DrinkList($menu);
    ?>
</section>
<section id="add-new">

    <?php
    function contSymb($name)
    {
        $name_list = preg_split('//u', $name, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($name_list as $char) {
            if (in_array($char, ["@", "#", "$", "~", "&", ".", ",", "_", "!", "?", "§"])) {
                return true;
            }
        }
        return false;
    }
    function contNum($name)
    {
        $name_list = preg_split('//u', $name, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($name_list as $char) {
            if (in_array($char, ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"])) {
                return true;
            }
        }
        return false;
    }
    
    if (!empty($_GET['new-drink'] )) {
        $new_drink = $_GET['new-drink'];
        if(!contSymb($new_drink) and !contNum($new_drink)) {
            if (isset($_GET['add'])) {
                $txtInput="off"."|".$new_drink;
                file_put_contents($drink_list, "\n". $txtInput , FILE_APPEND);
                header("Location: " . $_SERVER['PHP_SELF']);
            }
        }
    }
    
    
    ?>
    <div class="add-box">
        <div id="heading">
            <h3>Add new drink: </h3>
        </div>

        <form method="get">
            <input type="text" name="new-drink" maxlength="21">
            <input type="submit" name="add" value="+">
        </form>
    </div>

</section>

<script>
    setInterval(() => {
        fetch('bar-list.php?orders-list')
            .then(response => response.text())
            .then(html => {
                document.querySelector('.order-box').innerHTML = html;
            })
            .catch(error => console.error('Chyba:', error));
    }, 10000);


    fetch('bar-list.php?orders-list')
        .then(response => response.text())
        .then(html => {
            document.querySelector('.order-box').innerHTML = html;
        });
</script>
<?php
require_once 'footer.php';
?>
</body>
</html>
