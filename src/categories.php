<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisis ta catégorie - GridQuiz</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
        <a href="index.php" class="btn btn-back">← Accueil</a>

        <div class="page-header">
            <h1 class="page-title">Choisis ta catégorie</h1>
        </div>

        <div class="categories-grid">

            <a href="quiz.php?category=Sport" class="category-card">
                <div class="category-icon">🏆</div>
                <h3 class="category-name">Sport</h3>
            </a>

            <a href="quiz.php?category=Géographie" class="category-card">
                <div class="category-icon">🌍</div>
                <h3 class="category-name">Géographie</h3>
            </a>

            <a href="quiz.php?category=Histoire" class="category-card">
                <div class="category-icon">🕐</div>
                <h3 class="category-name">Histoire</h3>
            </a>

            <a href="quiz.php?category=Sciences" class="category-card">
                <div class="category-icon">🧪</div>
                <h3 class="category-name">Sciences</h3>
            </a>

            <a href="quiz.php?category=Cinéma" class="category-card">
                <div class="category-icon">🎬</div>
                <h3 class="category-name">Cinéma</h3>
            </a>
        </div>

        <div class="warning-box">
            <p>⚠️<strong>Attention :</strong> Une seule erreur et c'est terminé !</p>
            <p>Réponds correctement à toutes les questions pour maximiser ton score</p>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>