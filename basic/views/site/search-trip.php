<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 09/12/2018
 * Time: 19:28
 */
?>
<?
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
$this->title = 'Город';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="form-group">
        <?= Html::beginForm('/site/search-trip', 'post'); ?>
        <?= Html::label('Пункт отправления');?>
        <br>
        <?= Html::textInput('from_city', '', ['class'=>'form-control', 'style' => 'width:300px;']);?>
        <br>
        <?= Html::label('Пункт назначения');?>
        <br>
        <?= Html::textInput('to_city', '', ['class'=>'form-control', 'style' => 'width:300px;']);?>
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

        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary', 'style' => 'margin-top:10px;']);?>
        <?= Html::endForm();?>
    </div>
    <? if(!is_null($schedules)):?>
    <?=Yii::$app->view->renderFile('@app/views/site/schedules.php', ['schedules' => $schedules]);?>
    <? endif;?>
</div>
