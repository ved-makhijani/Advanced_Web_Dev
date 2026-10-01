<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="author" content="Your Name" />
<title>Shopping Save</title>
</head>
<body>
<h1>Web Programming Lab 5</h1>
<?php 
if (isset($_POST["item"]) && isset($_POST["qty"])) {
    $item = $_POST["item"];
    $qty = $_POST["qty"];

    $filename = "../../data/shop.txt";
    $handle = fopen($filename, "a");
    $data = $item . "," . $qty . "\n";
    
    fwrite($handle, $data);
    fclose($handle);

    echo "<p>Shopping List</p>";

    $handle = fopen($filename, "r");
    while (($data = fgets($handle)) !== false) {
        echo "<p>", htmlspecialchars($data, ENT_QUOTES, "UTF-8"), "</p>";
    }
    fclose($handle);
} else {
    echo "<p>Please enter item and quantity in the input form.</p>";
}
?>
</body>
</html>