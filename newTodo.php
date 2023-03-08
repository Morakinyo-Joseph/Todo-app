<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>To-do APP</title>

</head>
<body class="bg-light">


<div class="container">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="new_task" class="form-control" placeholder="Input New Task Here">
        <input type="submit" name="submit" value="submit" class="btn btn-success">

    <br>

    <?php
        // Connect to the database
        $servername = "localhost";
        $username = "todoapp";
        $password = "mypassword";
        $dbname = "todo";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve the new task and add it to the database
            $newTask = $_POST["new_task"];
            if ($newTask != "") {
                $sql = "INSERT INTO tasks (task_text) VALUES ('$newTask')";
                if ($conn->query($sql) === false) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }

        // Retrieve all tasks from the database
        $sql = "SELECT * FROM tasks";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output the tasks as HTML
            while($row = $result->fetch_assoc()) {
                $taskId = $row["id"];
                $taskText = $row["task_text"];
                echo "$taskText <button class='btn btn-success' name='done' value='$taskId'>Done</button><hr>";

                // Check if a "done" button was clicked and remove the task from the database
                if (isset($_POST["done"]) && $_POST["done"] == $taskId) {
                    $sql = "DELETE FROM tasks WHERE id=$taskId";
                    if ($conn->query($sql) === false) {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        }

        // Close the database connection
        $conn->close();
    ?>

    </form>

</div>

</body>

</html>



