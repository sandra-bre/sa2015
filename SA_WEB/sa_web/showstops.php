<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="routenator.css">
        <title>Routenator - Show Stops</title>
    </head>
    <body>
        <h1>Show Stops</h1>
        
        <?php
            $name = $_GET["stopname"];
            $lat = $_GET["latvalue"];
            $lattype = $_GET["lattype"];
            $lon = $_GET["lonvalue"];
            $lontype = $_GET["lontype"];
            $ex = "exact"; $ab = "above"; $be = "below";
            
            if($name == "" && $lat == "" && $lon == "") {
                echo "Please enter at least one search criteria.";
                echo '<br><br>';
                
                echo '<a href="index.php">home</a><br>';
                echo '<a href="searchstop.php">back</a><br>';
                
                exit;
            }
                      
            str_replace(",", ".", $lat);
            str_replace(",", ".", $lon);
            
            if(((!is_numeric($lat) && !is_float($lat) && is_null($lat))) 
                    || ((!is_numeric($lon) && !is_float($lon)) && is_null($lon))) {
                echo "Latitude and Longitude must be numbers.";
                echo '<br><br>';
                
                echo '<a href="index.php">home</a><br>';
                echo '<a href="searchstop.php">back</a><br>';
                
                exit;
            }
        ?>
        
        <h4>Your Search Criteria:</h4>
        <?php 
            $sql = "SELECT * FROM task1 where ";
            $bool = false;
            
            echo '<table style="width:50%">';
            if($name != "") {
                echo '<tr>';
                echo '<td>Name:</td>';
                echo '<td>'; echo $name; echo '</td>';
                echo '</tr>';
                
                $sql .= "name LIKE '%" . $name . "%'";
                $bool = true;
            }
            if($lat != ""){
                echo '<tr>';
                echo '<td>Latitude:</td>';
                echo '<td>'; echo $lat; echo '</td>';
                echo '<td>Type:</td>';
                echo '<td>'; echo $lattype; echo '</td>';
                echo '</tr>';
                
                if($bool == true) { $sql .= " AND "; }
                $sql .= "latitude ";
                if (strcmp($lattype, $ex) == 0) { $sql .= "= '"; }
                else if (strcmp($lattype, $be)) { $sql .= "< '"; }
                else if (strcmp($lattype, $ab)) { $sql .= "> '"; }
                $sql .= $lat . "'";
                $bool = true;
            }
            if($lon != ""){
                echo '<tr>';
                echo '<td>Longitude:</td>';
                echo '<td>'; echo $lon; echo '</td>';
                echo '<td>Type:</td>';
                echo '<td>'; echo $lontype; echo '</td>';
                echo '</tr>';
                
                if($bool == true) { $sql .= " AND "; }
                $sql .= "longitude ";
                if (strcmp($lontype, $ex) == 0) { $sql .= "= '"; }
                else if (strcmp($lontype, $be)) { $sql .= "< '"; }
                else if (strcmp($lontype, $ab)) { $sql .= "> '"; }
                $sql .= $lon . "'";
                $bool = true;
            }
            echo '</table>';
            
        ?>
        
        <?php
            $db = new mysqli("localhost", "root", "root", "sa_database");
            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
              }

            $befehl = $db->query($sql);
            
            echo '<table>';
            echo '<tr><th>Name</th>';
            echo '<th>Longitude</th>';
            echo '<th>Latitude</th></tr>';
            
            while($resultat = $befehl->fetch_object()) { 
                echo '<tr><td>'; echo $resultat->name; echo '</td>';
                echo '<td>'; echo $resultat->longitude; echo '</td>';
                echo '<td>'; echo $resultat->latitude; echo '</td></tr>';
            }

            $db->close();
        
        ?>
        
    </body>
</html>
