<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Ved Makhijani" />
    <title>Add Member Form</title>
</head>
<body>
    <h1>Add New VIP Member</h1>
    <form action="member_add.php" method="post">
        <p>
            <label for="fname">First Name:</label>
            <input type="text" name="fname" id="fname" required />
        </p>
        <p>
            <label for="lname">Last Name:</label>
            <input type="text" name="lname" id="lname" required />
        </p>
        <p>
            <label for="gender">Gender:</label>
            <input type="text" name="gender" id="gender" maxlength="1" required />
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required />
        </p>
        <p>
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" required />
        </p>
        <p>
            <input type="submit" value="Add Member" />
            <input type="reset" value="Clear" />
        </p>
    </form>
    <p><a href="vip_member.php">Return to Home</a></p>
</body>
</html>