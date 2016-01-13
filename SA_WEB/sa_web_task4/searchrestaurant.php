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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <title>Routenator - Search Restaurant</title>
    </head>
    <body class="result_map">
        <div class="top_bar">
            <h1>Search Restaurant</h1>
            
            <a id="home" href="index.php">home</a>
        </div>

            <form id="searchRestaurant" method="post" autocomplete="off">
            <div class="search_bar">
                <div class="search_name">
                <a>Stopname:</a><br>
                <div class="input_container">
                <input type="text" id="stopname" >
                <ul id="stopnameList"></ul>
                <br>
                </div>
                </div>

                <div class="search_name">
                <a>Distance: (in meter)</a><br/>
                <input type="text" name="distance">
                </div>
                
                <input type="button" value="Search Restaurant" onclick="getdata()">
            </div>
            </form>
        
        <div id="results"></div>
        <div id="map"></div>
    </body>
    
    <script type="text/javascript">
        document.getElementById('stopname').addEventListener("keydown", holeDaten);

        function holeDaten(){
            var name = document.getElementById('stopname').value;
            name = name.split(" ").join("+");
            if(name != ""){
                $('#stopnameList').load('controller.php?f=4&name=' + name);
            }
        }

        function set_item(item) {
            $('#stopname').val(item);
        }

        function getdata() {
            var name = document.getElementById('stopname').value;
            var distance = document.getElementsByName('distance')[0].value;
            name = name.split(" ").join("+");
            distance = distance.replace(",", ".");
            if(name == "" || distance == "") {
                alert("Please enter name and distance.")
            }        
            else if(isNaN(distance)) {
                alert("Distance must be a number.");
            }
            else {
                $('#results').load('controller.php?f=5&stopname=' + name + '&distance=' + distance);
            }
        }
    </script>
    
</html>

