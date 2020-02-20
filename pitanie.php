<?php
require 'menu.php';
require 'default.php';
require 'header.php';

if (!$_POST['flat']) {
    if ($_COOKIE['flat']){$flat = $_COOKIE['flat'];}
    else {$flat = 1;}
} else {$flat = $_POST['flat'];}

if (!$_POST['house']) {
    if ($_COOKIE['house']) {$house = $_COOKIE['house'];}
    } else {$house = $_POST['house'];}
if ($flat == "Все") {$flat = 1;}
if ($house == "Все адреса") {$house = 'Ленина 59';}

//снятие текущих показаний
function send($msg) {
   $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
   
    $len = strlen($msg);

    socket_sendto($sock, $msg, $len, 0, '192.168.0.120', 11000);

    if (false !== ($bytes = socket_read($sock, 2048))) {
       $bytes0 = mb_convert_encoding($bytes,"UTF-8","windows-1251");
       $result = explode(" ",$bytes0);
    } else {
    echo "Dont can read becouse " . socket_strerror(socket_last_error($sock)) . "\n";
    }
    echo "<br>";
    socket_close($sock);
    return $result;
}

//включение выключение питания
function onOff($msg, $onOff){
   $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
   
    $len = strlen($msg);
    socket_sendto($sock, $msg, $len, 0, '192.168.0.120', 11000); 
    if (false !== ($bytes = socket_read($sock, 2048))) {
       $bytes0 = mb_convert_encoding($bytes,"UTF-8","windows-1251");
       $result = explode(" ",$bytes0);
    } else {
        $a = socket_strerror(socket_last_error($sock));
        $a0 = mb_convert_encoding($a,"UTF-8","windows-1251");
    echo "Dont can read becouse " . $a0 . "\n".$msg;
    }
    echo "<br>";
    socket_close($sock);
    return $result;
}

//обработка результата
function format($msg){
  if ($msg !== "null") {
  $length = strlen($msg)-2;
  if ($length == 0) {$answer = "0,".$msg;}
  elseif ($length < 0) {$answer = "0,0".$msg;}
  else {
  $answer = substr($msg,0,$length).",".substr($msg,-2);
  $answer = ltrim($answer, "0");}}
  else {$answer = "неисправен";}
  return $answer;
}
function format2($msg){
  if ($msg !== "null") {
  $length = strlen($msg)-2;
  if ($length == 0) {$answer = "0,".$msg;}
  elseif ($length < 0) {$answer = "0,0".$msg;}
  else {
  $answer = substr($msg,0,$length).",".substr($msg,-2);
  }}
  else {$answer = "неисправен";}
  return $answer;
}


echo "<form action=\"pitanie.php\" method=\"post\" style=\"position:absolute; top:25px; left:60px; text-align: right;\">
 <p style=\"position:absolute; left:150px; top:1px; text-align: center;\">Дом <select name=\"house\">
                <option>$house</option>
		<option>Ленина 59</option>
		<option>Ленина 59-2</option>
		<option>Ленина 61</option>
		<option>Ленина 63</option>
                <option>Ленина 63-2</option>
                <option>Ленина 65</option>
                <option>Ленина 65-2</option>
                <option>Ленина 65-3</option>
                <option>Ленина 67</option>
                <option>Ленина 67-1</option>
                <option>Ленина 69</option>
                <option>Ленина 69-2</option>
                <option>Ленина 69-3</option>
                <option>Ленина 71</option>
                <option>Ленина 71-2</option>
                <option>Ленина 73</option>
                <option>Ленина 73-2</option>
                <option>Ленина 75</option>
                <option>Ленина 77</option>
                <option>Ленина 77-2</option>
                <option>Ленина 79</option>
                <option>Всесвятская 2</option>
                <option>Всесвятская 4</option>
                <option>Всесвятская 4-2</option>
                <option>Всесвятская 4-3</option>
                <option>Всесвятская 6</option>
                <option>Всесвятская 8</option>
                <option>Батова 2</option>
                <option>Батова 4</option>
                <option>Батова 6</option>
</select>
 
 № квартиры <input type=\"text\" name=\"flat\" value=$flat size=\"10px\"></p>
 <p style=\"position:absolute; left:300px; top:1px; text-align: center;\"><input type=\"image\" src=\"/images/find.png\" alt=\"Найти\"></p>
 </form>"
 ."<form action=\"pitanie.php\" method=\"post\">
  <p style=\"position:absolute; left:40px; top:25px; text-align: center;\">
  <input type=\"hidden\" name=\"table\" value=\"1\">
 <input type=\"image\" src=\"/images/table.png\" alt=\"Журнал отключения\" name=\"table\"> </p></form>
 <form action=\"pitanie.php\" method=\"post\">
  <p style=\"position:absolute; left:120px; top:25px; text-align: center;\">
  <input type=\"hidden\" name=\"powerJurnal\" value=\"1\">
 <input type=\"image\" src=\"/images/powerJurnal.png\" alt=\"Список отключенных квартир\" name=\"powerJurnal\"></p> </form>";


if (!$conn) {
  echo "Нет соединения с базой.\n";
  exit;
}

require "houses.php";

//текущие показания на электросчетчике
if (!empty($_POST['powerOn']) OR !empty($_POST['powerOff']) OR !empty($_POST['house'])){
  $SN0=explode("_",$sensors[8]);
  $SN=$SN0[1];
  $Electro = "$ipAddres $rsNum 0 $SN m203read ks";
  $resulted = send($Electro);
  $curentEl0 = format($resulted[2]);
$curentEl1 = format($resulted[3]);
$KVT = format2($resulted[4]);

//информация о собственнике
    $Owner_data = pg_query($conn, "SELECT fio, dolg, phone, date FROM owners1c WHERE kv='$flat' AND adress='$house'");
    if (!$Owner_data) {
        $Name = "Нет данных";
        $Telefon = "Нет данных";
        $Money = "Нет данных";
        $time = "Нет данных";
    } else {
    $row2 = pg_fetch_row($Owner_data);
    $time = explode(" ",$row2[3]);
    $Name = $row2[0];
    $Telefon = $row2[2];
    $Money = $row2[1].' на '.$time[0];
    $Money0 = $row2[1];
    }
// вывод    
    echo "<form method=\"post\" style=\"position:absolute; top:295px; left:25%; text-align: left; line-height: 23px\">
    <p> <img src=\"/images/sob.png\" width=\"120\" alt=\"СОБСТВЕННИК\"> </p>
    <p> <img src=\"/images/tel.png\" width=\"120\" alt=\"ТЕЛЕФОН\"></p>
    <p> <img src=\"/images/money.png\" width=\"120\" alt=\"НАЧИСЛЕНО\"></p>
    </form>";

echo "<form method=\"post\" style=\"position:absolute; top:300px; left:37%; text-align: left; font-size: 20px; font-weight: 600;\">
    <p> $Name</p>
    <p> $Telefon</p>
    <p> $Money</p>
    </form>";

echo "<div style=\"width:96%; height:80%; overflow:auto; position: absolute; left:2%; top: 140px;\">
<table bgcolor=white border=\"1\" table-layout: fixed; style=\"border-collapse: collapse;\">
       <caption>Результаты поиска<br></caption>
<tr style=\"font-size: 12px; text-align: center;\">
<td style=\"width:5%;font-size: 12px;text-align: center;\">Дата</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">Номер счетчика</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">Показания 1</td>     
<td style=\"width:5%;font-size: 12px;text-align: center;\">Показания 2</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">Нагрузка</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">Состояние</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">Выключить</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">Включить</td>
</tr>
<tr style=\"font-size: 12px; text-align: center;\">
<td style=\"width:5%;font-size: 12px;text-align: center;\">$resulted[0].$resulted[1]</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">$SN</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">$curentEl0</td>     
<td style=\"width:5%;font-size: 12px;text-align: center;\">$curentEl1</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">$KVT</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">$resulted[5]</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">";
//кнопка выкл
$onOff = $house."_".$flat;
echo "<form action=\"Off.html\" method = post>"
. "<input type=\"hidden\" name=\"FIO\" value=\"$Name\">"
. "<input type=\"hidden\" name=\"dolg\" value=\"$Money0\">"
. "<button name = \"off\" value=\"$onOff\"><img src=\"/images/power_off.png\" alt=\"OK\">" 
. "</form>";

echo "</td><td style=\"width:5%;font-size: 12px;text-align: center;\">";
//кнопка вкл
echo "<form action=\"On.html\" method = post>"
. "<button name = \"on\" value=\"$onOff\"><img src=\"/images/power.png\" alt=\"OK\">" 
. "</form>";

echo "</td>
</table>
</div>";
}


//Управление питанием 
if(!empty($_POST['powerOn'])){
    $password = $_POST['password'];
    if ($password == "2741001"){    
    $onOff = "00";
    $SN0=explode("_",$sensors[8]);
  $SN=$SN0[1];
  $Electro = "$ipAddres $rsNum $onOff $SN m203power ks";
  //echo "<br>$Electro";
  //$test = onOff($Electro, $onOff);
  //print_r($test);
  
  $autor = $_POST['worker'];
  $action = $_POST['vkl'];
  $coment = $_POST['coment'];
    
  $a = pg_query($conn, "DELETE FROM offlist WHERE 
      addres = '$house' AND kv = '$flat'");
    
  $b = pg_query($conn, "INSERT INTO offjurnal VALUES "
          . "('$date', '$house', '$flat', '$action', '$coment', '$autor')");
    }
    else {
        require 'alert.js';    
  }
}
  
if(!empty($_POST['powerOff'])){
    $password = $_POST['password'];
    if ($password == "2741001"){
  $onOff = "AA";
  $SN0=explode("_",$sensors[8]);
  $SN=$SN0[1];
  $Electro = "$ipAddres $rsNum $onOff $SN m203power ks";
  //echo "<br> $Electro";
  //$test = onOff($Electro, $onOff);
  //print_r($test);
  
  $autor = $_POST['worker'];
  $money = $_POST['money'];
  $controler = $_POST['kontroler'];
  $fio = $_POST['FIO'];
  $action = $_POST['vkl'];
  $coment = $_POST['coment'];
  
  $a = pg_query($conn, "INSERT INTO offlist VALUES "
          . "('$date', '$house', '$flat', '$autor', '$fio', '$money', '$dateInter', '$controler')");
  
  $b = pg_query($conn, "INSERT INTO offjurnal VALUES "
          . "('$date', '$house', '$flat', '$action', '$coment', '$autor')");
  /*echo " pg_query($conn, \"INSERT INTO offjurnal VALUES 
          ('$date', '$house', '$flat', '$action', '$coment', '$autor')\")";*/
  }
    else {
        require 'alert.js';    
  }
}

//журнал  отключения
if(!empty($_POST['table'])){
   echo "<div style=\"width:96%; height:80%; overflow:auto; position: absolute; left:2%; top: 140px;\">
<table bgcolor=white border=\"1\" table-layout: fixed; style=\"border-collapse: collapse;\">
       <caption>Журнал отключения</caption>
<tr style=\"font-size: 12px; text-align: center;\">
<td style=\"width:5%;font-size: 12px;text-align: center;\">Дата отключения</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">Адрес</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">Квартира</td>     
<td style=\"width:5%;font-size: 12px;text-align: center;\">Действие</td>
<td style=\"width:15%;font-size: 12px;text-align: center;\">Причина</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">Кто отключил</td>
</tr>";
$powerJurnal = pg_query($conn, "SELECT * FROM offjurnal ORDER BY date DESC");
while (($row = pg_fetch_row($powerJurnal))) {
    if ($row[3] == "Включена") {$color = $colorGood;}
    else {$color = $colorBad;}
     echo "<tr>
        <td>$row[0]</td>
        <td>$row[1]</td> <td>$row[2]</td>
        <td style=\"background-color:$color;\">$row[3]</td> <td>$row[4]</td>
        <td>$row[5]</td> </tr>";
            }
echo "</table>
</div>";
}

//Список отключенных квартир
if(!empty($_POST['powerJurnal']) OR (empty($_POST['table'])&& empty($_POST['house']))){
 echo "<div style=\"width:96%; height:80%; overflow:auto; position: absolute; left:2%; top: 140px;\">
<table bgcolor=white border=\"1\" table-layout: fixed; style=\"border-collapse: collapse;\">
<caption style=\"font-size:20; color:white; font-weight:bold; \">Список отключенных квартир</caption>
<tr style=\"font-size: 12px; text-align: center;\">
<td style=\"width:5%;font-size: 12px;text-align: center;\">Дата отключения</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">Адрес</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">Квартира</td> 
<td style=\"width:5%;font-size: 12px;text-align: center;\">Кто отключил</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">ФИО</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">Долг</td>
<td style=\"width:5%;font-size: 12px;text-align: center;\">Статус контролера</td>
<td style=\"width:3%;font-size: 1px;text-align: center;\">включить</td>
</tr>";
$Offlist = pg_query($conn, "SELECT * FROM offlist ORDER BY date DESC");
 while (($row = pg_fetch_row($Offlist))) {
     $onOff = $row[1]."-".$row[2];
     echo "</td>
         <td>$row[6]</td>
        <td>$row[1]</td> <td>$row[2]</td>
        <td>$row[3]</td> <td>$row[4]</td>
        <td>$row[5]</td> <td>$row[7]</td>
        <td>";
     echo "<form action=\"On.html\" method = post>"
. "<button name = \"on\" value=\"$onOff\"><img src=\"/images/power.png\" alt=\"OK\">" 
. "</form>";
     echo "</td> </tr>";
 }
echo "</table></div>";
}

echo "</body>";