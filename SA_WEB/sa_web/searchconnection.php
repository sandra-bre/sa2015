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
        <title>Routenator - Search Connection</title>
    </head>
    <body>
        <div class="main_window">
        <h1>Search Connection</h1>
        
        <form id="searchconnection" method="get" action="showcon.php">
            <a>Start:</a><br>
            <input type="text" name="startcon">
            <br><br>
            
            <a>Destination:</a><br>
            <input type="text" name="destcon">
            <br><br>
            
            <input type="submit" value="Search Connection">
        </form>
        
        
        <a id="home" href="index.php">home</a>
        <div>
    </body>
</html>
