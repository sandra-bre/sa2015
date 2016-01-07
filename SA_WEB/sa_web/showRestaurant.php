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
        <title>Routenator - Show Restaurant</title>
    </head>
    <body class="result">
        
        <h1>Show Restaurant</h1>
            
        <?php
            $stop = $_GET["stopname"];
            $distance = $_GET["distance"];
                
                
            if($stop == "" || $distance == "") {
                echo "Please enter a stop and a distance.";
                
                echo '<div class="links1">';
                echo '<a id="home" href="index.php">home</a>';
                echo '<a id="back" href="searchRestaurant.php">back</a>';
                echo '</div>';
                exit;
            }
            else if(!is_numeric($distance)) {
                echo "Distance must be a number.";
              
                echo '<div class="links1">';
                echo '<a id="home" href="index.php">home</a>';
                echo '<a id="back" href="searchRestaurant.php">back</a>';
                echo '</div>';

                exit;
            }
                
            $db = new mysqli("localhost", "root", "", "sa_database");
            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $sql = "SELECT DISTINCT * FROM task1 WHERE name LIKE '%" . mysqli_real_escape_string($db, $stop) . "%'";
            $befehl = $db->query($sql);
                
            if(!($result = $befehl->fetch_object())) {
                echo "Unknown stopname.";
                
                echo '<div class="links1">';
                echo '<a id="home" href="index.php">home</a>';
                echo '<a id="back" href="searchRestaurant.php">back</a>';
                echo '</div>';

                exit;
            }
                
            $stop = $result->name;
            $lat = $result->latitude;
            $lon = $result->longitude;
                
            echo '<table class="criteria">';
            echo '<tr><td>Stopname</td><td>' . $stop . '</td><tr>';
            echo '<tr><td>Distance</td><td>' . $distance . ' m</td><tr>';
            echo '</table>';
                
            echo '<div class="links2">';
            echo '<a id="home" href="index.php">home</a>';
            echo '<a id="back" href="searchRestaurant.php">back</a>';
            echo '</div>';
            
            $sql = "SELECT * FROM task2 WHERE ";
            $sql .= "longitude < " . ($lon + $distance/(111111 * cos($lat * (180/M_PI)))) . " AND ";
            $sql .= "longitude > " . ($lon - $distance/(111111 * cos($lat * (180/M_PI)))) . " AND ";
            $sql .= "latitude < " . ($lat + $distance/111111) . " AND ";
            $sql .= "latitude > " . ($lat - $distance/111111);
            
            $befehl = $db->query($sql);
            
            echo '<table class="data">';
            echo "<tr><th>Name</th><th>Type</th></tr>";
            
            while($result = $befehl->fetch_object()) {
                echo "<tr><td>" . $result->name . "</td>";
                echo "<td>" . $result->amenity . "</td></tr>";
            } 
            echo "</table>";
                
            $db->close();
        ?>
            
            
        
    </body>
</html>
