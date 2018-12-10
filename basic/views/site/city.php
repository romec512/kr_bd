<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 06/12/2018
 * Time: 23:31
 */

use yii\helpers\Html;

$this->title = 'Город';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="form-group">
        <?= Html::beginForm('/site/get-stations', 'post'); ?>
        <?= Html::label('Введите название города');?>
        <br>
        <?= Html::textInput('city', '', ['class'=>'form-control', 'style' => 'width:300px;']);?>
        <br>
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary', 'style' => 'margin-top:10px;']);?>
        <?= Html::endForm();?>
    </div>
    <? if(!is_null($city_stations)): ?>
    <table class="table-bordered text-center table-condensed table-striped">
    <? foreach($city_stations as $station) : ?>
    <tr>
        <td>
            <?= Html::a($station['station_name'], \yii\helpers\Url::to(['/site/get-station-schedule','station_code' => $station['station_code']]));?>
        </td>
        <td style="margin-left:10px;">
            <?= $station['station_address'];?>
        </td>
    </tr>
    <? endforeach; ?>
    </table>
    <? endif;?>
</div>