<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="ved makhijani" />
    <title>Display Members</title>
</head>
<body>
    <h1>VIP Members List</h1>
    <?php
    require_once("settings.php");

    $conn = @mysqli_connect($host, $user, $pswd, $dbnm);

    if (!$conn) {
        echo "<p>Database connection failure: " . mysqli_connect_error() . "</p>";
    } else {
        $query = "SELECT member_id, fname, lname FROM vipmembers";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "<p>Something is wrong with the query: " . mysqli_error($conn) . "</p>";
        } else {
            echo "<table border=\"1\">\n";
            echo "<tr>\n"
               . "<th scope=\"col\">Member ID</th>\n"
               . "<th scope=\"col\">First Name</th>\n"
               . "<th scope=\"col\">Last Name</th>\n"
               . "</tr>\n";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>\n";
                echo "<td>", htmlspecialchars($row["member_id"]), "</td>\n";
                echo "<td>", htmlspecialchars($row["fname"]), "</td>\n";
                echo "<td>", htmlspecialchars($row["lname"]), "</td>\n";
                echo "</tr>\n";
            }
            echo "</table>\n";
            mysqli_free_result($result);
        }
        mysqli_close($conn);
    }
    ?>
    <p><a href="vip_member.php">Return to Home</a></p>
</body>
</html>