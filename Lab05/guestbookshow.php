<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="author" content="Your Name" />
<title>View Guestbook</title>
</head>
<body>
<h1>Lab05 Task 2 - View Guestbook</h1>
<?php
$filename = "../../data/lab05/guestbook.txt";

if (is_readable($filename)) {
    $content = file_get_contents($filename);
    echo "<pre>", htmlspecialchars($content, ENT_QUOTES, "UTF-8"), "</pre>";
} else {
    echo "<p style='color:red;'>Cannot read guestbook file or no entries found.</p>";
}
?>
<p><a href="guestbookform.php">Back to Guestbook Form</a></p>
</body>
</html>