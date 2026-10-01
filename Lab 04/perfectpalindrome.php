<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="author" content="Ved Makhijani" />
<title>TITLE</title>
</head>
<body>
<h1>Web Programming - Lab 4</h1>
<?php 
if (isset ($_POST["str"])){ 
    $str = $_POST["str"]; 
    $cleanstr = strtolower($str);
    $revstr=strrev($cleanstr);
    if (strcmp($cleanstr,$revstr) == 0 ) {
        echo "<p> The Text you entered,\"", $str , "\",is a perfect palindrome !" ; 
    } else { 
        echo "<p>The Text you entered, \"", $str, "\", is NOT a palindrome.</p>";
    }
} else { // no input
    echo "<p>Please enter string from the input form.</p>";
}
?>
</body>
</html>