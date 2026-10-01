<?php
// searchform.php - Search Event Page (Task 4, extended by Task 7)

// Re-fill the form with the previous search values if the user came back
// from the results page 
$keyword  = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
$category = isset($_GET["category"]) ? $_GET["category"] : "";
$regtype  = isset($_GET["regtype"]) ? $_GET["regtype"] : "";
$location = isset($_GET["location"]) ? $_GET["location"] : "";

$locations = ["BA", "EN", "ATC", "AMDC", "AS", "LB", "TA", "TD"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CampusConnect - Search Events</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>CampusConnect</h1>
    <p>Search for upcoming events</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="eventform.php">Create Event</a>
    <a href="searchform.php">Search Events</a>
    <a href="about.php">About</a>
</nav>

<main>
    <form action="searchprocess.php" method="get">
        <fieldset>
            <legend>Search Criteria (all fields are optional except at least one is recommended)</legend>

            <p>
                <label for="keyword">Title Keyword:</label><br>
                <input type="text" id="keyword" name="keyword"
                       value="<?php echo htmlspecialchars($keyword); ?>">
            </p>

            <p>
                <label for="category">Event Category:</label><br>
                <select id="category" name="category">
                    <option value="" <?php echo $category === "" ? "selected" : ""; ?>>Any</option>
                    <option value="Workshop" <?php echo $category === "Workshop" ? "selected" : ""; ?>>Workshop</option>
                    <option value="Seminar" <?php echo $category === "Seminar" ? "selected" : ""; ?>>Seminar</option>
                    <option value="Social" <?php echo $category === "Social" ? "selected" : ""; ?>>Social</option>
                </select>
            </p>

            <p>
                <label for="regtype">Registration Type:</label><br>
                <select id="regtype" name="regtype">
                    <option value="" <?php echo $regtype === "" ? "selected" : ""; ?>>Any</option>
                    <option value="Free" <?php echo $regtype === "Free" ? "selected" : ""; ?>>Free</option>
                    <option value="Paid" <?php echo $regtype === "Paid" ? "selected" : ""; ?>>Paid</option>
                </select>
            </p>

            <p>
                <label for="location">Location:</label><br>
                <select id="location" name="location">
                    <option value="" <?php echo $location === "" ? "selected" : ""; ?>>Any</option>
                    <?php foreach ($locations as $loc): ?>
                        <option value="<?php echo htmlspecialchars($loc); ?>"
                            <?php echo $location === $loc ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($loc); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <fieldset>
                <legend>Available Features (an event must have all ticked features)</legend>
                <input type="checkbox" id="f_catering" name="catering"
                    <?php echo isset($_GET["catering"]) ? "checked" : ""; ?>>
                <label for="f_catering">Catering</label><br>

                <input type="checkbox" id="f_certificate" name="certificate"
                    <?php echo isset($_GET["certificate"]) ? "checked" : ""; ?>>
                <label for="f_certificate">Certificate</label><br>

                <input type="checkbox" id="f_accessibility" name="accessibility"
                    <?php echo isset($_GET["accessibility"]) ? "checked" : ""; ?>>
                <label for="f_accessibility">Accessibility</label><br>

                <input type="checkbox" id="f_other" name="other"
                    <?php echo isset($_GET["other"]) ? "checked" : ""; ?>>
                <label for="f_other">Other Feature</label>
            </fieldset>

            <p>
                <button type="submit">Search</button>
            </p>
        </fieldset>
    </form>

    <p><a href="index.php">Back to Home</a></p>
</main>

</body>
</html>
