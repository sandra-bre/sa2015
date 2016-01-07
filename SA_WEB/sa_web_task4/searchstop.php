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
    <body>
        <div class="main_window">
        <h1>Search Stop</h1>
        
        
        <form id="searchstop" method="post">
            <a>Name:</a><br>
            <input type="text" name="stopname">
            <br><br>
            
            <a>Latitude:</a><br>
            <input type="text" name="latvalue"><br>
            <input type="radio" name="lattype" value="exact" checked="checked"><label for="latexact">exact</label>
            <input type="radio" name="lattype" value="above"><label for="latabove">above</label>
            <input type="radio" name="lattype" value="below"><label for="latbelow">below</label>
            <br><br>
            
            <a>Longidute:</a><br>
            <input type="text" name="lonvalue"><br>
            <input type="radio" name="lontype" value="exact" checked="checked"><label for="lonexact">exact</label>
            <input type="radio" name="lontype" value="above"><label for="lonabove">above</label>
            <input type="radio" name="lontype" value="below"><label for="lonbelow">below</label> 
            <br><br>
        </form>
        
        <a id="home" href="index.php">home</a>
        </div>
        
        <div id="resultstops"></div>
    </body>
</html>

<script>
    $(document).ready(function()
    {
        setInterval(function()
        {
            var name = document.getElementsByName('stopname')[0].value;
            var lat = document.getElementsByName('latvalue')[0].value;
            var lattype;
            if(document.getElementsByName('lattype')[0].checked == true) {
                lattype = document.getElementsByName('lattype')[0].value;
            }
            else if (document.getElementsByName('lattype')[1].checked == true) {
                lattype = document.getElementsByName('lattype')[1].value;
            }
            else if (document.getElementsByName('lattype')[2].checked == true) {
                lattype = document.getElementsByName('lattype')[2].value;
            }
            
            var lon = document.getElementsByName('lonvalue')[0].value;
            var lontype;
            if(document.getElementsByName('lontype')[0].checked == true) {
                lontype = document.getElementsByName('lontype')[0].value;
            }
            else if (document.getElementsByName('lontype')[1].checked == true) {
                lontype = document.getElementsByName('lontype')[1].value;
            }
            else if (document.getElementsByName('lontype')[2].checked == true) {
                lontype = document.getElementsByName('lontype')[2].value;
            }
            
            
            var url = 'controller.php?function=1';
            
                url += '&stopname=' + name;
            
            
            $('#resultstops').load('controller.php?name=' + name + '&latvalue=' + lat + '&lattype=' + lattype
                    + '&lonvalue=' + lon + '&lontype=' + lontype);
        }, 1000);
    });
</script>
