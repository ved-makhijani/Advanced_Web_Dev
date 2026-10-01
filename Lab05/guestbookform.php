<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="author" content="Your Name" />
<title>Guest Book</title>
</head>
<body>
<h1>Lab05 Task 2 - Guestbook</h1>
<fieldset>
    <legend>Enter your details to sign our guest book</legend>
    <form action="guestbooksave.php" method="post">
        <p>
            <label for="fName">First Name </label>
            <input type="text" name="fName" id="fName" />
        </p>
        <p>
            <label for="lName">Last Name </label>
            <input type="text" name="lName" id="lName" />
        </p>
        <p>
            <input type="submit" value="Submit" />
        </p>
    </form>
</fieldset>
<p><a href="guestbookshow.php">Show Guest Book</a></p>
</body>
</html>