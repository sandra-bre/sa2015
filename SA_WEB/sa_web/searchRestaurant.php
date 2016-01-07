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
        <title>Routenator - Search Restaurant</title>
    </head>
    <body>
        <div class="main_window">
            <h1>Search Restaurant</h1>

            <form id="searchRestaurant" method="get" action="showRestaurant.php">
                <a>Stopname:</a><br>
                <input type="text" name="stopname">
                <br>

                <a>Distance: (in meter)</a>
                <input type="text" name="distance">
                <br>

                <input type="submit" value="Search Restaurant">
            </form>
            
            <a id="home" href="index.php">home</a>
        </div>
    </body>
</html>
