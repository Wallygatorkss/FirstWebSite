<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answer = $_POST['answer'];
    $correct = $_POST['correct'];
    
    if ($answer === $correct) {
        $_SESSION['score']++;
        $_SESSION['current_question']++;
    } else {
        $_SESSION['current_question'] = count($_SESSION['questions']);
    }
}

header('Location: quiz.php?category=' . $_SESSION['category']);
exit;
?>