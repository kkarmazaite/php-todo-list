<?php
    include("database.php");
    include("header.php");

    if(!isset($_SESSION["user"])){
        header('Location: login.php');
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>PHP todo list</title>
</head>

<body>
    <main>
        <div class="container">
            <div class="card">
                Home
            </div>
        </div>
    </main>
</body>
</html>

<?php
    include("footer.html");
?>