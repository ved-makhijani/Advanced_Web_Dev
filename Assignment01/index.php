<?php
// index.php - CampusConnect Home Page (Task 1)

$fullName  = "Ved Jay Makhijani";
$studentId = "104762184";
$email     = "104762184@student.swin.edu.au";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CampusConnect - Home</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>CampusConnect</h1>
    <p>Campus event listing and search system</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="eventform.php">Create Event</a>
    <a href="searchform.php">Search Events</a>
    <a href="about.php">About</a>
</nav>

<main>
    <section class="student-details">
        <h2>Student Details</h2>
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($fullName); ?></p>
        <p><strong>Student ID:</strong> <?php echo htmlspecialchars($studentId); ?></p>
        <p><strong>Swinburne Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p class="declaration">
            I declare that this assignment is my individual work. I have not worked
            collaboratively, nor have I copied from any other student's work or from
            any other source.
        </p>
    </section>

    <section class="welcome">
        <h2>Welcome</h2>
        <p>
            CampusConnect lets Swinburne clubs and societies list campus events, and lets
            students browse, search and filter upcoming events.
        </p>
        <ul>
            <li><a href="eventform.php">Create a new event listing</a></li>
            <li><a href="searchform.php">Search for existing events</a></li>
            <li><a href="about.php">About this application</a></li>
        </ul>
    </section>
</main>

<footer>
    <p>CampusConnect COS30020 Assignment 1</p>
</footer>

</body>
</html>
