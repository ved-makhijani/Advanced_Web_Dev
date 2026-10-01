<?php
// searchprocess.php - Search Event Result Page
// Task 5: basic title search
// Task 7: extends this same page with optional AND-combined criteria
// Task 8: extends this same page to keep only upcoming events, sorted by date

$dataDir  = __DIR__ . "/../../data/campusevents";
$dataFile = $dataDir . "/events.txt";

$allowedCategories = ["Workshop", "Seminar", "Social"];
$allowedRegTypes   = ["Free", "Paid"];
$allowedLocations  = ["BA", "EN", "ATC", "AMDC", "AS", "LB", "TA", "TD"];

$fieldNames = [
    "eventid", "title", "description", "eventdate", "category", "regtype",
    "catering", "certificate", "accessibility", "otherfeature", "location",
];

$errors = [];
$results = [];
$searchAttempted = ($_SERVER["REQUEST_METHOD"] === "GET" && !empty($_GET));

// ---- Req 1/Task 7: read and validate the submitted criteria (all optional) ----
$keyword  = isset($_GET["keyword"]) ? trim($_GET["keyword"]) : "";
$category = isset($_GET["category"]) ? trim($_GET["category"]) : "";
$regtype  = isset($_GET["regtype"]) ? trim($_GET["regtype"]) : "";
$location = isset($_GET["location"]) ? trim($_GET["location"]) : "";
$wantCatering      = isset($_GET["catering"]);
$wantCertificate   = isset($_GET["certificate"]);
$wantAccessibility = isset($_GET["accessibility"]);
$wantOther         = isset($_GET["other"]);

if ($category !== "" && !in_array($category, $allowedCategories, true)) {
    $errors[] = "Event Category is not a permitted option.";
}
if ($regtype !== "" && !in_array($regtype, $allowedRegTypes, true)) {
    $errors[] = "Registration Type is not a permitted option.";
}
if ($location !== "" && !in_array($location, $allowedLocations, true)) {
    $errors[] = "Location is not a permitted option.";
}

// ---- Req 2: check the data file before attempting to read it ----
$records = [];
if (empty($errors)) {
    if (!file_exists($dataFile)) {
        // Not an error - simply no events have been created yet
        $records = [];
    } else {
        $handle = @fopen($dataFile, "r");
        if ($handle === false) {
            $errors[] = "Unable to open the events file. Please try again later.";
        } else {
            // ---- Req 3: read all records and split into the 11 fields ----
            while (($line = fgets($handle)) !== false) {
                $line = rtrim($line, "\n");
                if ($line === "") {
                    continue;
                }
                $parts = explode("\t", $line);
                // pad to 11 fields in case of a short/malformed line
                while (count($parts) < 11) {
                    $parts[] = "";
                }
                $records[] = array_combine($fieldNames, array_slice($parts, 0, 11));
            }
            fclose($handle);
        }
    }
}

// ---- Req 4/Task 7: apply all supplied criteria using AND logic ----
if (empty($errors)) {
    foreach ($records as $record) {

        if ($keyword !== "" && stripos($record["title"], $keyword) === false) {
            continue;
        }
        if ($category !== "" && $record["category"] !== $category) {
            continue;
        }
        if ($regtype !== "" && $record["regtype"] !== $regtype) {
            continue;
        }
        if ($location !== "" && $record["location"] !== $location) {
            continue;
        }
        if ($wantCatering && $record["catering"] !== "Yes") {
            continue;
        }
        if ($wantCertificate && $record["certificate"] !== "Yes") {
            continue;
        }
        if ($wantAccessibility && $record["accessibility"] !== "Yes") {
            continue;
        }
        if ($wantOther && trim($record["otherfeature"]) === "") {
            continue;
        }

        $results[] = $record;
    }

    // ---- Task 8: keep only upcoming events (today or later) ----
    $today = new DateTime(date("Y-m-d"));
    $upcoming = [];
    foreach ($results as $record) {
        $eventDateTime = DateTime::createFromFormat("d/m/Y", $record["eventdate"]);
        if ($eventDateTime === false) {
            // Skip records with an unreadable date rather than crash the page
            continue;
        }
        $eventDateTime->setTime(0, 0, 0);
        if ($eventDateTime >= $today) {
            $record["_sortdate"] = $eventDateTime;
            $upcoming[] = $record;
        }
    }

    // ---- Task 8: sort ascending by date, stable on same-day records ----
    usort($upcoming, function ($a, $b) {
        if ($a["_sortdate"] == $b["_sortdate"]) {
            return 0;
        }
        return ($a["_sortdate"] < $b["_sortdate"]) ? -1 : 1;
    });

    $results = $upcoming;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CampusConnect - Search Results</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>CampusConnect</h1>
    <p>Search Results</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="eventform.php">Create Event</a>
    <a href="searchform.php">Search Events</a>
    <a href="about.php">About</a>
</nav>

<main>
<?php if (!empty($errors)): ?>
    <p class="error-heading">Your search could not be completed for the following reason(s):</p>
    <ul class="error-list">
        <?php foreach ($errors as $err): ?>
            <li><?php echo htmlspecialchars($err); ?></li>
        <?php endforeach; ?>
    </ul>

<?php elseif (empty($results)): ?>
    <p class="no-results">No upcoming events matched your search criteria.</p>

<?php else: ?>
    <p><?php echo count($results); ?> upcoming event(s) found, soonest first:</p>

    <?php foreach ($results as $event): ?>
        <article class="event-card">
            <h2><?php echo htmlspecialchars($event["title"]); ?>
                (<?php echo htmlspecialchars($event["eventid"]); ?>)</h2>
            <p><?php echo htmlspecialchars($event["description"]); ?></p>
            <ul>
                <li><strong>Date:</strong> <?php echo htmlspecialchars($event["eventdate"]); ?></li>
                <li><strong>Category:</strong> <?php echo htmlspecialchars($event["category"]); ?></li>
                <li><strong>Registration:</strong> <?php echo htmlspecialchars($event["regtype"]); ?></li>
                <li><strong>Location:</strong> <?php echo htmlspecialchars($event["location"]); ?></li>
                <li><strong>Catering:</strong> <?php echo $event["catering"] === "Yes" ? "Yes" : "No"; ?></li>
                <li><strong>Certificate:</strong> <?php echo $event["certificate"] === "Yes" ? "Yes" : "No"; ?></li>
                <li><strong>Accessibility:</strong> <?php echo $event["accessibility"] === "Yes" ? "Yes" : "No"; ?></li>
                <?php if (trim($event["otherfeature"]) !== ""): ?>
                    <li><strong>Other Feature:</strong> <?php echo htmlspecialchars($event["otherfeature"]); ?></li>
                <?php endif; ?>
            </ul>
        </article>
    <?php endforeach; ?>
<?php endif; ?>

    <p>
        <a href="searchform.php">Back to Search</a> |
        <a href="index.php">Home</a>
    </p>
</main>

</body>
</html>