<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="author" content="Ved Makhijani" />
<title>Sign Guestbook</title>
</head>
<body>
<h1>Lab06 Task 2 - Guestbook</h1>
<h2>Sign Guestbook</h2>
<?php
if (!empty($_POST["name"]) && !empty($_POST["email"])) {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);

    umask(0007);
    $dir = "../../data/lab06";
    if (!is_dir($dir)) {
        mkdir($dir, 02770);
    }

    $filename = "../../data/lab06/guestbook.txt";
    $names = array();
    $emails = array();

    if (file_exists($filename)) {
        $handle = fopen($filename, "r");
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if ($line != "") {
                $parts = explode(",", $line);
                if (count($parts) >= 2) {
                    $names[] = trim($parts[0]);
                    $emails[] = trim($parts[1]);
                }
            }
        }
        fclose($handle);
    }

    if (in_array($name, $names) || in_array($email, $emails)) {
        echo "<p style='color:red;'>You have already signed the guest book!</p>";
    } else {
        $handle = fopen($filename, "a");
        $entry = $name . "," . $email . "\n";
        if (fwrite($handle, $entry) !== false) {
            echo "<p style='color:green;'>Thank you for signing our guest book!</p>";
            echo "<p><strong>Name:</strong> ", htmlspecialchars($name), "<br />";
            echo "<strong>E-mail:</strong> ", htmlspecialchars($email), "</p>";
        } else {
            echo "<p style='color:red;'>Cannot write to guestbook file.</p>";
        }
        fclose($handle);
    }
} else {
    echo "<p style='color:red;'>You must enter your name and email address!<br />";
    echo "Use the Browser's 'Go Back' button to return to the Guestbook form.</p>";
}
?>
<p><a href="guestbookform.php">Add Another Visitor</a></p>
<p><a href="guestbookshow.php">View Guest Book</a></p>
</body>
</html>