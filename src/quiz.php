<?php
require_once 'config.php';

$category = $_GET['category'];

if (!isset($_SESSION['quiz_started']) || isset($_GET['restart']) || 
    (isset($_SESSION['category']) && $_SESSION['category'] !== $category)) {
    $_SESSION['quiz_started'] = true;
    $_SESSION['current_question'] = 0;
    $_SESSION['score'] = 0;
    $_SESSION['category'] = $category;
    
    $stmt = $pdo->prepare("SELECT q.* FROM questions q JOIN categories c ON q.categorie_id = c.id WHERE c.nom = ? ORDER BY RAND() LIMIT 5");
    $stmt->execute([$category]);
    $_SESSION['questions'] = $stmt->fetchAll();
}

$current_index = $_SESSION['current_question'];
$questions = $_SESSION['questions'];
$total = count($questions);

if ($current_index >= $total) {
    $game_over = true;
    $score = $_SESSION['score'];
} else {
    $question = $questions[$current_index];
    
    $reponses = [
        ['texte' => $question['reponse_correcte'], 'valeur' => 1],
        ['texte' => $question['reponse_2'], 'valeur' => 2],
        ['texte' => $question['reponse_3'], 'valeur' => 3],
        ['texte' => $question['reponse_4'], 'valeur' => 4]
    ];
    shuffle($reponses);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <?php if (isset($game_over)): ?>
            <div class="game-over">
                <h1>Fin du quiz !</h1>
                <p class="final-score">Score : <?= $score ?> / <?= $total ?></p>
                <div class="button-group">
                    <a href="quiz.php?category=<?= $_SESSION['category'] ?>&restart=1" class="btn btn-primary btn-large">Rejouer</a>
                    <a href="categories.php" class="btn btn-outline btn-large">Catégories</a>
                    <a href="index.php" class="btn btn-outline btn-large">Accueil</a>
                </div>
            </div>
        <?php else: ?>
            <a href="categories.php" class="btn btn-back">← Retour</a>
            
            <div class="quiz-info">
                <p>Score: <?= $_SESSION['score'] ?> / <?= $total ?> | Question <?= $current_index + 1 ?>/<?= $total ?></p>
            </div>
            
            <h2 class="quiz-question"><?= htmlspecialchars($question['question']) ?></h2>
            
            <form method="POST" action="ajax_check_answer.php">
                <?php 
                $lettres = ['A', 'B', 'C', 'D'];
                foreach ($reponses as $index => $reponse): 
                ?>
                    <button type="submit" name="answer" value="<?= $reponse['valeur'] ?>" class="btn btn-outline btn-full">
                        <?= $lettres[$index] ?>. <?= htmlspecialchars($reponse['texte']) ?>
                    </button>
                <?php endforeach; ?>
                <input type="hidden" name="correct" value="1">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
