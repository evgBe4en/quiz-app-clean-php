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
    $answers = getAllAnswers($connection);

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

        <form method="POST"
              style="display: flex; ;flex-direction: column; background-color:#fff; margin: 0 300px; padding: 20px"
              action="result.php">
            <div style="display: flex; justify-content: space-between">
                <h2>Тест</h2>
                <a href="resultsTable.php" style="color: cadetblue">Статистика</a>
            </div>
            <input
                style="width: 150px; height: 30px"
                type="text"
                name="name"
                placeholder="Ваше ім'я"
                required
                minlength="3"
                maxlength="15"
            />
            <?php foreach ($questions as $question): ?>

                <div style="padding: 5px; text-align: start; margin-top: 15px">
                    <?php echo htmlspecialchars($question['id'] . '.' . $question['text']); ?>
                </div>

                <?php
                $questionId = $question['id'];
                $questionAnswers = getQuestionAnswers($answers, $questionId);
                ?>
                <?php foreach ($questionAnswers as $answer): ?>
                    <label>
                        <input
                            type="radio"
                            name="answer_<?php echo $question['id']; ?>"
                            value="<?php echo $answer['id']; ?>"
                            required
                        >
                        <?php echo htmlspecialchars($answer['answer_text']); ?>
                    </label>

                <?php endforeach; ?>

                <input type="hidden" name="question_id[]" value="<?php echo $question['id']; ?>">


            <?php endforeach; ?>

            <button type="submit" style="margin-top: 20px;">Завершити</button>
        </form>


    </div>
</div>
</body>
</html>