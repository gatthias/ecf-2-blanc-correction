<?php
try {
    $db = new PDO("mysql:host=localhost;charset=UTF8;dbname=concerts", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $err){
    echo "Cannot initiate connexion with database.";
    die();
}