<?php
$page_title = 'Главная';
require_once 'templates/header.php';
?>
    <div class="firstscreen">
        <div class="container">
            <h1 class="firstscreen__title mb-5 mt-5">Что мы будем делать</h1>
            <div class="firstscreen__list row justify-content-between">
                <a href="pages/addOrder.php" class="bg-success firstscreen__item col-12 col-sm-5 mb-5 d-flex p-5 align-items-center justify-content-center">
                    Добавить новый заказ
                </a>
                <a href="pages/createFood.php" class="bg-primary firstscreen__item col-12 col-sm-5 mb-5 d-flex p-5 align-items-center justify-content-center">
                    Добавить новое блюдо в меню
                </a>
                <a href="pages/history.php" class="bg-warning firstscreen__item col-12 col-sm-5 mb-5 d-flex p-5 align-items-center justify-content-center">
                    История заказов
                </a>
            </div>
        </div>
    </div>
<?php
require_once "templates/footer.php";
?>