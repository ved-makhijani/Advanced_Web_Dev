<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Web Programming :: Lab 2" />
    <meta name="keywords" content="Web,programming" />
    <title>Leap Year Result</title>
</head>
<body>
<h1>Web Programming - Lab 2</h1>
<?php
    // Step 3: Function that returns boolean true if leap year, false otherwise
    function is_leapyear($year) {
        if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
            return true;
        }
        return false;
    }

    // Step 2: Check if form data exists
    if (isset($_GET["year"])) {
        $year = $_GET["year"];
        
        // Step 1: Test if value is a valid numeric year
        if (is_numeric($year) && $year > 0 && floor($year) == $year) {
            if (is_leapyear($year)) {
                echo "<p>$year is a leap year.</p>";
            } else {
                echo "<p>$year is a standard year.</p>";
            }
        } else {
            echo "<p>Please enter a valid, positive whole number for the year.</p>";
        }
    } else {
        echo "<p>Please enter a year using the form.</p>";
    }
?>
</body>
</html>