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

    // Получаем топ-10 результатов по количеству правильных ответов
    $topResults = getTopResults($connection);

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
    <style>
        .container {
            display: flex;;
            flex-direction: column;
            background-color: #fff;
            margin: 0 300px;
            padding: 20px;
        }

        table {
            border-collapse: separate;
            border-spacing: 8px;
        }

        .unit {
            text-align: center;
            padding: 5px;
            background-color: lightgray;
            width: 40px;
            height: 40px;
        }
    </style>

    <div class="container">
        <div style="display: flex; justify-content: space-between">
            <h2>Статистика</h2>
            <a href="questions.php" style="color: cadetblue">На головну</a>
        </div>

        <table>
            <thead style="text-align: start">
            <tr>
                <th class="unit">Iм`я</th>
                <th class="unit">Всього</th>
                <th class="unit">Правильнi</th>
                <th class="unit">Неправильнi</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($topResults as $result): ?>
                <tr>
                    <td class="unit"><?php echo htmlspecialchars($result['name']); ?></td>
                    <td class="unit"><?php echo htmlspecialchars($result['total']); ?></td>
                    <td class="unit"><?php echo htmlspecialchars($result['correct']); ?></td>
                    <td class="unit"><?php echo htmlspecialchars($result['incorrect']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

