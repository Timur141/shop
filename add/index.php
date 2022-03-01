<?php

require($_SERVER['DOCUMENT_ROOT'] . '/templates/headerAdmin.php');

?>

<main class="page-add">
  <h1 class="h h--1">Добавление товара</h1>

    <form class="custom-form" action="" method="post">

    </form>

    <form>
<fieldset hidden class="page-add__group custom-form__group">
  <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
  <ul class="add-list">
    <li class="add-list__item add-list__item--add">
      <input type="file" name="product-photo" id="product-photo" hidden="" value="<?= $img ?>">
      <label for="product-photo">Добавить фотографию</label>
    </li>
  </ul>
</fieldset>
      <button class="button" id="addProduct" type="submit">Добавить товар</button>
    </form>

  <section class="shop-page__popup-end page-add__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно добавлен</h2>
    </div>
    <div id="result_form"></div>
  </section>
</main>

<?php

require($_SERVER['DOCUMENT_ROOT'] . '/templates/footerAdmin.php');

?>
