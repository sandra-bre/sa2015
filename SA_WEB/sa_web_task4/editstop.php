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
        <title>Routenator - Edit Stop</title>
    </head>
    <body>
        <div>
            <h1>Edit an Existing Stop</h1>
            
            <form method="get">
                <input type="text" name="stopname">
            </form> <!-- button wie input button value=stopid-->
            
        </div>
        
        <div id="editstop"></div>
        <div id="stops"></div>
    </body>
</html>

<script>
    $(document).ready(function()
    {
        setInterval(function()
        {
            var name = document.getElementsByName('stopname')[0].value;          
            
            $('#stops').load('controller.php?f=2&name=' + name);
        }, 1000);
             
    });
    
    function editstopname(id, stopname) {
        var name = prompt("Stopname:", stopname);
        name = name.replace(" ", "+");
        $('#editstop').load('controller.php?f=3&id=' + id + '&var=' + name + '&type=name');
    }
    
    function editstoplat(id, lat) {
        var latitude = prompt("Latitude:", lat);
        latitude = latitude.replace(",", ".");
        if(isNaN(latitude)) {
            alert("Latitude must be a number.");
        }
        else {
            $('#editstop').load('controller.php?f=3&id=' + id + '&var=' + latitude + '&type=latitude');
        }
    }
    function editstoplon(id, lon) {
        var longitude = prompt("Longitude:", lon);
        longitude = longitude.replace(",", ".");
        if(isNaN(longitude)) {
            alert("Longitude must be a number.");
        }
        else {
            $('#editstop').load('controller.php?f=3&id=' + id + '&var=' + longitude + '&type=longitude');
        }
    }
    
</script>