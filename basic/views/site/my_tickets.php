<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 09/12/2018
 * Time: 21:53
 */
?>
<h1>Мои билеты</h1>
<?php if (Yii::$app->session->hasFlash('buying_error')): ?>

    <div class="alert alert-danger">
        Возникла ошибка при покупке
    </div>
<? elseif (Yii::$app->session->hasFlash('buying_success')): ?>
    <div class="alert alert-success">
        Билет успешно приобретен
    </div>
<? endif;?>
<?= Yii::$app->view->renderFile('@app/views/site/schedules.php', ['schedules' => $tickets, 'buying_tickets' => true]);?>