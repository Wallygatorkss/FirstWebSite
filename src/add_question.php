<?php
require_once 'config.php';

$success = false;
$error = '';
$edit_mode = false;
$edit_question = null;

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->execute([$id]);
    $stmt = $pdo->prepare("DELETE FROM questions_utilisateur WHERE question_id = ?");
    $stmt->execute([$id]);
    $success = "Question supprimée avec succès !";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['edit_id'])) {
    $question = $_POST['question'];
    $categorie = $_POST['categorie'];
    $reponse_1 = $_POST['reponse_1'];
    $reponse_2 = $_POST['reponse_2'];
    $reponse_3 = $_POST['reponse_3'];
    $reponse_4 = $_POST['reponse_4'];
    $bonne_reponse = $_POST['bonne_reponse'];

    $reponses = [
        '1' => $reponse_1,
        '2' => $reponse_2,
        '3' => $reponse_3,
        '4' => $reponse_4
    ];
    
    $reponse_correcte = $reponses[$bonne_reponse];
    unset($reponses[$bonne_reponse]);
    $autres_reponses = array_values($reponses);
    
    $stmt = $pdo->prepare("INSERT INTO questions (categorie_id, question, reponse_correcte, reponse_2, reponse_3, reponse_4) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$categorie, $question, $reponse_correcte, $autres_reponses[0], $autres_reponses[1], $autres_reponses[2]]);
    
    $question_id = $pdo->lastInsertId();
    $stmt = $pdo->prepare("INSERT INTO questions_utilisateur (question_id) VALUES (?)");
    $stmt->execute([$question_id]);
    
    $success = "Question ajoutée avec succès !";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id = (int)$_POST['edit_id'];
    $question = $_POST['question'];
    $categorie = $_POST['categorie'];
    $reponse_1 = $_POST['reponse_1'];
    $reponse_2 = $_POST['reponse_2'];
    $reponse_3 = $_POST['reponse_3'];
    $reponse_4 = $_POST['reponse_4'];
    $bonne_reponse = $_POST['bonne_reponse'];

    $reponses = [
        '1' => $reponse_1,
        '2' => $reponse_2,
        '3' => $reponse_3,
        '4' => $reponse_4
    ];
    
    $reponse_correcte = $reponses[$bonne_reponse];
    unset($reponses[$bonne_reponse]);
    $autres_reponses = array_values($reponses);
    
    $stmt = $pdo->prepare("UPDATE questions SET categorie_id = ?, question = ?, reponse_correcte = ?, reponse_2 = ?, reponse_3 = ?, reponse_4 = ? WHERE id = ?");
    $stmt->execute([$categorie, $question, $reponse_correcte, $autres_reponses[0], $autres_reponses[1], $autres_reponses[2], $id]);
    $success = "Question modifiée avec succès !";
}

if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_question = $stmt->fetch();
    if ($edit_question) {
        $edit_mode = true;
    }
}

$stmt = $pdo->prepare("SELECT q.*, c.nom as categorie_nom FROM questions q JOIN categories c ON q.categorie_id = c.id JOIN questions_utilisateur qu ON q.id = qu.question_id ORDER BY q.id DESC");
$stmt->execute();
$questions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une question - GridQuiz</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
        <div class="add-question-header">
            <a href="index.php" class="btn btn-back">← Accueil</a>
            <h1 class="page-title gradient-text"><?= $edit_mode ? 'Modifier la question' : 'Ajouter une question' ?></h1>
        </div>

        <?php if ($success): ?>
            <div class="message success-message">
                ✅ <?= $success ?>
            </div>
        <?php endif; ?>

        <form class="add-question-form" method="POST" action="">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="edit_id" value="<?= $edit_question['id'] ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label>🏷️ Catégorie</label>
                <select name="categorie" required>
                    <option value="">-- Sélectionne une catégorie --</option>
                    <option value="1">🕐 Histoire</option>
                    <option value="2">🌍 Géographie</option>
                    <option value="3">🔬 Sciences</option>
                    <option value="4">🎬 Cinéma</option>
                    <option value="5">🏆 Sport</option>
                </select>
            </div>

            <div class="form-group">
                <label>💭 Question</label>
                <textarea name="question" placeholder="Ex: Quelle est la capitale de la France ?" rows="4" required><?= htmlspecialchars($edit_question['question'] ?? $_POST['question'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label>🎯 Les 4 réponses</label>
                
                <div class="answer-input-group">
                    <span class="answer-badge">A</span>
                    <input type="text" name="reponse_1" placeholder="Réponse A" value="<?= htmlspecialchars($edit_question['reponse_correcte'] ?? $_POST['reponse_1'] ?? '') ?>" required>
                </div>

                <div class="answer-input-group">
                    <span class="answer-badge">B</span>
                    <input type="text" name="reponse_2" placeholder="Réponse B" value="<?= htmlspecialchars($edit_question['reponse_2'] ?? $_POST['reponse_2'] ?? '') ?>" required>
                </div>

                <div class="answer-input-group">
                    <span class="answer-badge">C</span>
                    <input type="text" name="reponse_3" placeholder="Réponse C" value="<?= htmlspecialchars($edit_question['reponse_3'] ?? $_POST['reponse_3'] ?? '') ?>" required>
                </div>

                <div class="answer-input-group">
                    <span class="answer-badge">D</span>
                    <input type="text" name="reponse_4" placeholder="Réponse D" value="<?= htmlspecialchars($edit_question['reponse_4'] ?? $_POST['reponse_4'] ?? '') ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>✓ Quelle est la bonne réponse ?</label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="bonne_reponse" value="1" required>
                        <span>Réponse A</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="bonne_reponse" value="2" required>
                        <span>Réponse B</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="bonne_reponse" value="3" required>
                        <span>Réponse C</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="bonne_reponse" value="4" required>
                        <span>Réponse D</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-large btn-full">
                <?= $edit_mode ? '✏️ Modifier la question' : '📤 Ajouter la question' ?>
            </button>
            
            <?php if ($edit_mode): ?>
                <a href="add_question.php" class="btn btn-outline btn-full" style="margin-top: 1rem;">❌ Annuler</a>
            <?php endif; ?>
        </form>

        <h2>📋 Liste des questions</h2>
        
        <?php if (empty($questions)): ?>
            <p>Aucune question pour le moment.</p>
        <?php else: ?>
            <?php foreach ($questions as $q): ?>
                <div class="question-card">
                    <div class="question-header">
                        <div>
                            <span class="category-badge"><?= htmlspecialchars($q['categorie_nom']) ?></span>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="add_question.php?edit=<?= $q['id'] ?>" class="btn btn-outline" style="padding: 0.5rem 1rem;">✏️ Modifier</a>
                            <a href="add_question.php?delete=<?= $q['id'] ?>" class="btn btn-outline btn-delete" style="padding: 0.5rem 1rem;" onclick="return confirm('Supprimer cette question ?')">🗑️ Supprimer</a>
                        </div>
                    </div>
                    <p class="question-text"><strong><?= htmlspecialchars($q['question']) ?></strong></p>
                    <div class="answers-list">
                        <p>✓ <?= htmlspecialchars($q['reponse_correcte']) ?></p>
                        <p>• <?= htmlspecialchars($q['reponse_2']) ?></p>
                        <p>• <?= htmlspecialchars($q['reponse_3']) ?></p>
                        <p>• <?= htmlspecialchars($q['reponse_4']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="info-box">
            💡 <strong>Astuce :</strong> N'oublie pas de sélectionner la catégorie !
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>