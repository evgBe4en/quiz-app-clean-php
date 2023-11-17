<?php

function getAllAnswers($connection)
{
    $answersQuery = "SELECT * FROM answers";
    $result = mysqli_query($connection, $answersQuery);
    $answers = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $answers[] = $row;
    }
    return $answers;
}

function getQuestionAnswers($answers, $questionId)
{
    $questionAnswers = [];
    foreach ($answers as $answer) {
        if ($answer['question_id'] == $questionId) {
            $questionAnswers[] = $answer;
        }
    }
    return $questionAnswers;
}

function getAllQuestions($connection)
{
    $questionsQuery = "SELECT * FROM questions";
    $result = mysqli_query($connection, $questionsQuery);
    $questions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $questions[] = $row;
    }
    return $questions;
}

function getUserAnswers($questions)
{
    $userAnswers = [];
    if (isset($_POST['question_id'])) {
        foreach ($_POST['question_id'] as $questionId) {
            if (isset($_POST['answer_' . $questionId])) {
                $answerId = $_POST['answer_' . $questionId];
                $userAnswers[$questionId] = $answerId;
            }
        }
    }
    return $userAnswers;
}

function getUserId($connection, $userName)
{
    $userQuery = "SELECT id FROM users WHERE name = ?";
    $stmt = mysqli_prepare($connection, $userQuery);
    mysqli_stmt_bind_param($stmt, "s", $userName);
    mysqli_stmt_execute($stmt);
    $userResult = mysqli_stmt_get_result($stmt);
    $userData = mysqli_fetch_assoc($userResult);
    mysqli_stmt_close($stmt);

    if (!$userData) {
        $insertUserQuery = "INSERT INTO users (name) VALUES (?)";
        $stmt = mysqli_prepare($connection, $insertUserQuery);
        mysqli_stmt_bind_param($stmt, "s", $userName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return mysqli_insert_id($connection);
    } else {
        return $userData['id'];
    }
}

function insertResult($connection, $userId, $totalQuestions, $userAnswers)
{
    $correctAnswers = 0;
    $incorrectAnswers = 0;

    foreach ($userAnswers as $questionId => $answerId) {
        $isCorrect = getAnswerCorrectness($connection, $answerId);
        if ($isCorrect == 1) {
            $correctAnswers++;
        } else {
            $incorrectAnswers++;
        }
    }

    $insertResultQuery = "INSERT INTO results (user_id, total, correct, incorrect, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";
    $stmt = mysqli_prepare($connection, $insertResultQuery);
    mysqli_stmt_bind_param($stmt, "iiii", $userId, $totalQuestions, $correctAnswers, $incorrectAnswers);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return [$correctAnswers, $incorrectAnswers];
}

function getAnswerCorrectness($connection, $answerId)
{
    $answerQuery = "SELECT is_correct FROM answers WHERE id = ?";
    $stmt = mysqli_prepare($connection, $answerQuery);
    mysqli_stmt_bind_param($stmt, "i", $answerId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $isCorrect);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $isCorrect;
}

function getTopResults($connection)
{
    $query = "SELECT results.total, results.correct, results.incorrect, users.name 
              FROM results 
              JOIN users ON results.user_id = users.id 
              ORDER BY results.correct DESC 
              LIMIT 10";
    $result = mysqli_query($connection, $query);
    $topResults = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $topResults[] = $row;
    }
    return $topResults;
}