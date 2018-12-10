<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 09/12/2018
 * Time: 21:00
 */
?>
<?
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use dosamigos\datepicker\DatePicker;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->session->hasFlash('user_exists')): ?>

    <div class="alert alert-danger">
        Пользователь с таким именем уже существует
    </div>
    <? elseif(Yii::$app->session->hasFlash('invalid_data')): ?>
        <div class="alert alert-danger">
            Ошибка ввода данных. Возможно вы ввели не все данные или просто ошиблись.
        </div>
    <? endif;?>
        <div class="row">
            <div class="col-lg-5">
                <div class="form-group">
                    <?= Html::beginForm('/site/registration', 'post'); ?>
                    <?= Html::label('Имя пользователя');?>
                    <br>
                    <?= Html::textInput('user_login', '', ['class'=>'form-control', 'style' => 'width:300px;']);?>
                    <br>
                    <?= Html::label('Фамилия');?>
                    <br>
                    <?= Html::textInput('user_last_name', '', ['class'=>'form-control', 'style' => 'width:300px;']);?>
                    <br>
                    <?= Html::label('Имя');?>
                    <br>
                    <?= Html::textInput('user_first_name', '', ['class'=>'form-control', 'style' => 'width:300px;']);?>
                    <br>
                    <?= Html::label('Отчество');?>
                    <br>
                    <?= Html::textInput('user_middle_name', '', ['class'=>'form-control', 'style' => 'width:300px;']);?>
                    <br>
                    <?= Html::label('Выберите дату рождения');?>
                    <br>
                    <?= DatePicker::widget([
                        'name' => 'date',
                        'value' => date('d-m-Y'),
                        'template' => '{addon}{input}',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-mm-yyyy'
                        ]
                    ]);?>
                    <?= Html::label('Пароль');?>
                    <br>
                    <?= Html::textInput('user_password', '', ['class'=>'form-control', 'style' => 'width:300px;', 'type' => 'password']);?>
                    <br>
                    <?= Captcha::widget([
                        'name' => 'captcha',
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'style' => 'margin-top:10px;']);?>
                    <?= Html::endForm();?>

            </div>
        </div>
</div>
