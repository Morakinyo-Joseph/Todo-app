<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>

<div class="container">

    <br><br>
    <form action="the_todo.php", method="post">
        <input type="text", name="task", class="form-control", placeholder="Input your task...">
        <br><br>
        <input type="submit", value="submit", name="submit", class="btn btn-primary">

        <hr>
        <h1 >Tasks</h1>

        <?php 

            // connect to the database
            $server = "localhost";
            $username = "root";
            $password = "Moraksj03mysql$.";
            $database = "mydb";
            $conn = mysqli_connect($server, $username, $password, $database);
            
            // input tasks into the database
            if ($_REQUEST["submit"]){
                $newTask = $_POST["task"];

                if ($newTask != "")
                {
                    $sql = "INSERT INTO task (text) VALUES ('$newTask')";
                    $query = mysqli_query($conn, $sql);

                    if ($query){
                        echo "<p style='color: green;'>New task uploaded <br></p>";
                    }
                }

            }

            // display task from the database
            $sql = "SELECT * FROM mydb.task";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0)
            {
                while ($row = mysqli_fetch_assoc($result))
                {
                    $number = $row['id'];
                    echo  "<p>" . $row['text'] . "<button class='btn btn-success' value='$number', name='done' style='margin-left: 50px;'>Done</button>" . "<br>";
                    echo "</p>";
                }

                // delete task from the database
                $id = $_POST["done"];
                if ($id != null)
                {
                    $del_sql = "DELETE FROM task WHERE id = $id";
                    $del_result = mysqli_query($conn, $del_sql);
                    header("Refresh: 0.5"); //after the task is deleted the whole page is automatically reloaded to such the results
                }
            }

        ?>

    </form>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</div>

</body>
</html>