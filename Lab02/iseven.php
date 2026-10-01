<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" >
<meta name="description" content="Web Programming :: Lab 2" >
<meta name="keywords" content="Web,programming" >
<title>is even </title>
</head>
<body>
<h1>Web Programming - Lab 2</h1>
<?php
$number = 10.7; // declare and initialise variable
if (is_numeric($number)) {
    echo "<p>$number is a number</p>";
    $number=round($number); // round the number to nearest integer
    if ($number % 2 == 0) { // check if number is even
        echo "<p>$number is even</p>";
    } else {
        echo "<p>$number is odd</p>";
}
} else {
    echo "<p>$number is not a number</p>";
}


?>
</body>
</html>