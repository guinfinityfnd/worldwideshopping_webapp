<?php
//////////////////////////////// offline database ///////////////////////////////////////////
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {
        $db = new PDO("mysql:host=$servername;dbname=shopping",$username,$password);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        // echo "successfully";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

//////////////////////////////// online database /////////////////////////////////////////////
    // $servername = "sql205.epizy.com";
    // $username = "epiz_32167863";
    // $password = "5pdTHm056pvyybD";

    // try {
    //     $db = new PDO("mysql:host=$servername;dbname=epiz_32167863_shopping",$username,$password);
    //     $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //     // echo "successfully";
    // } catch (PDOException $e) {
    //     echo "Connection failed: " . $e->getMessage();
    // }
?>