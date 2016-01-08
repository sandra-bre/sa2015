<?php
    $function = $_GET["f"];
    
    switch ($function) {
        case 0:
            echo "testing...";
            break;
        
        case 1: //searchstop - search stops and display map
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
            
        case 2: //editstop - search stops
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
                echo "<td><button onclick=\"editstopname('" . $resultat->id . "', '" . $resultat->name . "')\">edit name</button>";
                echo "<button onclick=\"editstoplat('" . $resultat->id . "', '" . $resultat->latitude . "')\">edit latitude</button>";
                echo "<button onclick=\"editstoplon('" . $resultat->id . "', '" . $resultat->longitude . "')\">edit longitude</button></td>";
                echo '<td>' . $resultat->name . '</td>';
                echo '<td>' . $resultat->latitude . '</td>';
                echo '<td>' . $resultat->longitude . '</td></tr>';
            }
            echo '</table>';
            break;
            
        case 3: //editstop - update database
            $id = $_GET['id'];
            $var = $_GET['var'];
            $type = $_GET['type'];
            
            $db = new mysqli("localhost", "root", "", "sa_database");
            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $sql = "UPDATE task1 SET " . mysqli_real_escape_string($db, $type) . "='" . mysqli_real_escape_string($db, $var); 
            $sql .= "' WHERE id='" . mysqli_real_escape_string($db, $id) . "'";
                        
            $befehl = $db->query($sql);
            $db->close();
            break;
        
        case 4: //editstop - dropdown
            $name = $_GET['name'];
            
            $db = new mysqli("localhost", "root", "", "sa_database");
            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $sql = "SELECT distinct name FROM task1 where upper(name) LIKE '" . mysqli_real_escape_string($db, $name) . "%' order by name ASC LIMIT 0, 5";
            $befehl = $db->query($sql);
            while($resultat = $befehl->fetch_object()) { 
                echo '<li onclick="set_item(\''.str_replace("'", "\'", $resultat->name).'\')">'.$resultat->name.'</li>';
            }
            break;
            
        case 5: //search restaurant - search restaurants
            $stop = $_GET["stopname"];
            $distance = $_GET["distance"];
            
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
                echo '<a id="back" href="searchrestaurant.php">back</a>';
                echo '</div>';

                exit;
            }
                
            $stop = $result->name;
            $lat = $result->latitude;
            $lon = $result->longitude;
            
            $superrest = '<script type="text/javascript"> 
                var map;
                function initMap() {
                    map = new google.maps.Map(document.getElementById("map"), {
                    center: {lat: ' . $result->latitude . ', lng: ' . $result->longitude . '},
                    zoom: 17
                });';
            
            $sql = "SELECT * FROM task2 WHERE ";
            $sql .= "longitude < " . ($lon + $distance/(111111 * cos($lat * (180/M_PI)))) . " AND ";
            $sql .= "longitude > " . ($lon - $distance/(111111 * cos($lat * (180/M_PI)))) . " AND ";
            $sql .= "latitude < " . ($lat + $distance/111111) . " AND ";
            $sql .= "latitude > " . ($lat - $distance/111111) . " ORDER BY name";
            
            $befehl = $db->query($sql);

            echo '<table class="data">';
            echo "<tr><th>Name</th><th>Type</th></tr>";            
            
            while($result = $befehl->fetch_object()) {
                echo "<tr><td>" . $result->name . "</td>";
                echo "<td>" . $result->amenity . "</td></tr>";
                
                $superrest .= 'new google.maps.Marker({
                position: {lat: ' . $result->latitude . ', lng: ' . $result->longitude . '},
                map: map,
                title: "' . $result->name . 
                '"});';
            } 
            echo "</table>";
            
            $superrest .= '}
                </script>
                <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKdI4C7gQzK9jZi9Po9BZaBKwSe1FTcZE&callback=initMap">
                </script>';
            echo $superrest;
                
            $db->close();
            
            break;
            
        case 6: //editroute - search route
            $name = $_GET['name'];
            $start = $_GET['start'];
            $dest = $_GET['dest'];
            
            $db = new mysqli("localhost", "root", "", "sa_database");
            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            if($start != "") {
                $sql = "SELECT DISTINCT name FROM task1 WHERE name LIKE '%" . mysqli_real_escape_string($db, $start) . "%'";
                $befehl = $db->query($sql);
                
                if($result = $befehl->fetch_object()) {
                    $start = $result->name;
                }
            }
            if($dest != "") {
                $sql = "SELECT DISTINCT name FROM task1 WHERE name LIKE '%" . mysqli_real_escape_string($db, $dest) . "%'";
                $befehl = $db->query($sql);
                
                if($result = $befehl->fetch_object()) {
                    $dest = $result->name;
                }
            }
            
            if($start == "" && $dest == "") {
                $sql = "SELECT name, route_id FROM routes";
            }
            else if ($start != "" && $dest != "") {
                $sql = "SELECT r.name, r.route_id FROM ((SELECT route_id, m.stop_id FROM task1 t2 INNER JOIN mapping m ON (t2.id = m.stop_id) ";
                $sql .= "WHERE t2.name = '" . $start . "') t1 INNER JOIN (SELECT route_id FROM task1 t3 INNER JOIN mapping m ON ";
                $sql .= "(t3.id = m.stop_id) WHERE t3.name = '" . $dest . "' ) t2 ON(t1.route_id = t2.route_id) ";
                $sql .= "INNER JOIN routes r ON(r.route_id = t2.route_id))";
            }
            else {
                $sql = "SELECT r.name, r.route_id FROM (SELECT route_id, m.stop_id FROM task1 t2 INNER JOIN mapping m ON (t2.id = m.stop_id) ";
                $sql .= "WHERE t2.name = '";
                if ($start == "") { $sql .= $dest; }
                else { $sql .= $start; }
                $sql .= "') t1 INNER JOIN routes r ON (r.route_id = t1.route_id)";
            }
            if($name != "") {
                 $sql .= " WHERE name LIKE '%" . $name . "%'";
            }
                    
            $befehl = $db->query($sql);
            
            echo '<table class="data"><tr><th>Edit</th><th>Name</th></tr>';
            
            while ($resultat = $befehl->fetch_object()) {
                echo "<tr><td><button onclick=\"editroutename('" . $resultat->route_id . "', '" . $resultat->name . "')\">Name</button>";
                echo "<button onclick=\"editroutestart('" . $resultat->route_id . "', '" . $resultat->name . "')\">Start</button>";
                echo "<button onclick=\"editroutedest('" . $resultat->route_id . "', '" . $resultat->name . "')\">Destination</button>";
                echo "<button onclick=\"editroutestops('" . $resultat->route_id . "', '" . $resultat->name . "')\">Stops</button></td>";
                echo "<td>" . $resultat->name . "</td></tr>";
            }
            echo "</table>";
            
            $db->close();
            
            break;
            
        case 7: //editroute - update database
            $type = $_GET['type'];
            $id = $_GET['id'];
            
            $db = new mysqli("localhost", "root", "", "sa_database");
            if (mysqli_connect_errno()) {
                printf("Connection failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            switch ($type) {
                case 0: //name
                    $name = $_GET['name'];
                    
                    $sql = "UPDATE routes SET name='" . mysqli_real_escape_string($db, $name); 
                    $sql .= "' WHERE route_id='" . mysqli_real_escape_string($db, $id) . "'";
                    
                    $befehl = $db->query($sql);
                    $db->close();
                    
                    break;
                
                case 1: //start
                    $oldstart = $_GET['old'];
                    $newstart = $_GET['new'];
                    $routename = $_GET['name'];
                    
                    $sql = "SELECT DISTINCT id FROM task1 WHERE name = '" . mysqli_real_escape_string($db, $oldstart) . "'";
                    $befehlold = $db->query($sql);
                    
                    $sql = "SELECT DISTINCT id, name FROM task1 WHERE name LIKE '%" . mysqli_real_escape_string($db, $newstart) . "%'";
                    $befehlnew = $db->query($sql);
                    if(($resultold = $befehlold->fetch_object()) && ($resultnew = $befehlnew->fetch_object())) {
                        $oldid = $resultold->id;
                        $newid = $resultnew->id;
                        $newname = $resultnew->name;
                    }
                    else {
                        break;
                    }
                    $sql = "UPDATE mapping SET stop_id='" . $newid . "' WHERE route_id='" . $id . "' AND stop_id='" . $oldid . "'";
                    if($db->query($sql) === true) { echo "stop successful"; }
                    $tmp = explode(": ", $routename);
                    $name = $tmp[0] . ": ";
                    $name .= $newname . " => ";
                    $tmp1 = explode(" => ", $tmp[1]);
                    $name .= $tmp1[1];
                    
                    $sql = "UPDATE routes SET name='" . mysqli_real_escape_string($db, $name); 
                    $sql .= "' WHERE route_id='" . mysqli_real_escape_string($db, $id) . "'";
                    if($db->query($sql) === true) { echo "name successful"; }
                    break;
                
                case 2: //dest
                    $olddest = $_GET['old'];
                    $newdest = $_GET['new'];
                    $routename = $_GET['name'];
                    
                    $sql = "SELECT DISTINCT id FROM task1 WHERE name = '" . mysqli_real_escape_string($db, $olddest) . "'";
                    $befehlold = $db->query($sql);
                    
                    $sql = "SELECT DISTINCT id, name FROM task1 WHERE name LIKE '%" . mysqli_real_escape_string($db, $newdest) . "%'";
                    $befehlnew = $db->query($sql);
                    if(($resultold = $befehlold->fetch_object()) && ($resultnew = $befehlnew->fetch_object())) {
                        $oldid = $resultold->id;
                        $newid = $resultnew->id;
                        $newname = $resultnew->name;
                    }
                    else {
                        break;
                    }
                    $sql = "UPDATE mapping SET stop_id='" . $newid . "' WHERE route_id='" . $id . "' AND stop_id='" . $oldid . "'";
                    if($db->query($sql) === true) { echo "stop successful"; }
                    $tmp = explode("=> ", $routename);
                    $name = $tmp[0] . "=> ";
                    $name .= $newname;
                    
                    $sql = "UPDATE routes SET name='" . mysqli_real_escape_string($db, $name); 
                    $sql .= "' WHERE route_id='" . mysqli_real_escape_string($db, $id) . "'";
                    if($db->query($sql) === true) { echo "name successful"; }
                    break;
            }
                
                
            break;
    }

?>



