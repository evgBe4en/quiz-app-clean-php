<?php

require_once '../src/Database.php';
require_once '../services/functions.php';

try {

    if (!file_exists('../config/database.php')) {
        throw new Exception("Missing database configuration file.");
    }

    $config = require_once '../config/database.php';

    $database = new Database($config['host'], $config['username'], $config['password'], $config['database']);
    $connection = $database->getConnection();

    $questions = getAllQuestions($connection);
    $totalQuestions = count($questions);
    $userAnswers = getUserAnswers($questions);

    $userName = isset($_POST['name']) ? $_POST['name'] : 'Anonymous';
    $userId = getUserId($connection, $userName);

    [$correctAnswers, $incorrectAnswers] = insertResult($connection, $userId, $totalQuestions, $userAnswers);

    $database->closeConnection();

} catch (Exception $e) {

    echo "Error: " . $e->getMessage();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quiz-app</title>
</head>
<body style="background-color: lightgray; padding: 0; margin: 0">
<div>
    <div style="height: 60px; background-color:darkslateblue; margin-bottom: 20px">
    </div>
    <div style="display: flex; ;flex-direction: column; background-color:#fff; margin: 0 300px; padding: 20px">
        <div style="display: flex; justify-content: space-between">
            <h2>Тест</h2>
            <a href="resultsTable.php" style="color: cadetblue">Статистика</a>
        </div>
        <div>
            <p>
                Ви пройшли тест!
                <br>
                <br>
                Ось ваш результат:
            </p>
        </div>
        <div>Всього питань: <?php echo $totalQuestions; ?></div>
        <div>Вiрних вiдповiдей: <?php echo $correctAnswers; ?></div>
        <div>Невiрних вiдповiдей: <?php echo $incorrectAnswers; ?></div>
    </div>
</div>
</body>
</html>

