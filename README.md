# QUIZ-app

### About

Додаток являє собою просту систему тестування на PHP з використанням Laravel framework.

Воно дає змогу:

- адмініструвати базу запитань і відповідей до тестів
- користувачам проходити тестування
- відстежувати статистику результатів кожного користувача.

Основні можливості:

- формування тестів із набору запитань і варіантів відповідей;
- збереження результатів тестування із зазначенням правильних/неправильних відповідей;
- виведення топ-10 лідерів за кількістю правильних відповідей.

## Вимоги для запуску проекту

PHP >= 8.1
MySQL
Локальный сервер по типу Wampp/Xampp та iн.

## Як запустити проект?

Запустiть локальный сервер.

Запустiть БД десктоп або в phpmyadmin

Клонуйте сховище:

	 git clone https://github.com/evgBe4en/quiz-app-clean-php.git
 
Перейдіть до папки quiz-app:

 	 cd quiz-app-clean-php


Внесіть необхідні зміни конфігурації у файл config/database.php:

	'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'quiz_db'

Перейдіть до файлу SEED_DB, скопiюйте вмiст у MySQL середовище та виконайте INSERT запити.

Перейдіть до папки public

	cd public

Запустiть файл index.php через IDE або через термiнал

	php index.php

