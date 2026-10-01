<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Ved Makhijani" />
    <title>Search VIP Member</title>
</head>
<body>
    <h1>Search VIP Member</h1>
    <form action="member_search.php" method="get">
        <p>
            <label for="search_lname">Last Name:</label>
            <input type="text" name="search_lname" id="search_lname" required />
            <input type="submit" value="Search" />
        </p>
    </form>

    <?php
    if (isset($_GET["search_lname"]) && trim($_GET["search_lname"]) != "") {
        require_once("settings.php");

        $conn = @mysqli_connect($host, $user, $pswd, $dbnm);

        if (!$conn) {
            echo "<p>Database connection failure: " . mysqli_connect_error() . "</p>";
        } else {
            $search_lname = mysqli_real_escape_string($conn, trim($_GET["search_lname"]));
            $query = "SELECT member_id, fname, lname, email FROM vipmembers WHERE lname LIKE '%$search_lname%'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<p>Query failed: " . mysqli_error($conn) . "</p>";
            } else {
                if (mysqli_num_rows($result) > 0) {
                    echo "<table border=\"1\">\n";
                    echo "<tr>\n"
                       . "<th scope=\"col\">Member ID</th>\n"
                       . "<th scope=\"col\">First Name</th>\n"
                       . "<th scope=\"col\">Last Name</th>\n"
                       . "<th scope=\"col\">Email</th>\n"
                       . "</tr>\n";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>\n";
                        echo "<td>", htmlspecialchars($row["member_id"]), "</td>\n";
                        echo "<td>", htmlspecialchars($row["fname"]), "</td>\n";
                        echo "<td>", htmlspecialchars($row["lname"]), "</td>\n";
                        echo "<td>", htmlspecialchars($row["email"]), "</td>\n";
                        echo "</tr>\n";
                    }
                    echo "</table>\n";
                } else {
                    echo "<p>No members found matching that last name.</p>";
                }
                mysqli_free_result($result);
            }
            mysqli_close($conn);
        }
    }
    ?>
    <p><a href="vip_member.php">Return to Home</a></p>
</body>
</html>