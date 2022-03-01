<?php 

$name = $product['name'];
$price = $product['price'];
$img = $product['img'];

$femaleSelect = '';
$maleSelect = '';
$childrenSelect = '';
$accessSelect = '';

foreach ($categories as $categorie) {
    if ($categorie['cat_id'] == 1) {
        $femaleSelect = 'selected';
    } elseif ($categorie['cat_id'] == 2) {
        $maleSelect = 'selected';
    } elseif ($categorie['cat_id'] == 3) {
        $childrenSelect = 'selected';
    } elseif ($categorie['cat_id'] == 4) {
        $accessSelect = 'selected';
    }
}

$newCheck = $product['is_new'] == 1 ? 'checked' : '';
$saleCheck = $product['is_sale'] == 1 ? 'checked' : '';

?>

<fieldset class="page-add__group custom-form__group">
  <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
  <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
    <input type="text" class="custom-form__input" name="product-name" id="product-name" value="<?= $name ?>">
    <p class="custom-form__input-label">
      Название товара
    </p>
  </label>
  <label for="product-price" class="custom-form__input-wrapper">
    <input type="text" class="custom-form__input" name="product-price" id="product-price" value="<?= $price ?>">
    <p class="custom-form__input-label">
      Цена товара
    </p>
  </label>
</fieldset>
<fieldset class="page-add__group custom-form__group">
  <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
  <ul class="add-list">
    <li class="add-list__item add-list__item--add">
      <input type="text" name="product-photo" id="product-photo-text" hidden="" value="<?= $img ?>">
      <input type="file" name="product-photo" id="product-photo" hidden="" value="<?= $img ?>">

      <label for="product-photo">Добавить фотографию</label>
    </li>
  </ul>
</fieldset>
<fieldset class="page-add__group custom-form__group">
  <legend class="page-add__small-title custom-form__title">Раздел</legend>
  <div class="page-add__select">
    <select name="category[]" class="custom-form__select" multiple="multiple">
      <option hidden="">Название раздела</option>


      <option <?= $femaleSelect ?> value="1">Женщины</option>
      <option <?= $maleSelect ?> value="2">Мужчины</option>
      <option <?= $childrenSelect ?> value="3">Дети</option>
      <option <?= $accessSelect ?> value="4">Аксессуары</option>


    </select>
  </div>
  <input <?= $newCheck ?> type="checkbox" name="new" id="new" class="custom-form__checkbox">
  <label for="new" class="custom-form__checkbox-label">Новинка</label>
  <input <?= $saleCheck ?> type="checkbox" name="sale" id="sale" class="custom-form__checkbox">
  <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
</fieldset>
  