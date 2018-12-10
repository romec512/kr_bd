CREATE TABLE public.cities
(
    city_code serial PRIMARY KEY NOT NULL,
    city_name varchar(20) NOT NULL,
    region_name varchar(20),
    population int,
    country_name varchar(20) NOT NULL
);
CREATE UNIQUE INDEX cities_city_code_uindex ON public.cities (city_code);

--таблица stations
CREATE TABLE public.stations
(
    station_code serial PRIMARY KEY NOT NULL,
    station_name varchar(20) NOT NULL,
    station_address varchar(50) NOT NULL,
    city_code int NOT NULL,
    CONSTRAINT stations_cities_city_code_fk FOREIGN KEY (city_code) REFERENCES public.cities (city_code)
);
CREATE UNIQUE INDEX stations_station_code_uindex ON public.stations (station_code);

CREATE TABLE public.trips
(
    trip_id serial PRIMARY KEY NOT NULL,
    from_station_code int NOT NULL,
    to_station_code int NOT NULL,
    departure_time time NOT NULL,
    arrival_time time NOT NULL,
    departure_date date NOT NULL,
    arrival_date date,
    seats_count int NOT NULL,
    price int NOT NULL,
    bus_number int NOT NULL,
    CONSTRAINT from_station_code__fk FOREIGN KEY (from_station_code) REFERENCES public.stations (station_code),
    CONSTRAINT to_station_code__fk FOREIGN KEY (to_station_code) REFERENCES public.stations (station_code)
);
CREATE UNIQUE INDEX trips_trip_id_uindex ON public.trips (trip_id);

CREATE TABLE public.bus
(
    bus_number varchar(6) PRIMARY KEY NOT NULL,
    bus_brand varchar(15) NOT NULL,
    bus_model varchar(15) NOT NULL
);
CREATE UNIQUE INDEX bus_bus_number_uindex ON public.bus (bus_number);

CREATE TABLE public.drivers
(
    driver_id serial PRIMARY KEY NOT NULL,
    driver_last_name varchar(15) NOT NULL,
    driver_first_name varchar(15) NOT NULL,
    driver_middle_name varchar(15) NOT NULL,
    driver_category varchar(2) NOT NULL,
    bus_number int NOT NULL
);
CREATE UNIQUE INDEX drivers_driver_id_uindex ON public.drivers (driver_id);

CREATE TABLE public." users"
(
    user_id serial PRIMARY KEY NOT NULL,
    user_login varchar(15) NOT NULL,
    user_hash varchar(32) NOT NULL,
    user_last_name varchar(15) NOT NULL,
    user_first_name varchar(15) NOT NULL,
    user_middle_name varchar(15) NOT NULL,
    user_year date
);
CREATE UNIQUE INDEX " users_user_id_uindex" ON public." users" (user_id);
CREATE UNIQUE INDEX " users_user_login_uindex" ON public." users" (user_login);