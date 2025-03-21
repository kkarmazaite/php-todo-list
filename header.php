<?php
    session_start();    

    if(isset($_SESSION["user"])){
        $userName = $_SESSION["user"]->name;
        $userInfo = '<span>Welcome, <b>' . $userName.'</b></span>';
        $logOutButton = '<form class="logout" action="' . htmlspecialchars( $_SERVER["PHP_SELF"]) .'" method="post"> <input class="button" type="submit" name="logout" value="logout"></form>';
    }

    if(isset($_POST["logout"])){
        session_destroy();
        header('Location: login.php');
    }
?>

<header>
    <div class="container">
        <div class="header-main">
            <h2 class="logo">PHP Todo List</h2>
            <div class="user-info"><?php echo (isset($userInfo))?$userInfo . $logOutButton:'';?></div>
        </div>
    </div>
</header>