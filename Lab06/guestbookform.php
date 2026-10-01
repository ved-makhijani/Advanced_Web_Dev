<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="author" content="Ved Makhijani" />
<title>Guest Book</title>
</head>
<body>
<h1>Lab06 Task 2 - Guestbook</h1>
<fieldset>
    <legend>Enter your details to sign our guest book</legend>
    <form action="guestbooksave.php" method="post">
        <p>
            <label for="name">Name: </label>
            <input type="text" name="name" id="name" />
        </p>
        <p>
            <label for="email">E-mail: </label>
            <input type="text" name="email" id="email" />
        </p>
        <p>
            <input type="submit" value="Sign" />
            <input type="reset" value="Reset Form" />
        </p>
    </form>
</fieldset>
<p><a href="guestbookshow.php">View Guest Book</a></p>
</body>
</html>