<?php

$connection = new mysqli('localhost','root','','etablissementdb');

if ($connection->connect_error) {
    die("Échec de la connexion : %s\n" . $connection->connect_error);
}