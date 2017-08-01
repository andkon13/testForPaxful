<?php
/**
 * @var \models\Offer[]         $offers
 * @var \models\User[]          $users
 * @var \models\PaymentMethod[] $payMethods
 */

use classes\App;

$user = App::getInstance()->getUser();
?>
    <div class="row">
        <div class="col-md-2">Type</div>
        <div class="col-md-3">Seller</div>
        <div class="col-md-2">Payment method</div>
        <div class="col-md-2">Min/max amount</div>
        <div class="col-md-2">Price per 1 BTC</div>
        <?php if ($user) : ?>
            <div class="col-md-1">
                <a href="" class="btn btn-success btn-sm">trade</a>
            </div>
        <?php endif; ?>
    </div>
<?php foreach ($offers as $offer) : ?>
    <div class="row">
        <div class="col-md-2"><?= $offer['type'] ? 'sel' : 'buy' ?></div>
        <div class="col-md-3"><?= $users[$offer['user_id']]->username ?></div>
        <div class="col-md-2"><?= $payMethods[$offer['pament_method_id']]->name ?? '' ?></div>
        <div class="col-md-2"><?= $offer['min'] ?>-<?= $offer['max'] ?></div>
        <?php if ($user && $offers['cost'] <= $user->amount) : ?>
            <div class="col-md-3"><?= $offer['price'] ?></div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>