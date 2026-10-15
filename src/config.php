<?php
session_start();

$host = 'localhost';
$user = 'quizuser';
$pass = 'QuizPass123';
$db = 'database_quiz';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
