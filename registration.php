<?php
    include("database.php");

    include("header.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($username) || empty($email) || empty( $password)) {
            $error = "Please fill in all the fields";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, email, password)
                    VALUES('$username', '$email','$hash')";

            try {
                mysqli_query($conn, $sql);

                header('Location: login.php');
            } catch(mysqli_sql_exception) {
                $error = "This email is already taken";
            }
        }
    }
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
                <form action="<?php htmlspecialchars( $_SERVER["PHP_SELF"] ) ?>" method="post">
                    <h2>Registration</h2>
                    <label>username:</label><br>
                    <input type="text" name="username" placeholder="name"><br>
                    <label>email:</label><br>
                    <input type="email" name="email" placeholder="name@test.com"><br>
                    <label>password:</label><br>
                    <input type="password" name="password" placeholder="password"><br><br>
                    <input class="button" type="submit" name="submit" value="register"><br>
                </form>
                
                <div class="error-message"><?php echo (isset($error))?$error:'';?></div>
            </div>
        </div>
    </main>
</body>
</html>

<?php
    include("footer.html");
?>