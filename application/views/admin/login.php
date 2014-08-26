<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @var array $config Global blog configuration
 * @var array $errors Form validation errors
 *
 * @author     Novichkov Sergey(Radik) <novichkovsergey@yandex.ru>
 * @copyright  Copyrights (c) 2012 Novichkov Sergey
 */
?>

<form class="form-signin" action="admin/auth/login" method="post" role="form">
    <div class="col-sm-4" style="margin: 0 auto;">
        <h2 class="form-signin-heading">Вход</h2>
        <input type="text" name="login" class="form-control" placeholder="Логин" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Пароль" required>
        <!--
        <label class="checkbox">
            <input type="checkbox" value="remember-me"> Remember me
        </label>
        -->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Вход</button>
    </div>
</form>

    <?php
    /*
    <div class="row">
        <div class="span5 offset3 well">
            <form class="form-horizontal" action="" method="post">
                <legend>Authorization</legend>

                <?php if (isset($errors['common'])) : ?>
                    <div class="alert alert-error">
                        <a href="#" class="close" data-dismiss="alert">×</a>
                        <?php echo $errors['common'] ?>
                    </div>
                <?php endif; ?>

                <div class="control-group pull-right clearfix">
                    <?php if (isset($errors['login'])) : ?>
                        <div class="alert alert-error">
                            <a href="#" class="close" data-dismiss="alert">×</a>
                            <?php echo $errors['login'] ?>
                        </div>
                    <?php endif; ?>
                    <label class="control-label" for="alogin">Email or Username</label>
                    <div class="controls"><input type="text" name="login" id="alogin" placeholder="Type your email or username"></div>
                </div>

                <div class="control-group pull-right">
                    <?php if (isset($errors['password'])) : ?>
                        <div class="alert alert-error">
                            <a href="#" class="close" data-dismiss="alert">×</a>
                            <?php echo $errors['password'] ?>
                        </div>
                    <?php endif; ?>
                    <label class="control-label" for="apassword">Password</label>
                    <div class="controls"><input type="password" name="password" id="apassword"  placeholder="Type your password"></div>
                </div>

                <div class="control-group row-fluid">
                    <label class="checkbox pull-right">
                        <input name="remember" type="checkbox" value="1"> Remember me
                    </label>
                </div>

                <button class="btn btn-primary  pull-right" type="submit">Login</button>
            </form>
        </div>
    </div>
<?php */ ?>
<style type="text/css">
    legend{ margin: 0; }
    .well{ margin-top: 100px; }
</style>