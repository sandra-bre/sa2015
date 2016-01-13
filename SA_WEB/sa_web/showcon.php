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
        <title>Routenator - Show Connection</title>
    </head>
    <body class="result">
        <h1>Show Connections</h1>
               
        <?php 
            $start = $_GET["startcon"];
            $dest = $_GET["destcon"];
            
            if($start == "" || $dest == "") {
                echo "<a>Please enter start and destination.</a>";
                echo '<br><br>';
                echo '<div class="links1">';
                echo '<a id="home" href="index.php">home</a>';
                echo '<a id="back" href="searchconnection.php">back</a>';
                echo '</div>';
                exit;
            }
            
            
        ?>
        
             
        <?php    
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
                echo '<br><br>';
                echo '<div class="links1">';
                echo '<a id="home" href="index.php">home</a>';
                echo '<a id="back" href="searchconnection.php">back</a>';
                echo '</div>';
                exit;
            }
            $start = $result1->name;
            $dest = $result2->name;
            
            echo "<h4>Your Search Criteria:</h4>";
            echo '<table class="criteria"><tr><td>Start</td><td>' . $start . '</td></tr>';
            echo "<tr><td>Destination</td><td>" . $dest . "</td></tr></table>";
        ?>
        

        <div class="links2">
        <a id="back" href="searchconnection.php">back</a>
        <a id="home" href="index.php">home</a>
        </div>
                  
        <?php    
            $sql = "SELECT r.name FROM (SELECT route_id, m.stop_id ";
            $sql .= "FROM task1 t2 INNER JOIN mapping m ON (t2.id = m.stop_id) ";
            $sql .= "WHERE t2.name = '" . mysqli_real_escape_string($db, $start) . "') t1 ";
            $sql .= "INNER JOIN (SELECT route_id ";
            $sql .= "FROM task1 t3 INNER JOIN mapping m ON (t3.id = m.stop_id) ";
            $sql .= "WHERE t3.name = '" . mysqli_real_escape_string($db, $dest) . "' ) t2 ON(t1.route_id = t2.route_id) ";
            $sql .= "INNER JOIN routes r ON(r.route_id = t2.route_id)";
                        
            $befehl = $db->query($sql);
            
            echo '<table class="data"><tr><th>Name</th></tr>';
            
            while ($result = $befehl->fetch_object()) {
                echo "<tr><td>" . $result->name . "</tr></td>";
            }
            echo "</table>";
            
            $db->close();
        ?>
    </body>
</html>
