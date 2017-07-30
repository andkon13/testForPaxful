<?php
/**
 * Created by PhpStorm.
 * User: andkon
 * Date: 29.07.17
 * Time: 19:03
 */
/**
 * @var \models\User $model
 */
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form action="#" method="post">
            <div class="input-group">
                <label>Username
                    <input name="username" type="text" class="form-control" placeholder="Username"
                           value="<?= $model->username ?>">
                </label>
            </div>

            <div class="input-group">
                <label>Full Name
                    <input name="fullname" type="text" class="form-control" placeholder="Full Name"
                           value="<?= $model->fullname ?>">
                </label>
            </div>

            <div class="input-group">
                <label>Password
                    <input name="password" type="password" class="form-control" placeholder="Password">
                </label>
            </div>
            <div class="input-group">
                <input type="submit" name="Sign In" class="btb btn-primary">
            </div>
        </form>
    </div>
</div>
