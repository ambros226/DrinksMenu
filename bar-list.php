<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh" content="10">
    <title>Barman-Terminal</title>
</head>
<body>
<?php

$drink_list = "drink-list.txt";
$zaznamy = file_exists($drink_list) ? file($drink_list, FILE_SKIP_EMPTY_LINES) : [];
$num_order = 0;
if (!empty($zaznamy)) {
    foreach ($zaznamy as $order) {
        $order_line=explode("|",$order);
        $num_order++;
        $name=$order_line[0];
        $phone=$order_line[1];
        $date=$order_line[2];
        $drink=$order_line[3];
        echo "
<div> 
<h2>$num_order</h2>
<p>$name</p>
<p>$phone</p>
<p>$date</p>
<p>$drink</p>
 </div>";

    }
};
?>

</body>
</html>
