<?php
require "connection.php";

$page = isset($_GET['page']) ? $_GET['page'] : 1; // на какой странице мы находимся
$limit = 10; // количество записей на странице
$offset = $limit * ($page - 1); // смещение, сколько записей пропустить

// выбираем направление сортировки
$direction = isset($_GET['direction']) // если передано направление
    && in_array(strtoupper($_GET['direction']), ['ASC', 'DESC']) // и оно одно из двух возможных
    ? strtoupper($_GET['direction']) // устанавливаем его
    : 'DESC'; // иначе направление по умолчанию

$search = isset($_GET['search']) ? $_GET['search'] : ''; // поиск

// посчитаем количество записей в таблице
$query = $database->query("SELECT COUNT(*) AS count FROM articles");
$row = $query->fetch(); // берем первую возвращенную запись
$count = $row['count']; // количество записей

// $count = $query->fetchColumn(); // или можно было так в одну строку

$sql = "SELECT id, title, text " . // выбор полей id, title и text
    "FROM articles " . // из таблицы articles
    "WHERE `title` LIKE ? " . // там где поле title содержит искомую подстроку
    "ORDER BY `id` {$direction} " . // с сортировкой по полю id с переданным направлением
    "LIMIT ?, ?"; // выбрать только N записей пропустив M записей

$query = $database->prepare($sql); // подготавливаем запрос

// привязываем значения к параметрам
$query->bindValue(1, '%' . $search . '%', PDO::PARAM_STR); // что ищем
$query->bindValue(2, $offset, PDO::PARAM_INT); // сколько пропустить
$query->bindValue(3, $limit, PDO::PARAM_INT); // сколько записей взять

$query->execute(); // выполняем запрос

$articles = $query->fetchAll(); // сохраняем результат в переменную

// если был поиск
// посчитаем общее количество записей подходящих по запросу
if ($search) {
    $sql = "SELECT COUNT(*) as count FROM articles
        WHERE `title` LIKE ?
        ORDER BY `id` {$direction}";
    $query = $database->prepare($sql);
    $query->bindValue(1, '%' . $search . '%', PDO::PARAM_STR);
    $query->execute();
    $filtered = $query->fetchColumn();
} else {
    $filtered = $count;
}

// рассчитаем сколько получилось страниц
$pages = ceil($filtered / $limit);

/*
        // перебор возвращенных значений через foreach
        foreach ($query as $row) {
            print_r($row);
        }

        // взять только одну запись из результата
        print_r($query->fetch());

        // перебор возвращенных значений через while
        while ($row = $query->fetch()) {
            print_r($row);
        }
        
        // получить все записи в виде пары двух колонок
        print_r($query->fetchAll(PDO::FETCH_KEY_PAIR));

        // получить все записи в виде одной колонки
        print_r($query->fetchAll(PDO::FETCH_COLUMN));

        // сохранить все записи в переменную в виде ассоциативного массива
        // где каждый элемент будет иметь ключ равный первой колонки
        $articles = $query->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_UNIQUE);

        // количество записей
        print_r(count($articles));
    */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 mb-3">
                <h2>Главная</h2>
            </div>
            <div class="col-12 mb-3">
                <div class="row">
                    <div class="col">
                        <form action="index.php" method="GET" class="row">
                            <div class="col-auto">
                                <select class="form-select" name="direction">
                                    <option value="DESC" <?= strtoupper($direction) == "DESC" ? 'selected' : '' ?>>Самые свежие</option>
                                    <option value="ASC" <?= strtoupper($direction) == "ASC" ? 'selected' : '' ?>>Самые старые</option>
                                </select>
                            </div>
                            <input type="hidden" name="search" value="<?= $search ?>">
                            <!-- Если нужно сохранять текущую страницу: -->
                            <!-- <input type="hidden" name="page" value="<?= $page ?>"> -->
                            <div class="col-auto">
                                <button class="btn btn-secondary">Сортировать</button>
                            </div>
                        </form>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <form action="index.php" method="GET" class="row">
                            <div class="col-auto">
                                <input type="text" class="form-control" placeholder="Что ищем?" name="search" value="<?= $search ?>">
                            </div>
                            <input type="hidden" name="direction" value="<?= $direction ?>">
                            <div class="col-auto">
                                <button class="btn btn-secondary">Найти</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div>Всего записей: <b><?= $count ?></b></div>
                <?php if ($filtered != $count) : ?>
                    <div>Найдено записей: <b><?= $filtered ?></b></div>
                <?php endif; ?>
                <div>Текущая страница: <b><?= $page ?></b></div>
            </div>
            <div class="col-12 mb-3">
                <a href="insert.php" class="btn btn-success">Добавить новую статью</a>
            </div>
            <div class="col-12 mb-3">
                <?php if ($articles) : ?>
                    <?php foreach ($articles as $article) : ?>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?= $article['id'] ?>) <?= $article['title'] ?>
                                        </h5>
                                        <a href="article.php?id=<?= $article["id"] ?>" class="btn btn-primary">Посмотреть</a>
                                        <a href="update.php?id=<?= $article["id"] ?>" class="btn btn-warning">Изменить</a>
                                        <a href="delete.php?id=<?= $article["id"] ?>" class="btn btn-outline-danger">Удалить</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="d-flex justify-content-center">
                        <h4>Ничего не найдено</h4>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($pages > 1) : ?>
                <div class="col-12 mb-5 d-flex justify-content-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                <li class="page-item">
                                    <a class="page-link <?= $i == $page ? 'active' : '' ?>" href="index.php?direction=<?= $direction ?>&search=<?= $search ?>&page=<?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>