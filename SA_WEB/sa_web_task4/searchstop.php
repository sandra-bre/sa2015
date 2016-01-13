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
        <title>Routenator - Search Stop</title>
    </head>
    <body class="result_map">
        <div class="top_bar">
            <h1>Search Stop</h1>

            <a id="home" href="index.php">home</a>
        </div>

        <form id="searchstop" method="post">
            <div class="search_bar">
                <div class="search_name">
                    <a>Name:</a><br>
                    <input type="text" id="stopname">
                </div>

                <div class="search_point">
                    <a>Latitude:</a><br>
                    <input type="text" id="latvalue"><br>
                    <input type="radio" name="lattype" value="exact" checked="checked"><label for="latexact">exact</label>
                    <input type="radio" name="lattype" value="above"><label for="latabove">above</label>
                    <input type="radio" name="lattype" value="below"><label for="latbelow">below</label>
                </div>

                <div class="search_point">
                    <a>Longitude:</a><br>
                    <input type="text" id="lonvalue"><br>
                    <input type="radio" name="lontype" value="exact" checked="checked"><label for="lonexact">exact</label>
                    <input type="radio" name="lontype" value="above"><label for="lonabove">above</label>
                    <input type="radio" name="lontype" value="below"><label for="lonbelow">below</label> 
                </div>
            </div>
        </form>

        <div id="resultstops"></div>
        <div id="map"></div>
    </body>
</html>

<script>
 
        document.getElementById('stopname').addEventListener("keydown", getstops);
        document.getElementById('latvalue').addEventListener("keydown", getstops);
        document.getElementById('lonvalue').addEventListener("keydown", getstops);
        document.getElementsByName('lattype')[0].addEventListener("click", getstops);
        document.getElementsByName('lattype')[1].addEventListener("click", getstops);
        document.getElementsByName('lattype')[2].addEventListener("click", getstops);
        document.getElementsByName('lontype')[0].addEventListener("click", getstops);
        document.getElementsByName('lontype')[1].addEventListener("click", getstops);
        document.getElementsByName('lontype')[2].addEventListener("click", getstops);
        
    function getstops()  {
            var name = document.getElementById('stopname').value;
            name = name.split(" ").join("+");
            var lat = document.getElementById('latvalue').value;
            var lattype;
            if (document.getElementsByName('lattype')[0].checked == true) {
                lattype = document.getElementsByName('lattype')[0].value;
            } else if (document.getElementsByName('lattype')[1].checked == true) {
                lattype = document.getElementsByName('lattype')[1].value;
            } else if (document.getElementsByName('lattype')[2].checked == true) {
                lattype = document.getElementsByName('lattype')[2].value;
            }

            var lon = document.getElementById('lonvalue').value;
            var lontype;
            if (document.getElementsByName('lontype')[0].checked == true) {
                lontype = document.getElementsByName('lontype')[0].value;
            } else if (document.getElementsByName('lontype')[1].checked == true) {
                lontype = document.getElementsByName('lontype')[1].value;
            } else if (document.getElementsByName('lontype')[2].checked == true) {
                lontype = document.getElementsByName('lontype')[2].value;
            }


            $('#resultstops').load('controller.php?f=1&name=' + name + '&latvalue=' + lat + '&lattype=' + lattype
                    + '&lonvalue=' + lon + '&lontype=' + lontype);
        };
</script>
