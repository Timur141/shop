<?php foreach ($items as $item):

    $id = $item['id'];
    $img = $item['img'];
    $name = $item['name'];
    $price = $item['price'];

?>
 

<article id="<?= $id ?>" class="shop__item product" tabindex="0">
    <div class="product__image">
        <img src="<?= $img ?>" alt="product-name">
    </div>
    <p class="product__name"><?= $name ?></p>
    <span class="product__price"><?= $price ?> руб.</span>
</article>

<?php endforeach; ?>
      <section class="shop__list">

