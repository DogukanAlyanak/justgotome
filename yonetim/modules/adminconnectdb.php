<?php

include "adminconfig.php";

    $dbhost = "localhost";
    $dbname = "db";
    $dbuser = "root";
    $dbpass = "";

//Veritabanı Bağlanma Hata Ayıklama
try {
    $db = new PDO("mysql:host=$dbhost;dbname=$dbname; charset=utf8", "$dbuser", "$dbpass");
} catch (PDOException $e) {
    print $e->getMessage();
}
