<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" >
<meta name="description" content="Web Programming :: Lab 2" >
<meta name="keywords" content="Web,programming" >
<title>days</title>
</head>
<body>
<h1>Web Programming - Lab 2</h1>
<?php
$days = array ("monday","tuesday","wednesday","thursday","friday","saturday","sunday "); // declare and initialise array

echo "the days of the week are: ";
foreach ($days as $day){
    echo $day . " ";
}

$french_days = array ("lundi","mardi","mercredi","jeudi","vendredi","samedi","dimanche "); // declare and initialise array

echo "<br>the days of the week in french are: ";
foreach ($days as $day){
    echo $day . " ";
}
?>
</body>
</html>