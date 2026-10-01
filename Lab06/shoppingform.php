<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="author" content="Ved Makhijani" />
<title>Shopping Form</title>
</head>
<body>
<h1>Web Programming Form - Lab06</h1>
<form action="shoppingsave.php" method="post">
    <p>
        <label for="item">Item Name: </label>
        <input type="text" name="item" id="item" required />
    </p>
    <p>
        <label for="qty">Quantity: </label>
        <input type="number" name="qty" id="qty" required />
    </p>
    <p>
        <input type="submit" value="Save Item" />
    </p>
</form>
</body>
</html>