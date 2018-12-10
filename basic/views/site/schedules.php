<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 08/12/2018
 * Time: 11:16
 */
?>
<? if(!is_null($schedules)): ?>
    <table class="table-bordered text-center table-condensed table-striped">
        <thead style="font-style: italic; font-size: 1.2em">
        <tr>
            <td>
                Название станции отправления
            </td>
            <td style="margin-left:10px;">
                Город отправления
            </td>
            <td style="margin-left:10px;">
                Адрес станции
            </td>
            <td style="margin-left:10px;">
                Название станции прибытия
            </td>
            <td style="margin-left:10px;">
                Город прибытия
            </td>
            <td style="margin-left:10px;">
                Адрес станции
            </td>
            <td style="margin-left:10px;">
                Кол-во мест
            </td>
            <td style="margin-left:10px;">
                Цена
            </td>
            <td style="margin-left:10px;width:135px">
            </td>
        </tr>
        </thead>
        <? foreach($schedules as $schedule) : ?>
            <tr>
                <td>
                    <?= $schedule['from_station_name'];?>
                </td>
                <td style="margin-left:10px;">
                    <?= $schedule['from_city_name'];?>
                </td>
                <td style="margin-left:10px;">
                    <?= $schedule['from_station_address'];?>
                </td>
                <td style="margin-left:10px;">
                    <?= $schedule['to_station_name'];?>
                </td>
                <td style="margin-left:10px;">
                    <?= $schedule['to_city_name'];?>
                </td>
                <td style="margin-left:10px;">
                    <?= $schedule['to_station_address'];?>
                </td>
                <td style="margin-left:10px;">
                    <?= $schedule['seats_count'];?>
                </td>
                <td style="margin-left:10px;">
                    <?= $schedule['price'];?>
                </td>
                <td style="margin-left:10px; text-align:left;">
                    <?= \yii\helpers\Html::a('', \yii\helpers\Url::to(['site/trip','trip_id' => $schedule['trip_id']]),
                        [
                            'class' => 'btn btn-info glyphicon glyphicon-eye-open',
                            'style' => 'margin-left: 3px;'
                        ]);?>
                    <? if(!$buying_tickets):?>
                    <?= \yii\helpers\Html::a('Купить', \yii\helpers\Url::to(['site/buy','trip_id' => $schedule['trip_id']]),
                        [
                            'class' => 'btn btn-success',
                            'style' => 'margin-left:3px;'
                        ]);?>
                    <?endif?>
                </td>
            </tr>
        <? endforeach; ?>
    </table>
<? endif;?>