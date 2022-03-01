<?php foreach ($products as $product):

    $id = $product['id'];
    $name = $product['name'];
    $price = $product['price'];
    $isNew = $product['is_new'] ? 'Да': 'Нет';
?>

<li class="product-item page-products__item">
  <b class="product-item__name"><?= $name ?></b>
  <span class="product-item__field"><?= $id ?></span>
  <span class="product-item__field"><?= $price ?> руб.</span>

  <ul>
    <?php foreach ($categories as $categorie):
      $categorieId = $categorie['prod_id'];
      $catName = $categorie['cat_name'] ? $categorie['cat_name'] : 'Пусто';
    ?>

    <?php if ($categorieId == $id):
    ?>
      <span class="product-item__field"><?= $catName ?></span>
      <br>
    <?php endif; ?>
    <?php endforeach; ?>
    
  </ul>

  <span class="product-item__field"><?= $isNew ?></span>
  <a href="/add/index.php#<?= $id ?>" class="product-item__edit" aria-label="Редактировать"></a>
  <button id="<?= $id ?>" class="product-item__delete"></button>
</li>

<?php endforeach; ?>
