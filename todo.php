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

    <form action="todo.php", method="post">
        <input type="text", name="new_task", class="form-control", placeholder="Input New Task Here">
        <br>
        <input type="submit", value="submit", class="btn btn-success">

    <br>

    <?php

        $newTask = $_POST["new_task"];

        if(file_exists("myjson.json")){
            $file = "myjson.json";
            $json_data = file_get_contents($file);
            $php_data = json_decode($json_data, true);
            
            $id_counter = 0;
            foreach ($php_data as $data){
                $id_counter += 1;

            }
            
            if ($newTask != ""){
                $task = [
                    "id" => $id_counter,
                    "text" => $newTask
                ];

                $php_data[] = $task;
                $result = json_encode($php_data);
                file_put_contents("myjson.json", $result);
            }
        }
        else{
            if ($newTask != ""){

                $task = array(
                    [
                        "id" => 0,
                        "text" => $newTask
                    ],

                );
            }

            $json = json_encode($task);
            file_put_contents("myjson.json", $json);
        }
    
        echo "<br>";
        if (file_exists("myjson.json")){

            $json_file = "myjson.json";
            $json_data = file_get_contents($json_file);
            $php_data = json_decode($json_data);
            
            foreach ($php_data as $data){
                echo $data -> text . " <button class='btn btn-success', name='done', value='$data->id'>Done</button>" ."<hr>";

                
            }
            
            // removing data when the done key has being clicked
            $done_id = $_POST['done'];
            if ($done_id !== null){
                $json_file = 'myjson.json';
                $json_data = file_get_contents($json_file);
                $php_data = json_decode($json_data, true);

                foreach($php_data as $data => $item){
                    if($item['id'] == $done_id){
                        unset($php_data[$data]);
                        break;
                    }
                }

            }

            $json_data = json_encode(array_values($php_data));
            file_put_contents('myjson.json', $json_data);
        }
    ?>

    </p>
    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    
</body>
</html>
