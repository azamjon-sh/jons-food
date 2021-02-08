<?php
include_once '../templates/header.php';
include_once '../mysqlConnect.php';
$page_title = 'Добавить заказ';

$sql = 'SELECT * FROM `categories` order by `id`';
$query = $pdo->query($sql);
$categories = [];

while ($row = $query->fetch(PDO::FETCH_OBJ)) {
    $categories[$row->id] = $row;
}

$query = $pdo->query('SELECT menu.*,categories.id as category_id FROM `menu` LEFT JOIN `categories` ON `categories`.id = `menu`.category');
$menu = [];

while ($row = $query->fetch(PDO::FETCH_OBJ)) {
    $menu[$row->category][] = $row;
}
?>
    <div class="content">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">


            <?php
            foreach ($categories as $key => $category):?>

                <li class="nav-item " role="presentation">
                    <a class="nav-link <?= ($key == 1) ? 'active' : ''; ?>" id="<?= $category->id ?>" data-toggle="pill"
                       href="#pills-<?= $category->id ?>" role="tab"
                       aria-controls="pills-<?= $category->id ?>"
                       aria-selected="<?= ($key == 1) ? 'true' : 'false'; ?>""><?= $category->name ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="orders">
            <div class="tab-content" id="pills-tabContent">

                <? foreach ($menu as $key => $foods): ?>

                    <div class="tab-pane fade <?= ($key == 1) ? 'show active' : ''; ?>" id="pills-<?= $key ?>"
                         role="tabpanel"
                         aria-labelledby="pills-<?= $key ?>-tab">
                        <? if (!empty($foods)): ?>
                            <? foreach ($foods as $food): ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"> <?= $food->name ?></h5>
                                        <p class="card-price"> <?= $food->price ?></p>
                                        <button data-food-id="<?= $food->id ?>" class="btn btn-primary addTobasket">
                                            Добавить
                                        </button>
                                    </div>
                                </div>

                            <? endforeach; ?>
                        <? endif; ?>
                    </div>
                <? endforeach; ?>
            </div>

            <div class="left__block">
                <div class="total">Итого:
                    <div class="total-price" id="total">0</div>
                </div>
                <div class="discount">
                    <div class="discount__title">
                        Цена со скидкой
                        <input id="discount" type="number" value="">
                    </div>
                    <div class="discount__price">0</div>
                </div>
                <div id="addclient" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Добавить
                    заказ
                </div>
                <div class="basket" id="basket">

                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="modal__form p-4" action="">
                    <div class="order__client">
                        <label for="client">Имя клиента</label>
                        <input type="text" id="client">
                    </div>
                    <div class="order__operator">
                        <div class="form-group">
                            <label for="operator">Ваше имя</label>
                            <select class="form-control" id="operator">
                                <option value="alisher">Алишер</option>
                            </select>
                        </div>
                    </div>
                    <div class="opder__phone">
                        <label for="phone">Телефон клиента</label>
                        <input type="text" id="phone">
                    </div>
                    <div class="order__client">
                        <label for="client">Адрес доставки</label>
                        <input type="text" id="address">
                    </div>
                    <div class="order__descr">
                        <label for="descr">Примечание к заказу</label>
                        <textarea name="descr" id="descr" cols="20" rows="3"></textarea>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" id="addOrder" class="btn btn-primary">Заказать</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let foodData = new Array();
        let data_id = 0
        $('.addTobasket').click((event) => {
            let name = $(event.currentTarget).closest('.card-body ').children('.card-title').text()
            let price = $(event.currentTarget).prev('.card-price').text()
            let id = $(event.currentTarget).attr('data-food-id')
            let data = {
                name: name,
                price: price,
                id: id,
                data_id: data_id,
                count: 1
            }

            let total = 0;
            foodData.push(data)
            $('#basket').append(getTemplate(name, price, data_id))
            let count = 1
            total = totalPrice()
            $('#total').text(total)
            data_id++
        })

        function getTemplate(name, price, data_id) {
            let template = `
            <div class="basket__item basket-item" data-id="${data_id}">
                <div class="basket-body">
                    <h5 class="basket__item-title">${name}</h5>
                    <p class="basket__item-price">${price}</p>
                </div>
                    <button class="delete btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#dc3545" class="bi bi-x" viewBox="0 0 16 16">
                          <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </button>
            </div>`
            return template;
        }

        $('.basket').on('click', '.delete', del)

        function del(event) {
            let total = 0;
            let card = $(event.currentTarget).parents('.basket-item')
            let toDel = card.attr('data-id')
            foodData.forEach((item, index) => {
                if (item.data_id == toDel) {
                    foodData.splice(index, 1)
                    return
                }
            })
            total = totalPrice()

            card.remove();
            $('#total').text(total)
        }

        function totalPrice() {
            let total = 0
            foodData.forEach((item) => {
                total = total + parseInt(item.price)

            })
            return total
        }

        $('#discount').on('input', function () {
            let disc = $(this).val()
            let total = parseInt($('#total').text())
            if (total > 0 || disc > 0) {
                disc = disc / 100
                $('.discount__price').text(Math.ceil(total - total * disc))
            }
        });
        let order = {
            name: '',
            foods: [],
            number: '',
            address: 'Кирпичникова 11',
            operator: 'Alisher',
            oldPrice: 0,
            newPrice: 0,
            descr: 'нет описания'
        }
        $('#addclient').click(() => {
            if ($('#discount').value != '') order.oldPrice = parseInt($('.total-price').text())
            else order.oldPrice = parseInt($('.discount__price').text())
            order.newPrice = parseInt($('.discount__price').text())

        })

        $('#addOrder').click(() => {
            order.name = $('#client').val()
            order.number = $('#phone').val()
            order.operator = $('#operator').val()
            order.address = $('#address').val()
            order.descr = $('#descr').val()
            foodData.forEach((item) => {
                order.foods.push(item.name)
            })
            console.log(order)

            $.ajax({
                url: '../ajax/getOrder.php',
                method: "POST",
                cache: false,
                data: {
                    'name': order.name,
                    'number': order.number,
                    'operator': order.operator,
                    'descr': order.descr,
                    'address': order.address,
                    'foods': order.foods,
                    'newPrice': order.newPrice,
                    'oldPrice': order.oldPrice,
                },
                dataType: 'html',
                success: function (data) {
                    document.write(data)
                },

            })
        })

    </script>
<?php
require_once "../templates/footer.php";
?>