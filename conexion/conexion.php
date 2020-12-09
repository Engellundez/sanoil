<?php
    // $servername     = "localhost";
    // $username = "";
    // $password = "";
    // $dbname     = "";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sanoil";

    // Create connection
    $conexion = mysqli_connect($servername, $username, $password, $dbname);
    $conexion->set_charset("utf8");
    // Check connection
    if (!$conexion) {
        die("Connection failed: " . $conexion->connect_error);
    }
?>