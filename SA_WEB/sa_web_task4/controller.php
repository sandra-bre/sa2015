<?php
    $function = $_GET["f"];
    
    switch ($function) {
        case 1:
            $name = $_GET["name"];
            $lat = $_GET["latvalue"];
            $lattype = $_GET["lattype"];
            $lon = $_GET["lonvalue"];
            $lontype = $_GET["lontype"];
            $ex = "exact"; $ab = "above"; $be = "below";
            
            if($name == "" && $lat == "" && $lon == "") { exit; }
                      
            $lat = str_replace(",", ".", $lat);
            $lon = str_replace(",", ".", $lon);
            
            if(((!is_numeric($lat) && !is_float($lat) && is_null($lat))) 
                    || ((!is_numeric($lon) && !is_float($lon)) && is_null($lon))) {
                echo "Latitude and Longitude must be numbers.";
                exit;
            }
        
            $db = new mysqli("localhost", "root", "", "sa_database");
            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $sql = "SELECT * FROM task1 where ";
            $bool = false;
            
            if($name != "") {
                
                $sql .= "name LIKE '%" . mysqli_real_escape_string($db, $name) . "%'";
                $bool = true;
            }
            if($lat != ""){                
                if($bool == true) { $sql .= " AND "; }
                $sql .= "latitude ";
                if (strcmp($lattype, $ex) == 0) { $sql .= "= '"; }
                else if (strcmp($lattype, $be)) { $sql .= "> '"; }
                else if (strcmp($lattype, $ab)) { $sql .= "< '"; }
                $sql .= mysqli_real_escape_string($db, $lat) . "'";
                $bool = true;
            }
            if($lon != ""){
                if($bool == true) { $sql .= " AND "; }
                $sql .= "longitude ";
                if (strcmp($lontype, $ex) == 0) { $sql .= "= '"; }
                else if (strcmp($lontype, $be)) { $sql .= "> '"; }
                else if (strcmp($lontype, $ab)) { $sql .= "< '"; }
                $sql .= mysqli_real_escape_string($db, $lon) . "'";
                $bool = true;
            }
        
            $befehl = $db->query($sql);
            
            echo '<table class="data">';
            echo '<tr><th>Name</th>';
            echo '<th>Latitude</th>';
            echo '<th>Longitude</th></tr>';
            
            $superstring = "";
            
            if($resultat = $befehl->fetch_object()) {
                echo '<tr><td>' . $resultat->name . '</td>';
                echo '<td>' . $resultat->latitude . '</td>';
                echo '<td>' . $resultat->longitude . '</td></tr>';
                
                $superstring .= '<script type="text/javascript"> 
                var map;
                function initMap() {
                
                map = new google.maps.Map(document.getElementById("map"), {
                    center: {lat: ' . $resultat->latitude . ', lng: ' . $resultat->longitude . '},
                    zoom: 13
                });

                new google.maps.Marker({
                    position: {lat: ' . $resultat->latitude . ', lng: ' . $resultat->longitude . '},
                    map: map,
                    title: "' . $resultat->name . 
                '"});';
                
            }
            
            
            
            while($resultat = $befehl->fetch_object()) { 
                echo '<tr><td>' . $resultat->name . '</td>';
                echo '<td>' . $resultat->latitude . '</td>';
                echo '<td>' . $resultat->longitude . '</td></tr>';
                $superstring .= 'new google.maps.Marker({
                    position: {lat: ' . $resultat->latitude . ', lng: ' . $resultat->longitude . '},
                    map: map,
                    title: "' . $resultat->name . 
                '"});';
            }
            $superstring .= '}
                </script>
                <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKdI4C7gQzK9jZi9Po9BZaBKwSe1FTcZE&callback=initMap">
                </script>';
            echo $superstring;
            break;
            
        case 2:
            $name = $_GET["name"];
            
            $db = new mysqli("localhost", "root", "", "sa_database");
            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }
            $sql = "SELECT * FROM task1 where name LIKE '%" . mysqli_real_escape_string($db, $name) . "%'";

            echo '<table class="clickabletable">';
            echo '<tr><th></th><th>Name</th>';
            echo '<th>Latitude</th>';
            echo '<th>Longitude</th></tr>';
            
            $befehl = $db->query($sql);
            while($resultat = $befehl->fetch_object()) {
                echo "<td><button onclick=\"editstop('" . $resultat->id . "', '" . $resultat->name . "', '" . $resultat->latitude
                        . "', '" . $resultat->longitude . "')\">edit</button></td>";
                echo '<td>' . $resultat->name . '</td>';
                echo '<td>' . $resultat->latitude . '</td>';
                echo '<td>' . $resultat->longitude . '</td></tr>';
            }
            echo '</table>';
            break;
            
        case 3:
            $id = $_GET['id'];
            $stop = $_GET['name'];
            $lat = $_GET['lat'];
            $lon = $_GET['lon'];
            $ok = 1;
            
            while($ok) {
                echo '<form method="GET">';
                echo '<a>Stopname:</a>';
                echo '<input type="text" id="name" value="' . $stop . '"><br>';
                echo '<a>Latitude:</a>';
                echo '<input type="text" id="name" value="' . $lat . '"><br>';
                echo '<a>Longitude:</a>';
                echo '<input type="text" id="name" value="' . $lon . '"><br>';
                echo '</form>';
                break;
               
            }
              
            break;
    }
