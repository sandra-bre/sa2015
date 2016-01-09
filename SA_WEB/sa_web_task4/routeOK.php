<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="routenator.css">
        <title>Adding Route</title>
    </head>
    <body>
        <div class="main_window">
        <?php
            $stops = unserialize(base64_decode(urldecode($_GET['stops'])));
            $name = $_GET["name"];
            $start = $_GET["start"];
            $dest = $_GET["dest"];
            
            $db = new mysqli("localhost", "root", "", "sa_database");
            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $sql = "SELECT MAX(route_id) as id FROM routes";
            $befehl = $db->query($sql);
            $result = $befehl->fetch_object();
            $id = $result->id; $id++;
            
            $sql = "INSERT INTO routes (route_id, name) VALUES ('" . mysqli_real_escape_string($db, $id) . "', '";
            $sql .= mysqli_real_escape_string($db, $name) . ": " . mysqli_real_escape_string($db, $start) . " => ";
            $sql .= mysqli_real_escape_string($db, $dest) . "')";
            if($db->query($sql) === true) {
                echo "<a>Creating route successfully.</a><br>";
            }
            
            $sql =  "SELECT id FROM task1 where name='" . mysqli_real_escape_string($db, $start) . "'";
            $befehl = $db->query($sql);
            $result = $befehl->fetch_object();
            $tmp = $result->id;
            $sql = "INSERT INTO mapping (route_id, stop_id) VALUES (". mysqli_real_escape_string($db, $id) .",";
            $sql .= mysqli_real_escape_string($db, $tmp) . ")";
            if($db->query($sql) === true) {
                echo "<a>Adding " . $start . " successfully.</a><br>";
            }
            
            $sql =  "SELECT id FROM task1 where name='" . mysqli_real_escape_string($db, $dest) . "'";
            $befehl = $db->query($sql);
            $result = $befehl->fetch_object();
            $tmp = $result->id;
            $sql = "INSERT INTO mapping (route_id, stop_id) VALUES (". mysqli_real_escape_string($db, $id) . ",";
            $sql .= mysqli_real_escape_string($db, $tmp) . ")";
            if($db->query($sql) === true) {
                echo "<a>Adding " . $dest . " successfully.</a><br>";
            }
            
            for($i = 0; $i < count($stops) && $stops; $i++) {
                $sql =  "SELECT id FROM task1 where name='" . mysqli_real_escape_string($db, $stops[$i]) . "'";
                $befehl = $db->query($sql);
                $result = $befehl->fetch_object();
                $tmp = $result->id;
                $sql = "INSERT INTO mapping (route_id, stop_id) VALUES (" . mysqli_real_escape_string($db, $id);
                $sql .= "," . mysqli_real_escape_string($db, $tmp) . ")";
                if($db->query($sql) === true) {
                    echo "<a>Adding " . $stops[$i] . " successfully.</a><br>";
                }
            }
        ?>
        <br>
        <a id="home" href="index.php">home</a>
        </div>
    </body>
</html>
