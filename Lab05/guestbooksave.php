<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="author" content="Your Name" />
<title>Sign Guestbook</title>
</head>
<body>
<h1>Lab05 Task 2 - Sign Guestbook</h1>
<?php
if (!empty($_POST["fName"]) && !empty($_POST["lName"])) {
    $fName = $_POST["fName"];
    $lName = $_POST["lName"];

    umask(0007);
    $dir = "../../data/lab05";
    if (!is_dir($dir)) {
        mkdir($dir, 02770);
    }

    $filename = "../../data/lab05/guestbook.txt";

    if (is_writable(dirname($filename))) {
        $handle = fopen($filename, "a");
        $entry = $lName . ", " . $fName . "\n";
        
        if (fwrite($handle, $entry) !== false) {
            echo "<p style='color:green;'>Thank you for signing our guest book!</p>";
        } else {
            echo "<p style='color:red;'>Cannot add your name to the Guest book.</p>";
        }
        fclose($handle);
    } else {
        echo "<p style='color:red;'>Cannot write to file directory.</p>";
    }
} else {
    echo "<p style='color:red;'>You must enter your first and last name!<br />";
    echo "Use the Browser's 'Go Back' button to return to the Guestbook form.</p>";
}
?>
<p><a href="guestbookshow.php">Show Guest Book</a></p>
</body>
</html>