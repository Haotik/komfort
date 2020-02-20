<?php

$house = 'Ленина 59';
$kv = 1;
//подклчюение к БД
$connect_string = "host=192.168.0.120 port=5432 dbname=archives user=postgres password=postgres";
$conn = pg_connect($connect_string); 
//установка кодировки между сайтом и базой данных
pg_set_client_encoding($conn, "UNICODE");
//значения 
$f = array(0,0,0,0,0,0);
//текущая дата
date_default_timezone_set('Europe/Moscow');
$date = date('Y-m-d H:i:s');
$dateFilter = date('Y-m-d');
$date0 = "2019-08-10";

//дата для ввода показаний 

$arr = ['января','февраля','марта','апреля','мая','июня','июля',
  'августа', 'сентября', 'октября','ноября', 'декабря'];
$month = date('n')-1;

$dateInter = date('j')." ".$arr[$month]." ".date("Y")." г.";

//даты
$ff = array("0","0","0","0","0","0");
//состояние счетчика
$state = array('Исправен','Исправен','Исправен','Исправен','Исправен','Исправен');
//собственник
$Name = "Нет ответа от базы";
$Telefon = "Нет ответа от базы";
$Money = "Нет ответа от базы";
// цвета фона состояния датчиков
$colorGood = "#00FF00";
$colorWarning = "#FFFF00";
$colorBad = "#FF0000";
$color = array ($colorGood, $colorGood, $colorGood, $colorGood, $colorGood, $colorGood);
//запись показаний в базу
$operator = "";
$defis="";
$osnovanie="Телефон";
$hostname = gethostname();

if ($ip == "192.168.0.47") {
    $hostname = "Диспетчер";
}

$ip = $_SERVER['REMOTE_ADDR'];
if ($ip == "192.168.0.44" or $ip == "127.0.0.1" or $ip == "192.168.0.30 ") {
  $osnovanie= "Инвентаризация"; 
  $operator = "Корехов А.В.";
  $hostname = "Бухгалтерия";
}
if ($ip == "192.168.0.124") {
  $osnovanie= "Сайт"; 
  $operator = "Корехов А.В.";
}
if ($ip == "192.168.0.40") {
  $osnovanie="Телефон"; 
  $operator = "Жиленкова М.";
  $hostname = "Бухгалтерия";
}
if ($ip == "192.168.0.101" or $ip == "192.168.0.102") {
  $osnovanie="Сайт"; 
  $operator = "Жиленкова М.";
  $hostname = "Бухгалтерия";
}

if(isset( $_POST['osnovanie'])){$osnovanie=$_POST['osnovanie'];}
$resulted = array();
$otdel = "Все заявки";
$status = "Все заявки";
$arhivZayavok = array();
$numberOfRequest = 0;
$file  = 'curent.txt';
$inFile = array(array ('Дата','Дом','Квартира','ХВС','ГВС','ХВС2','ГВС2','Т1','Т2'));

//режим проверки
$check1 ='';
$check2 = '';

//переворачиваем дату
function Reload($date){
    $a = explode(" ",$date);
    $b = explode("-",$a[0]);
    $date = $b[2]."-".$b[1]."-".$b[0]." ".$a[1];
    return $date;
}
//сортировка массива
function cmp1($a, $b)
{	
    return strcmp($a[1], $b[1]);
}

function cmp2($a, $b)
{
    if($b[2] == "Квартира") return 1;
	if ($a[1] == $b[1]) {
    return ($a[2] < $b[2]) ? -1 : 1;
	} else return 0;
}

function cmp3($a,$b){
    return ($a[0][5] < $b[0][5]) ? -1 : 1;
}

function test() {
	$params = func_get_args();
	echo "<pre class='test'>";
	foreach ($params as $value) {
		var_dump($value);
	}
	echo "</pre>";
	//die;
}

function houseRename($house){
    switch ($house) {
        case "307170, Курская обл, Железногорск г, Ленина ул,  № 73, Корпус 2":
            $houseName = "Ленина 73-2";
            break;
        case "307176, Курская обл, Железногорск г, Ленина ул,  № 59":
            $houseName = "Ленина 59";
            break;
        case "РОССИЯ, 307176, Курская обл, Железногорск г, Ленина, Дом № 75":
            $houseName = "Ленина 75";
            break;
        case "307170, Курская обл, Железногорск г, Ленина ул, Дом № 77, Корпус 2":
            $houseName = "Ленина 77-2";
            break;
        case "307170, Курская обл, Железногорск г, Ленина ул, Дом № 79":
            $houseName = "Ленина 79";
            break;
        case "307176, Курская обл, Железногорск г, Ленина ул,  № 59, корпус 2":
            $houseName = "Ленина 59-2";
            break;
        case "307176, Курская обл, Железногорск г, Ленина ул,  № 61":
            $houseName = "Ленина 61";
            break;
        case "307176, Курская обл, Железногорск г, Ленина ул,  № 63":
            $houseName = "Ленина 63";
            break;
        case "307176, Курская обл, Железногорск г, Ленина ул,  № 63, корпус 2":
            $houseName = "Ленина 63-2";
            break;
        case "307176, Курская обл, Железногорск г, Ленина ул,  № 67":
            $houseName = "Ленина 67";
            break;
        case "307176, Курская обл, Железногорск г, Ленина ул,  № 67, корпус 1":
            $houseName = "Ленина 67-1";
            break;
        case "307176, Курская обл, Железногорск г, Ленина ул,  № 69":
            $houseName = "Ленина 69";
            break;
        case "307176, Курская обл, Железногорск г, Ленина ул,  № 69, корпус 2":
            $houseName = "Ленина 69-2";
            break;
        case "307176, Курская обл, Железногорск г, Ленина ул,  № 69, корпус 3":
            $houseName = "Ленина 69-3";
            break;
        case "307176, Курская обл, Железногорск г, Ленина ул,  № 71":
            $houseName = "Ленина 71";
            break;
        case "307176, Курская обл, Железногорск г, Ленина ул,  № 73":
            $houseName = "Ленина 73";
            break;
        case "307176, Курская обл, Железногорск г, Ленина ул, Дом № 77":
            $houseName = "Ленина 77";
            break;
        case "307179, Курская обл, Железногорск г, Батова ул,  № 2":
            $houseName = "Батова 2";
            break;
        case "307179, Курская обл, Железногорск г, Батова ул, дом № 4":
            $houseName = "Батова 4";
            break;
        case "307179, Курская обл, Железногорск г, Всесвятская ул,  № 2":
            $houseName = "Всесвятская 2";
            break;
        case "307179, Курская обл, Железногорск г, Всесвятская ул,  № 4":
            $houseName = "Всесвятская 4";
            break;
        case "307179, Курская обл, Железногорск г, Всесвятская ул,  № 4, корпус 2":
            $houseName = "Всесвятская 4-2";
            break;
        case "307179, Курская обл, Железногорск г, Всесвятская ул,  № 4, корпус 3":
            $houseName = "Всесвятская 4-3";
            break;
        case "307179, Курская обл, Железногорск г, Всесвятская ул,  № 6":
            $houseName = "Всесвятская 6";
            break;
        case "307179, Курская обл, Железногорск г, Всесвятская ул,  № 8":
            $houseName = "Всесвятская 8";
            break;
        case "307179, Курская обл, Железногорск г, Ленина ул,  № 65":
            $houseName = "Ленина 65";
            break;
        case "307179, Курская обл, Железногорск г, Ленина ул,  № 65, корпус 2":
            $houseName = "Ленина 65-2";
            break;
        case "307179, Курская обл, Железногорск г, Ленина ул,  № 65, корпус 3":
            $houseName = "Ленина 65-3";
            break;
        case "Курская обл, Железногорск г, Батова ул,  № 6":
            $houseName = "Батова 6";
            break;
        case "РОССИЯ, 307176, Курская обл, Железногорск г, Ленина, Дом № 75":
            $houseName = "Ленина 75";
            break;
        default: $houseName = $house;
        }
        return $houseName;
}