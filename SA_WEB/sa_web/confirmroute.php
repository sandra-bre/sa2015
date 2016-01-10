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
        <title>Routenator - Confirm Route</title>
    </head>
    <body>
        <div class="main_window">
        <h1>Confirm New Route</h1>
        
        <?php 
            $name = $_GET["rname"];
            $start = $_GET["rstart"];
            $dest = $_GET["rdest"];
            $tmp = $_GET["rstops"];
            $stops = array();
            $stops = explode(";", $tmp);
            $sstops = array();
            
            if($name == "" || $start == "" || $dest == "") {
                echo "<a>Please enter a route name, start and destination.</a>";
                echo '<div class="links3">';
                echo '<a id="home" href="index.php">home</a>';
                echo '<a id="back" href="addroute.php">back</a>';
                echo '</div>';
                exit;
            }
            
            $db = new mysqli("localhost", "root", "", "sa_database");
            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $sql = "SELECT DISTINCT name FROM task1 WHERE name LIKE '%" . mysqli_real_escape_string($db, $start) . "%'";
            $befehl1 = $db->query($sql);
            
            $sql = "SELECT DISTINCT name FROM task1 WHERE name LIKE '%" . mysqli_real_escape_string($db, $dest) . "%'";
            $befehl2 = $db->query($sql);
            
            if(!($result1 = $befehl1->fetch_object()) || !($result2 = $befehl2->fetch_object())) {
                echo "<a>Unknown start and/or destination.</a>";
                echo '<div class="links3">';
                echo '<a id="home" href="index.php">home</a>';
                echo '<a id="back" href="addroute.php">back</a>';
                echo '</div>';
                exit;
            }
            $start = $result1->name;
            $dest = $result2->name;
            
            $i = 0;
            $j = 0;
            while($i < count($stops) && !$stops) {
                $sql = "SELECT DISTINCT name FROM task1 WHERE name LIKE '%" . mysqli_real_escape_string($db, trim($stops[$i])) . "%'";
                $befehl = $db->query($sql);
                $result = $befehl->fetch_object();
                if($result) {
                    $sstops[$j] = $result->name; $j++;
                }
                $i++;
            }
                       
            $db->close();
        ?>
        
        <form id="addroute" method="get" action="routeOK.php">
            <a>Route Name:</a><br>
            <?php echo "<a>" . $name . "</a>";
            echo '<input type="hidden" name="name" value="' . $name . '">'?>
            <br><br>
            
            <a>Start:</a><br>
            <?php echo "<a>" . $start . "</a>";
            echo '<input type="hidden" name="start" value="' . $start . '">'?>
            <br><br>
            
            <a>Destination:</a><br>
            <?php echo "<a>" . $dest . "</a>";
            echo '<input type="hidden" name="dest" value="' . $dest . '">'?>
            <br><br>
            
            <a>Stops:</a><br>
            <?php
                for($i = 0; $i < count($sstops); $i++){
                    echo "<a>" . $sstops[$i] . "</a><br>";
                }
                $tmp=urlencode(base64_encode(serialize($sstops)));
                echo '<input name="stops" type="hidden" value="' . $tmp . '">';
            ?>
            <br><br>
            
            <input type="submit" value="Add New Route">
        </form>
        
        <div class="links3">
        <a id="home" href="index.php">home</a>
        <a id="back" href="addroute.php">back</a>
        </div>
        </div>
    </body>
</html>
