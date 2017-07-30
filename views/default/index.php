<?php
/**
 * @var \models\Offer[] $offers
 * @var \models\User[]  $users
 * @var \models\PaymentMethod[] $payMethods
 */

?>
    <div class="row">
        <div class="col-md-2">Type</div>
        <div class="col-md-3">Seller</div>
        <div class="col-md-2">Payment method</div>
        <div class="col-md-2">Min/max amount</div>
        <div class="col-md-3">Price per 1 BTC</div>
    </div>
<?php foreach ($offers as $offer) : ?>
    <div class="row">
        <div class="col-md-2"><?= $offer['type'] ? 'sel' : 'buy' ?></div>
        <div class="col-md-3"><?= $users[$offer['user_id']]->username ?></div>
        <div class="col-md-2"><?= $payMethods[$offer['pament_method_id']]['name'] ?></div>
        <div class="col-md-2"><?= $offer['min'] ?>-<?= $offer['max'] ?></div>
        <div class="col-md-3"><?= $offer['price'] ?></div>
    </div>
<?php endforeach; ?>