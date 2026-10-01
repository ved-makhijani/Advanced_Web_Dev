<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Ved Makhijani" />
    <title>Add Member</title>
</head>
<body>
    <h1>Add Member Processing</h1>
    <?php
    require_once("settings.php");

    $conn = @mysqli_connect($host, $user, $pswd, $dbnm);

    if (!$conn) {
        echo "<p>Database connection failure: " . mysqli_connect_error() . "</p>";
    } else {
        // Create table query
        $createTableQuery = "CREATE TABLE IF NOT EXISTS vipmembers (
            member_id INT AUTO_INCREMENT PRIMARY KEY,
            fname VARCHAR(40),
            lname VARCHAR(40),
            gender VARCHAR(1),
            email VARCHAR(40),
            phone VARCHAR(20)
        );";

        $tableResult = mysqli_query($conn, $createTableQuery);

        if (!$tableResult) {
            echo "<p>Error creating table: " . mysqli_error($conn) . "</p>";
        } else {
            if (
                isset($_POST["fname"]) && isset($_POST["lname"]) &&
                isset($_POST["gender"]) && isset($_POST["email"]) && isset($_POST["phone"])
            ) {
                // Sanitize user inputs
                $fname  = mysqli_real_escape_string($conn, trim($_POST["fname"]));
                $lname  = mysqli_real_escape_string($conn, trim($_POST["lname"]));
                $gender = mysqli_real_escape_string($conn, trim($_POST["gender"]));
                $email  = mysqli_real_escape_string($conn, trim($_POST["email"]));
                $phone  = mysqli_real_escape_string($conn, trim($_POST["phone"]));

                $insertQuery = "INSERT INTO vipmembers (fname, lname, gender, email, phone) 
                                VALUES ('$fname', '$lname', '$gender', '$email', '$phone')";

                $insertResult = mysqli_query($conn, $insertQuery);

                if ($insertResult) {
                    echo "<p>Member successfully added!</p>";
                } else {
                    echo "<p>Failed to add member: " . mysqli_error($conn) . "</p>";
                }
            } else {
                echo "<p>Please complete all form fields.</p>";
            }
        }
        mysqli_close($conn);
    }
    ?>
    <p><a href="vip_member.php">Return to Home</a></p>
</body>
</html>