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
        <title>Routenator - Search Stop</title>
    </head>
    <body>
        <div class="main_window">
        <h1>Search Stop</h1>
        
        
        <form id="searchstop" method="get" action="showstops.php">
            <a>Name:</a><br>
            <input type="text" name="stopname">
            <br><br>
            
            <a>Latitude:</a><br>
            <input type="text" name="latvalue"><br>
            <input type="radio" name="lattype" value="exact" checked="checked"><label for="latexact">exact</label>
            <input type="radio" name="lattype" value="above"><label for="latabove">above</label>
            <input type="radio" name="lattype" value="below"><label for="latbelow">below</label>
            <br><br>
            
            <a>Longitude:</a><br>
            <input type="text" name="lonvalue"><br>
            <input type="radio" name="lontype" value="exact" checked="checked"><label for="lonexact">exact</label>
            <input type="radio" name="lontype" value="above"><label for="lonabove">above</label>
            <input type="radio" name="lontype" value="below"><label for="lonbelow">below</label> 
            <br><br>
            
            <input type="submit" value="Search"><br>
        </form>
        
        <a id="home" href="index.php">home</a>
        </div>
    </body>
</html>


