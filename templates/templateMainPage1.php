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

  <ul class="shop__paginator paginator">
    <?php if ($page !== 1): ?>
        <li  data-page="1">
          <a id="1" class="paginator__item" href="">&laquo</a>
        </li>

        <li data-page="<?= $page - 1 ?>">
          <a id="<?= $page - 1 ?>" class="paginator__item" href="">&lt</a>
        </li>
    <?php endif ?>

    <?php for ($i = 1; $i <= $count; $i++): ?>
        <li data-page="<?= $i ?>">
          <a id="<?= $i ?>" class="paginator__item" <?= ($i !== $page) ? 'href=""' : '' ?>><?= $i ?></a>
        </li>
    <?php endfor ?>

    <?php if ($page != $count): ?>
        <li  data-page="<?= $page + 1 ?>">
          <a id="<?= $page + 1 ?>" class="paginator__item" href="">&gt</a>
        </li>

        <li  data-page="<?= $count ?>">
          <a id="<?= $count ?>" class="paginator__item" href="">&raquo</a>
        </li>
    <?php endif ?>

  </ul>