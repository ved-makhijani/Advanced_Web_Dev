<?php
// eventprocess.php - Process and Store Event Page (Task 3)

// ---- configuration: relative filesystem path, no hard-coded username ----
$dataDir  = __DIR__ . "/../../data/campusevents";
$dataFile = $dataDir . "/events.txt";

$allowedCategories = ["Workshop", "Seminar", "Social"];
$allowedRegTypes   = ["Free", "Paid"];
$allowedLocations  = ["BA", "EN", "ATC", "AMDC", "AS", "LB", "TA", "TD"];

$errors = [];
$writeSuccess = false;
$storedTitle = "";
$storedId = "";

// Removes characters that would break the one-record-per-line, tab-delimited format
function cleanField($value) {
    $value = trim($value);
    $value = str_replace(["\t", "\r", "\n"], " ", $value);
    return $value;
}

// ---- Req 1a: only accept this page via the Create Event form (POST) ----
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $errors[] = "This page must be reached by submitting the Create Event form.";
} else {

    // ---- Req 1b: collect and trim submitted values ----
    $eventId       = isset($_POST["eventid"]) ? cleanField($_POST["eventid"]) : "";
    $title         = isset($_POST["title"]) ? cleanField($_POST["title"]) : "";
    $description   = isset($_POST["description"]) ? cleanField($_POST["description"]) : "";
    $eventDate     = isset($_POST["eventdate"]) ? cleanField($_POST["eventdate"]) : "";
    $category      = isset($_POST["category"]) ? cleanField($_POST["category"]) : "";
    $regType       = isset($_POST["regtype"]) ? cleanField($_POST["regtype"]) : "";
    $catering      = isset($_POST["catering"]) ? "Yes" : "";
    $certificate   = isset($_POST["certificate"]) ? "Yes" : "";
    $accessibility = isset($_POST["accessibility"]) ? "Yes" : "";
    $otherSelected = isset($_POST["other_selected"]);
    $otherText     = isset($_POST["other_text"]) ? cleanField($_POST["other_text"]) : "";
    $location      = isset($_POST["location"]) ? cleanField($_POST["location"]) : "";

    // ---- Event ID ----
    if ($eventId === "") {
        $errors[] = "Event ID is required.";
    } elseif (!preg_match('/^E\d{4}$/', $eventId)) {
        $errors[] = "Event ID must be the letter E followed by exactly four digits, e.g. E0001.";
    }

    // ---- Event Title ----
    if ($title === "") {
        $errors[] = "Event Title is required.";
    } elseif (mb_strlen($title) > 60) {
        $errors[] = "Event Title must be 60 characters or fewer.";
    } elseif (!preg_match("/^[A-Za-z0-9 :,.'!-]+$/", $title)) {
        $errors[] = "Event Title may only contain letters, numbers, spaces, colon, comma, "
                  . "full stop, apostrophe, hyphen and exclamation mark.";
    }

    // ---- Description ----
    if ($description === "") {
        $errors[] = "Description is required.";
    } elseif (mb_strlen($description) > 260) {
        $errors[] = "Description must be 260 characters or fewer.";
    }

    // ---- Event Date: format, real date, today or future ----
    if ($eventDate === "") {
        $errors[] = "Event Date is required.";
    } elseif (!preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $eventDate, $m)) {
        $errors[] = "Event Date must be in dd/mm/yyyy format.";
    } else {
        $day = (int)$m[1];
        $month = (int)$m[2];
        $year = (int)$m[3];

        if (!checkdate($month, $day, $year)) {
            $errors[] = "Event Date is not a real calendar date.";
        } else {
            $submittedDate = DateTime::createFromFormat("d/m/Y", $eventDate);
            $submittedDate->setTime(0, 0, 0);
            $serverToday = new DateTime(date("Y-m-d"));

            if ($submittedDate < $serverToday) {
                $errors[] = "Event Date must be today or a future date.";
            }
        }
    }

    // ---- Event Category ----
    if ($category === "") {
        $errors[] = "Event Category is required.";
    } elseif (!in_array($category, $allowedCategories, true)) {
        $errors[] = "Event Category is not a permitted option.";
    }

    // ---- Registration Type ----
    if ($regType === "") {
        $errors[] = "Registration Type is required.";
    } elseif (!in_array($regType, $allowedRegTypes, true)) {
        $errors[] = "Registration Type is not a permitted option.";
    }

    // ---- Other Feature text required only if the checkbox was selected ----
    if ($otherSelected && $otherText === "") {
        $errors[] = "Other Feature text is required when Other Feature is selected.";
    }
    $otherFeature = $otherSelected ? $otherText : "";

    // ---- Location ----
    if ($location === "") {
        $errors[] = "Location is required.";
    } elseif (!in_array($location, $allowedLocations, true)) {
        $errors[] = "Location is not a permitted option.";
    }

    // ---- Req 1f: Event ID uniqueness check against existing records ----
    // Only worth checking if the ID itself is at least the right shape, and if
    // the data file already exists. If it does not exist yet, that is fine -
    // there is nothing to clash with.
    if (preg_match('/^E\d{4}$/', $eventId) && file_exists($dataFile)) {
        $handle = @fopen($dataFile, "r");
        if ($handle === false) {
            $errors[] = "Unable to open the events file to check Event ID uniqueness.";
        } else {
            while (($line = fgets($handle)) !== false) {
                $fields = explode("\t", rtrim($line, "\n"));
                if (isset($fields[0]) && $fields[0] === $eventId) {
                    $errors[] = "Event ID " . $eventId . " already exists. "
                              . "Please choose a different Event ID.";
                    break;
                }
            }
            fclose($handle);
        }
    }

    // ---- Req 2 & 3: create directory/file as needed and append the record ----
    if (empty($errors)) {

        if (!is_dir($dataDir)) {
            if (!@mkdir($dataDir, 0755, true)) {
                $errors[] = "Unable to create the storage directory for events.";
            }
        }

        if (empty($errors)) {
            // 11 tab-separated fields in the required order, empty fields kept as
            // empty strings so every record has the same column count
            $record = implode("\t", [
                $eventId,
                $title,
                $description,
                $eventDate,
                $category,
                $regType,
                $catering,
                $certificate,
                $accessibility,
                $otherFeature,
                $location,
            ]) . "\n";

            $handle = @fopen($dataFile, "a");
            if ($handle === false) {
                $errors[] = "Unable to open the events file for writing.";
            } else {
                if (flock($handle, LOCK_EX)) {
                    $bytesWritten = fwrite($handle, $record);
                    flock($handle, LOCK_UN);

                    if ($bytesWritten === false || $bytesWritten !== strlen($record)) {
                        $errors[] = "Writing the event record failed. Please try again.";
                    } else {
                        $writeSuccess = true;
                        $storedTitle = $title;
                        $storedId = $eventId;
                    }
                } else {
                    $errors[] = "Unable to lock the events file for writing.";
                }
                fclose($handle);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CampusConnect - Event Submission Result</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>CampusConnect</h1>
    <p>Event Submission Result</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="eventform.php">Create Event</a>
    <a href="searchform.php">Search Events</a>
    <a href="about.php">About</a>
</nav>

<main>
<?php if ($writeSuccess): ?>
    <p class="success">
        Event <strong><?php echo htmlspecialchars($storedId); ?></strong>
        "<?php echo htmlspecialchars($storedTitle); ?>" was saved successfully.
    </p>
    <p><a href="index.php">Return to Home</a></p>
<?php else: ?>
    <p class="error-heading">The event could not be saved for the following reason(s):</p>
    <ul class="error-list">
        <?php foreach ($errors as $err): ?>
            <li><?php echo htmlspecialchars($err); ?></li>
        <?php endforeach; ?>
    </ul>
    <p>
        <a href="eventform.php">Back to Create Event</a> |
        <a href="index.php">Home</a>
    </p>
<?php endif; ?>
</main>

</body>
</html>
