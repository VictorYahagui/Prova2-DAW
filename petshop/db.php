<?php

$host = 'localhost';
$dbname = 'petshop';
$username = 'root';
$password = '';

try {
  $database = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
