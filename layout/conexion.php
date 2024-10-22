<?php
    $host = 'localhost';
    $db = 'db_matriz_iso';
    $user = 'root';
    $password = '';
    $charset ='utf8';
    try {

        $base = new PDO("mysql:host=".$host."; dbname=".$db, $user, $password);//conexion mediante PDO
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Control de errores 
        $base->exec("SET CHARACTER SET UTF8");//Ejecucion para la admision de caracteres especiales

    } catch (Exception $e) {
        //Capturas de errores mediante el catch
        echo "Error: " . $e->getLine() . "<br>";
        echo "Error: " . $e->GetMessage(); 
    }

