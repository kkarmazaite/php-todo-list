<?php
    include("database.php");
    include("header.php");

    if(!isset($_SESSION["user"])){
        header('Location: login.php');
    }

    if(isset($_POST['add-task'])) {
        $task = filter_input(INPUT_POST, "task", FILTER_SANITIZE_EMAIL);
        $userId = $_SESSION["user"]->id;

        if(empty($task)) {
            $addTaskError = "Please fill in the task name";
        } else {
            $sql = "INSERT INTO todo_item (user_id, task)
                    VALUES('$userId', '$task')";

            try {
                mysqli_query($conn, $sql);
                header('location: index.php');
            } catch(mysqli_sql_exception) {
                $addTaskError = "An error occured, please try again later";
            }
        }
    }

    if (isset($_GET['update_task'])) {
        $id = $_GET['update_task'];
        $status = $_GET['status'];

        $sql = "UPDATE todo_item
                SET completed = '$status'
                WHERE id='$id'";

        try {
            mysqli_query($conn, $sql);
            header('location: index.php');
        } catch(mysqli_sql_exception) {
            $addTaskError = "An error occured, please try again later";
        }
    }

    if (isset($_GET['del_task'])) {
        $id = $_GET['del_task'];

        $sql = "DELETE FROM todo_item
                WHERE id='$id'";

        try {
            mysqli_query($conn, $sql);
            header('location: index.php');
        } catch(mysqli_sql_exception) {
            $addTaskError = "An error occured, please try again later";
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
    <main class="home-page">
        <div class="container">
            <div class="card">
                <h2>Task List</h2><br>

                <form method="post" action="<?php htmlspecialchars( $_SERVER["PHP_SELF"] ) ?>" class="add-task-form">
                    <input type="text" name="task" class="add-task-input" placeholder="Task name">
                    <button type="submit" name="add-task" id="add-task-btn" class="button add-task-btn">Add Task</button>
                </form>
                <div class="error-message"><?php echo (isset($addTaskError))?$addTaskError:'';?></div><br>

                <ul class="todo-list">
                    <?php 
                        $userId = $_SESSION["user"]->id;
                        $sql = "SELECT *
                                FROM todo_item
                                WHERE user_id='$userId'
                                ORDER BY completed";

                        $tasks = mysqli_query($conn, $sql);
                        
                        if(mysqli_num_rows($tasks) > 0) {
                            while($row = mysqli_fetch_assoc($tasks)) {
                                echo '
                                    <li class="todo-list-item">
                                        <span class="todo-list-item-task">
                                            <a class="todo-list-item-checkbox" href="index.php?update_task=' . $row['id'] . '&status=' . ($row['completed'] ? 0 : 1) .'">' . ($row['completed'] ? '✓' : ' ') . '</a>
                                            <span class="todo-list-item-task-name ' . ($row['completed'] ? 'completed' : '') . '">'. $row['task'] .'</span>
                                        </span> 
                                        <a class="todo-list-item-delete-button" href="index.php?del_task=' . $row['id'] . '">x</a> 
                                    </li>';
                            }
                        } else {
                            echo "<li>No tasks added</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
    </main>
</body>
</html>

<?php
    include("footer.html");

    mysqli_close($conn);
?>