<?php
// about.php - Technical Information Page (Task 6)
$phpVersion = phpversion();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CampusConnect - About</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>CampusConnect</h1>
    <p>About this application</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="eventform.php">Create Event</a>
    <a href="searchform.php">Search Events</a>
    <a href="about.php">About</a>
</nav>

<main>
    <h2>Technical Information</h2>
    <ul>
        <li>
            <strong>PHP version installed on Mercury:</strong>
            <?php echo htmlspecialchars($phpVersion); ?>
            (generated dynamically using <code>phpversion()</code>)
        </li>

        <li>
            <strong>Tasks or requirements not attempted / partially implemented:</strong>
            all tasks (1-8) were attempted and completed.
        </li>

        <li>
            <strong>Special features or improvements:</strong>
            The event data file is written with an exclusive file lock (<code>flock</code>)
            to avoid corrupting records if two submissions happen at the same time. The
            search form re-displays the previously entered criteria after a search.
        </li>

        <li>
            <strong>Use of Generative AI tools:</strong>
            Claude AI was used for learning, debugging and styling purposes, each and every generated line of code was manually checked on the mercury server.
            
        </li>
    </ul>

    <p><a href="index.php">Back to Home</a></p>
</main>

</body>
</html>
