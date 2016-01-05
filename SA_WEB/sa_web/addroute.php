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
        <title>Routenator - Add Route</title>
    </head>
    <body>
        <div class="main_window">
        <h1>Add New Route</h1>
        
        <form id="addroute" method="get" action="confirmroute.php">
            <a>Route Name:</a><br>
            <input type="text" name="rname">
            <br><br>
            
            <a>Start:</a><br>
            <input type="text" name="rstart">
            <br><br>
            
            <a>Destination:</a><br>
            <input type="text" name="rdest">
            <br><br>
            
            <a>Stops:</a><br>
            <input type="text" name="rstops">
            <br>
            Seperate Stops with Semikolon.
            <br><br>
            
            <input type="submit" value="Add New Route">
        </form>
        
        
        <a id="home" href="index.php">home</a>
        </div>
    </body>
</html>
