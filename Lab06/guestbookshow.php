<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="author" content="Ved Makhijani" />
<title>View Guestbook</title>
</head>
<body>
<h1>Lab06 Task 2 - Guestbook</h1>
<h2>View Guestbook</h2>
<?php
$filename = "../../data/lab06/guestbook.txt";

if (file_exists($filename) && is_readable($filename)) {
    $entries = array();
    $handle = fopen($filename, "r");
    
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);
        if ($line != "") {
            $data = explode(",", $line);
            if (count($data) >= 2) {
                $entries[] = array("name" => trim($data[0]), "email" => trim($data[1]));
            }
        }
    }
    fclose($handle);

    sort($entries);

    if (count($entries) > 0) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Number</th><th>Name</th><th>Email</th></tr>";
        $count = 1;
        foreach ($entries as $entry) {
            echo "<tr>";
            echo "<td>", $count++, "</td>";
            echo "<td>", htmlspecialchars($entry["name"]), "</td>";
            echo "<td>", htmlspecialchars($entry["email"]), "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No entries found in guestbook.</p>";
    }
} else {
    echo "<p style='color:red;'>Guestbook file does not exist or is not readable.</p>";
}
?>
<p><a href="guestbookform.php">Add Another Visitor</a></p>
</body>
</html>