<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Web Programming :: Lab 2" />
    <meta name="keywords" content="Web,programming" />
    <title>Prime Number Result</title>
</head>
<body>
<h1>Web Programming - Lab 3</h1>
<?php
    // Step 3: Function that returns boolean true if prime number, false otherwise
    function is_prime($number) {
    if ($number     )
    // Numbers less than 2 are not prime
    if ($number < 2) {
        return false;
    }

    // Check every number from 2 up to the square root of $number
    for ($i = 2; $i * $i <= $number; $i++) {
        if ($number % $i == 0) {
            return false; // Found a factor, so it's not prime
        }
    }

    return true; // No factors found, so it is prime
}

    // Step 2: Check if form data exists
    if (isset($_GET["number"])) {
        $number = $_GET["number"];
        
        // Step 1: Test if value is a valid numeric positive whole number
        if (is_numeric($number) && $number > 0  && $number >=1 && $number <=999) {
            if (is_prime($number)) {
                echo "<p>$number is a prime number.</p>";
            } else {
                echo "<p>$number is not a prime number.</p>";
            }
        } else {
            echo "<p>Please enter a valid, positive whole number.</p>";
        }
    } else {
        echo "<p>Please enter a number using the form.</p>";
    }
?>
</body>
</html>