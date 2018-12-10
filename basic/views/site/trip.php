<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 08/12/2018
 * Time: 20:10
 */
?>
<div class="site-index">

    <div class="jumbotron">
        <h2>Рейс: <?=$trip_info[0]['from_city_name'] . ' - ' . $trip_info[0]['to_city_name']?></h2>

        <p class="lead"><?=$trip_info[0]['from_station_name'].' ('.$trip_info[0]['from_station_address'].') - '.
        $trip_info[0]['to_station_name'] . ' (' . $trip_info[0]['to_station_address'] . ')';?>
        </p>

        <p><?=\yii\helpers\Html::a('Купить', \yii\helpers\Url::to(['site/buy', 'trip_id' => $trip_id]),[
            'class' => 'btn btn-success btn-lg'
            ]);?>
        </p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Автобус</h2>
                <p style="font-size: 1.5em">Гос. номер: <?=$trip_info[0]['bus_number']?></p>
                <p style="font-size: 1.5em">Марка: <?=$trip_info[0]['bus_brand']?></p>
                <p style="font-size: 1.5em">Модель: <?=$trip_info[0]['bus_model']?></p>
            </div>
            <div class="col-lg-4">
                <h2>Информация</h2>
                <p style="font-size: 1.5em">Отправление: <?=$departure_date . ' в ' . $departure_time;?></p>
                <p style="font-size: 1.5em">Прибытие: <?=$arrival_date . ' в ' . $arrival_time;?></p>
                <p style="font-size: 1.7em">Цена: <?=$trip_info[0]['price'];?></p>
                <p style="font-size: 1.5em">Кол-во мест: <?=$trip_info[0]['seats_count'];?></p>

            </div>
            <div class="col-lg-4">
                <h2><?if(count($trip_info) == 1):?>Водитель <?else:?> Водители <?endif?></h2>
                <? foreach($trip_info as $trip) : ?>
                <p style="font-size:1.5em;">
                    <?=$trip['driver_last_name'] . ' ' . $trip['driver_first_name'] . ' (' . $trip['driver_category'] . ')'?>
                </p>
                <?endforeach;?>
            </div>
        </div>

    </div>
</div>
