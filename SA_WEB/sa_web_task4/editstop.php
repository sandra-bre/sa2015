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
                <input type="text" name="stopname" id="123">
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
    
    function editstop(id) {
        $('#editstop').load('controller.php?f=3&id=' + id + '&name=' + stopname + '&lat=' + stoplat + '&lon=' + stoplon);
    }
</script>