<?php
$php_title = 'История заказов';

require_once '../templates/header.php';
require_once '../mysqlConnect.php';
$sql = 'SELECT * FROM `orders` ORDER BY `id` DESC';
$query = $pdo->query($sql);
$orders = [];

while ($row = $query->fetch(PDO::FETCH_OBJ)) {
    $orders[$row->id] = $row;
}
?>
<div class="history">
    <div class="content">
        <table class="history__list">
            <tr class="heads">
                <td>№</td>
                <td>Клиент</td>
                <td>Время</td>
                <td>Телефон</td>
                <td>Адрес</td>
                <td>Оператор</td>
                <td>Заказ</td>
                <td>Цена</td>
                <td>Цена со скидкой</td>
                <td>Примечание</td>
            </tr>
            <?php
            foreach ($orders as $key => $order): ?>
                <tr class="order__item">
                    <td class="order__id">
                        <?= $order->id; ?>
                    </td>
                    <td class="name">
                        <?= $order->client; ?>
                    </td>
                    <td class="order__date">
                        <?= $order->orderDate; ?>
                    </td>

                    <td class="phone">
                        <?= $order->number; ?>
                    </td>
                    <td class="address">
                        <?= $order->address; ?>
                    </td>
                    <td class="operator">
                        <?= $order->operator; ?>
                    </td>
                    <td class="order__foods">
                        <?= $order->foods; ?>
                    </td>
                    <td class="histoty__oldPrice">
                        <?= $order->oldPrice; ?>
                    </td>
                    <td class="histoty__newPrice">
                        <? if ($order->newPrice == '0' || $order->newPrice == '')
                            echo $order->oldPrice;
                        else echo $order->newPrice;
                        ?>
                    </td>

                    <td class="order__descr">
                        <?= $order->descr; ?>
                    </td>

                </tr>
            <? endforeach; ?>
        </table>
    </div>
</div>
