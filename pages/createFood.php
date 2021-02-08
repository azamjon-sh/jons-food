<?php
$php_title = 'Добавить блюдо';

require_once '../templates/header.php';
require_once '../mysqlConnect.php';
?>
    <div class="create">
        <div class="container">
            <div class="create__warp">
                <h1 class="create__title mb-5 mt-5">Давайте добавим в меню новое блюдо</h1>
                <form id="creacteform" class="creacte__form form-group">
                    <div class="create__item mb-5 ">
                        <label for="category" class="create__label">Выберите категорию для блюда</label>
                        <select name="category" id="category" class="form-control">
                            <?php
                            $sql = 'SELECT * FROM `categories` order by `id`';
                            $query = $pdo->query($sql);
                            while ($row = $query->fetch(PDO::FETCH_OBJ)) { ?>
                                <option value="<?= $row->id ?>"><?= $row->name ?></option>
                            <? } ?>
                        </select>
                    </div>
                    <div class="create__item mb-5">
                        <label for="name" class="create__label mb-2">Придумайте имя блюду</label>
                        <input type="text" id="name" name="foodName" class="form-control">
                    </div>
                    <div class="create__item mb-5">
                        <label for="price" class="create__label mb-2">Укажите цену для блюда</label>
                        <input type="number" id="price" name="price" class="form-control">
                    </div>
                    <div class="create__item mb-5">
                        <label for="description" class="create__label mb-2">Коротко опишите блюдо
                            (необязательно)*</label>
                        <textarea type="number" id="descr" name="description" class="form-control"></textarea>
                    </div>
                    <button type="submit" id="creacte__btn" class="creacte__btn btn btn-success mb-2">Добавить</button>
                    <div class="error_block bg-danger"></div>
                </form>
            </div>
        </div>
    </div>

    <script>

        $('#creacteform').submit(() => {
            let category = $("#category option:selected").val();
            let name = $('#name').val()
            let price = $('#price').val()
            let descr = $('#descr').val()
            $.ajax({
                url: '../ajax/create.php',
                method: "POST",
                cache: false,
                data: {
                    'category': category,
                    'name': name,
                    'price': price,
                    'descr': descr,
                },
                dataType: 'html',
                success: function (data) {
                    console.log(data)
                },

            })
        })
    </script>
<?php
require_once "../templates/footer.php";
?>