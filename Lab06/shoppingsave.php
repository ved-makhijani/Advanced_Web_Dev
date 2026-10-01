<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="author" content="Ved Makhijani" />
<title>Shopping Save</title>
</head>
<body>
<h1>Web Programming - Lab06</h1>
<?php
if (isset($_POST["item"]) && isset($_POST["qty"])) { // (1)
    $item = $_POST["item"]; // (2)
    $qty = $_POST["qty"]; // (3)
    $filename = "../../data/shop.txt";
    $alldata = array();

    if (file_exists($filename)) { // (4)
        $itemdata = array(); // (5)
        $handle = fopen($filename, "r"); // (6)
        while (($onedata = fgets($handle)) !== false) { // (7)
            $onedata = trim($onedata);
            if ($onedata != "") {
                $data = explode(",", $onedata); // (8)
                $alldata[] = $data;
                $itemdata[] = $data[0];
            }
        }
        fclose($handle); // (9)
        $newdata = !(in_array($item, $itemdata)); // (10)
    } else {
        $newdata = true; 
    }

    if ($newdata) {
        $handle = fopen($filename, "a"); // (11)
        $data = $item . "," . $qty . "\n";
        fwrite($handle, $data); // (12)
        fclose($handle); // (13)
        $alldata[] = array($item, $qty);
        echo "<p>Shopping item added</p>";
    } else {
        echo "<p>Shopping item already exists</p>";
    }

    sort($alldata); // (14)
    echo "<p>Shopping List</p>";
    foreach ($alldata as $data) { // (15), (16)
        echo "<p>", htmlspecialchars($data[0]), ", ", htmlspecialchars($data[1]), "</p>";
    }
} else {
    echo "<p>Please enter item and quantity in the input form.</p>";
}
?>
</body>
</html>