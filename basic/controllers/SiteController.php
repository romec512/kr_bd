<?php

namespace app\controllers;

use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','buy'],
                'rules' => [
                    [
                        'actions' => ['logout', 'buy'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->redirect('/site/search-trip');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Отображение страницы поиска станций по названию города
     */
    public function actionCity(){
        return $this->render('city');
    }

    /**
     * @return string
     * @throws \yii\db\Exception
     * Получение станций по названию города (вывод результатов)
     */
    public function actionGetStations(){
        $city_name = Yii::$app->request->post('city');
        $result = null;
        if(!is_null($city_name)) {
            $result = Yii::$app->db->createCommand("SELECT station_name,station_address,station_code FROM stations LEFT JOIN cities ON stations.city_code = cities.city_code WHERE city_name = '{$city_name}'")
            ->queryAll();
        }
        return $this->render('city', [
           'city_stations' => $result
        ]);
    }
    /*
     * Метод получения рейсов по станции
     */
    public function actionGetStationSchedule(){
        $station_code = Yii::$app->request->get('station_code');
        $schedules = Yii::$app->db->createCommand("SELECT from_station.station_name as from_station_name ,to_station.station_name as to_station_name,
       trip_id, price, departure_date, departure_time, arrival_date, arrival_time,
       seats_count, from_city.city_name as from_city_name,
       to_city.city_name as to_city_name,
       from_station.station_address as from_station_address,
       to_station.station_address as to_station_address
    FROM trips LEFT JOIN stations from_station ON
    trips.from_station_code = from_station.station_code
    LEFT JOIN stations to_station ON trips.to_station_code = to_station.station_code
    LEFT JOIN cities from_city ON from_station.city_code = from_city.city_code
    LEFT JOIN cities to_city ON to_station.city_code = to_city.city_code
    WHERE from_station_code = {$station_code}")->queryAll();
        return $this->render('schedules', [
           'schedules' => $schedules
        ]);
    }

    /*
     * Метод получения информации по рейсу
     */
    public function actionTrip(){
        $trip_id = Yii::$app->request->get('trip_id');
        $trip_info = Yii::$app->db->createCommand("SELECT from_station.station_name as from_station_name ,to_station.station_name as to_station_name,
       trip_id, price, departure_date, departure_time, arrival_date, arrival_time,
       seats_count, from_city.city_name as from_city_name,
       to_city.city_name as to_city_name,
       from_station.station_address as from_station_address,
       to_station.station_address as to_station_address,
       driver_last_name, driver_first_name, driver_category,
       bus.bus_number, bus_brand, bus_model
    FROM trips LEFT JOIN stations from_station ON
    trips.from_station_code = from_station.station_code
    LEFT JOIN stations to_station ON trips.to_station_code = to_station.station_code
    LEFT JOIN cities from_city ON from_station.city_code = from_city.city_code
    LEFT JOIN cities to_city ON to_station.city_code = to_city.city_code
    LEFT JOIN bus on trips.bus_number = bus.bus_number
    LEFT JOIN drivers on trips.bus_number = drivers.bus_number
    WHERE trip_id = {$trip_id}
    ")->queryAll();
        $departure_date = strftime('%d-%m-%Y',strtotime($trip_info[0]['departure_date']));
        $arrival_date = strftime('%d-%m-%Y',strtotime($trip_info[0]['arrival_date']));
        $departure_time = strftime('%H:%M',strtotime($trip_info[0]['departure_time']));
        $arrival_time = strftime('%H:%M',strtotime($trip_info[0]['arrival_time']));
       return $this->render('trip', [
           'trip_info' => $trip_info,
           'trip_id' => $trip_id,
           'departure_date' => $departure_date,
           'departure_time' => $departure_time,
           'arrival_date' => $arrival_date,
           'arrival_time' => $arrival_time
       ]);
    }

    public function actionSearchTrip(){
        $schedules = null;
        if(Yii::$app->request->post()){
            $from_city = Yii::$app->request->post('from_city');
            $to_city = Yii::$app->request->post('to_city');
            $date = Yii::$app->request->post('date');
            $date = strftime('%Y-%m-%d', strtotime($date));
            $schedules = Yii::$app->db->createCommand("SELECT from_station.station_name as from_station_name ,to_station.station_name as to_station_name,
            trip_id, price, departure_date, departure_time, arrival_date, arrival_time,
            seats_count, from_city.city_name as from_city_name,
            to_city.city_name as to_city_name,
            from_station.station_address as from_station_address,
            to_station.station_address as to_station_address
            FROM trips LEFT JOIN stations from_station ON
            trips.from_station_code = from_station.station_code
            LEFT JOIN stations to_station ON trips.to_station_code = to_station.station_code
            LEFT JOIN cities from_city ON from_station.city_code = from_city.city_code
            LEFT JOIN cities to_city ON to_station.city_code = to_city.city_code
            WHERE from_city.city_name = '{$from_city}' AND to_city.city_name = '{$to_city}' AND departure_date = '{$date}'")->queryAll();
        }
        return $this->render('search-trip',[
            'schedules' => $schedules
        ]);
    }

    public function actionRegistration(){
        if(Yii::$app->request->post()){
            $user_login = Yii::$app->request->post('user_login');
            $find_user = Yii::$app->db->createCommand("SELECT * FROM users WHERE user_login = '{$user_login}'")->queryOne();
            if($find_user != false){
                Yii::$app->session->setFlash('user_exists');
                return $this->render('registration');
            }
            $user_last_name = Yii::$app->request->post('user_last_name');
            $user_first_name = Yii::$app->request->post('user_first_name');
            $user_middle_name = Yii::$app->request->post('user_middle_name');
            $user_year = strftime('%Y-%m-%d',strtotime(Yii::$app->request->post('date')));
            $user_hash = md5($user_login . Yii::$app->request->post('user_password'));
            try {
                Yii::$app->db->createCommand(
                    "
                INSERT INTO users (user_login, user_hash, user_last_name, user_first_name, user_middle_name, user_year)
                VALUES 
                ('{$user_login}', '{$user_hash}', '{$user_last_name}', '{$user_first_name}', '{$user_middle_name}', '{$user_year}')
               "
                )->queryOne();
            } catch (\Exception $e){
                Yii::$app->session->setFlash('invalid_data');
                return $this->render('registration');
            }
            $this->redirect('/site/login');
        }
        return $this->render('registration');
    }

    public function actionBuy(){
        $trip_id = Yii::$app->request->get('trip_id');
        $user_id = Yii::$app->user->identity->user_id;
        try{
            Yii::$app->db->createCommand("
            INSERT INTO tickets (trip_id, user_id) VALUES ({$trip_id} , {$user_id})
            ")->queryOne();
            Yii::$app->session->setFlash('buying_success');
        } catch (\Exception $e){
            Yii::$app->session->setFlash('buying_error');
        } finally {
            $this->redirect('/site/my-tickets');
        }
    }

    public function actionMyTickets(){
        $user_id = Yii::$app->user->identity->user_id;
        $tickets = Yii::$app->db->createCommand("
            SELECT from_station.station_name as from_station_name ,to_station.station_name as to_station_name,
       tickets.trip_id, price, departure_date, departure_time, arrival_date, arrival_time,
       seats_count, from_city.city_name as from_city_name,
       to_city.city_name as to_city_name,
       from_station.station_address as from_station_address,
       to_station.station_address as to_station_address
      FROM tickets LEFT JOIN trips ON tickets.trip_id = trips.trip_id
      LEFT JOIN stations from_station on trips.from_station_code = from_station.station_code
      LEFT JOIN cities from_city on from_station.city_code = from_city.city_code
      LEFT JOIN stations to_station on trips.from_station_code = to_station.station_code
      LEFT JOIN cities to_city on to_station.city_code = to_city.city_code
      WHERE tickets.user_id = {$user_id}; 
            ")->queryAll();
        return $this->render('my_tickets',['tickets' => $tickets]);
    }

}
