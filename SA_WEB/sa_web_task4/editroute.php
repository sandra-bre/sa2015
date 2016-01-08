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
        <title>Routenator - Edit Route</title>
    </head>
    <body>
        <div>
            <h1>Edit an Existing Route</h1>
            
            <form method="get">
                <a>Routename:</a>
                <input type="text" id="routename">
                <br>
                <a>Start:</a>
                <input type="text" id="start">
                <br>
                <a>Destination:</a>
                <input type="text" id="dest">
            </form>
            
            
        </div>
        
        <div id="editroute"></div>
        <div id="route"></div>
    </body>
</html>

<script type="text/javascript">
   $(document).ready(function()
    {
        setInterval(function()
        {
            var name = document.getElementById('routename').value;
            var start = document.getElementById('start').value;
            var dest = document.getElementById('dest').value;
            
            if(name != "" || start != "" || dest != "") {
                $('#route').load('controller.php?f=6&name=' + name + '&start=' + start + '&dest=' + dest);
            }
        }, 1000);
             
    });
    
    function editroutename(id, name) {
        var route = name.split(":");
        var tmp = prompt("Routename:", route[0]);
        
        tmp += ":";
        
        for(var i = 1; route[i]; i++) { tmp += route[i]; }
        alert(tmp);
        
        name = name.replace(" ", "+");
        $('#editstop').load('controller.php?f=3&id=' + id + '&var=' + name + '&type=name')
    };
    
    function editroutestart(id) {
        alert("start " + id);
    }
    
    function editroutedest(id) {
        alert("dest " + id);
    }
    
    function editroutestops(id) {
        alert("id " + id);
    }
    
    
</script>

