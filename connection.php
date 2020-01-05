<?php

function getConnection()
{
    try { 
        $db = new PDO('mysql:host=localhost;dbname=quiz;charset=UTF8', 'root', '', [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]); 
        return $db;

    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage()) or die(print_r($db->errorInfo()));
    }
}