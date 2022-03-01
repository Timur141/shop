<?php foreach ($orders as $order): ?>

    <li class="order-item page-order__item">
    <div class="order-item__wrapper">
    <div class="order-item__group order-item__group--id">

<?php
    $id = $order['id'];
    if (($order['delivery'] == '1') and ($order['prod_price'] < 2000)) {
        $price = $order['prod_price'] + 280;
    } else {
        $price = $order['prod_price'];
    }
    $name = $order['name'] . ' ' . $order['surname'] . ' ' . $order['thirdname'];
    $phone = $order['phone'];
    $delivery = ($order['delivery'] == '1') ? 'Курьерная доставка' : 'Самовывоз';
    $pay = ($order['pay'] == 'card') ? 'Банковской картой' : 'Наличными';
    $isProcessed = ($order['is_processed']) ? 'class="order-item__info order-item__info--yes">Выполнено' :
                    'class="order-item__info order-item__info--no">Не выполнено';
    $address = 'г. ' . $order['city'] . ', ул. ' . $order['street'] . ', д. ' .  $order['home'] . ', кв. ' . $order['apt'];
    $comment = ($order['comment'] == '0') ? ' ' : $order['comment'];
?>


      <span class="order-item__title">Номер заказа</span>
      <span class="order-item__info order-item__info--id"><?= $id ?></span>
    </div>
    <div class="order-item__group">
      <span class="order-item__title">Сумма заказа</span>
      <?= $price ?> руб.
    </div>
    <button class="order-item__toggle"></button>
  </div>
  <div class="order-item__wrapper">
    <div class="order-item__group order-item__group--margin">
      <span class="order-item__title">Заказчик</span>
      <span class="order-item__info"><?= $name ?></span>
    </div>
    <div class="order-item__group">
      <span class="order-item__title">Номер телефона</span>
      <span class="order-item__info"><?= $phone ?></span>
    </div>
    <div class="order-item__group">
      <span class="order-item__title">Способ доставки</span>
      <span class="order-item__info"><?= $delivery ?></span>
    </div>
    <div class="order-item__group">
      <span class="order-item__title">Способ оплаты</span>
      <span class="order-item__info"><?= $pay ?></span>
    </div>
    <div class="order-item__group order-item__group--status">
      <span class="order-item__title">Статус заказа</span>
      <span <?= $isProcessed ?></span>
      <button id="<?= $id ?>" class="order-item__btn">Изменить</button>
    </div>
  </div>

  <?php if ($order['delivery'] != '0'): ?>
    <div class="order-item__wrapper">
      <div class="order-item__group">
        <span class="order-item__title">Адрес доставки</span>
        <span class="order-item__info"><?= $address ?></span>
      </div>
    </div>
  <?php endif ?>

  <div class="order-item__wrapper">
    <div class="order-item__group">
      <span class="order-item__title">Комментарий к заказу</span>
      <span class="order-item__info"><?= $comment ?></span>
    </div>
  </div>
</li>

<?php endforeach; ?>
