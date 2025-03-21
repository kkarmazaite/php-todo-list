<?php
    include("database.php");

    include("header.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($email) || empty( $password)) {
            $error = "Please fill in all the fields";
        } else {
            $sql = "SELECT *
                    FROM users
                    WHERE email='$email'";

            try {
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        if(password_verify($password, $row["password"])){
                            $user = (object) [
                                "id" =>  $row["id"],
                                "name" =>  $row["name"],
                                "email" =>  $row["email"],
                            ];
                            $_SESSION["user"] = $user;

                            header('Location: index.php');
                        } else {
                            $loginError = true;
                        }
                    }
                  } else {
                    $loginError = true;
                  }
            } catch(mysqli_sql_exception) {
                $loginError = true;
            }

            if(isset($loginError)) {
                $error = "Incorect email or password!";
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
                    <h2>Login</h2>
                    <label>email:</label><br>
                    <input type="email" name="email" placeholder="name@test.com"><br>
                    <label>password:</label><br>
                    <input type="password" name="password" placeholder="password"><br><br>
                    <input class="button" type="submit" name="submit" value="login"><br>
                    <a href="registration.php">Register New User</a>
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