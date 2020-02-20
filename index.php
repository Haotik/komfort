<?php 
if (!$_POST['flat']) {
    if ($_COOKIE['flat']){$flat = $_COOKIE['flat'];}
    else {$flat = 1;}
} else {$flat = $_POST['flat'];}
require 'default.php';
if (!$_POST['house']) {
    if ($_COOKIE['house']) {$house = $_COOKIE['house'];}
    } else {$house = $_POST['house'];}
if ($flat == "Все") {$flat = 1;}
if ($house == "Все адреса") {$house = 'Ленина 59';}

$regim = $_POST['check']; 
if ($regim == "apply") {$check2 = 'checked';
} else {$check1 = 'checked';}

if ($flat == "73а") {
	$flat = "73А";
}

setcookie("flat", $flat);
setcookie("house", $house);
require 'menu.php';
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
//форматирование выходных данных
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

require 'header.php';

echo "<form action=\"index.php\" method=\"post\" style=\"position:absolute; top:25px; left:60px; text-align: right;\">
 <p>Дом <select name=\"house\">
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
</select></p>
 
 <p style=\"margin-bottom: 10px;\">№ квартиры <input type=\"text\" name=\"flat\" value=$flat size=\"10px\"></p>
<p style=\"margin-top: 10px;\">
<label><input name = \"check\" type = \"radio\" value = \"norm\" $check1>обычный режим </label> <br>
<label><input name = \"check\" type = \"radio\" value = \"apply\" $check2>режим проверки </label>
</p>
<p style=\"position:absolute; left:240px; top:1px; text-align: center;\">
<input type=\"image\" src=\"/images/find.png\" alt=\"Найти\">
</p>

</form>";
      
if (!$conn) {
  echo "Нет соединения с базой.\n";
  exit;
}

require "houses.php";

$i = 0;
$n = 8;
$d = 4; //количество счетчиков
$state_stat=0;

//данные на бтс из бд 
if (!empty($_POST['house'])){
    $d=0;
for ($i; $i<$n; $i++) {
   $BTS = " '$sensors[$i]'";
   $l=$i+1;
   $d = ++$d;
   if ($sensors[$i] == "0") {$d = --$d;}
   $BTS_data = pg_query($conn, "SELECT v1i, ts FROM archdata_bts2 WHERE devid = $BTS ORDER BY ts DESC LIMIT 1");
        if (!$BTS_data) {
        echo "Произошла ошибка.\n";
        exit;
        }
    $k = 0; //берем только 1 строку
    while (($row = pg_fetch_row($BTS_data)) && ($k<1)) {
        $a = explode(" ",$row[1]);  
        $b = explode(".",$row[0]);
    if ((count($b) > 1)) {
        $c = strval ($b[1]);
        $c = substr($c, 0,2);}
    else {$c = "00";}
  $k++;
  }
  $f[$d-1] = $b[0].".".$c;
  $ff[$d-1] = $a[0];
  $i++;
  $state_stat ++;
}
//данные электро счетчика
$Electro_data = pg_query($conn,"SELECT e1i, e2i, ts FROM archdata_mrc2 WHERE devid='$sensors[8]' ORDER BY ts DESC LIMIT 1");
$k=0;
$row2 = pg_fetch_row($Electro_data);
if ($row2){
        $e1i = round($row2[0], 2);  
        $e2i = round($row2[1], 2);
        $ts = $row2[2];
        $f[4] = $e1i;
        $f[5] = $e2i;
$ff[4] = $ts;
}
}

//Запись показаний 
if (!empty($_POST["BTS_write"])) {
    $flat = $_POST['flat'];
$house = $_POST['house'];
$fff[1]=$_POST['write0'];
$fff[2]=$_POST['write1'];
$fff[3]=$_POST['write2'];
$fff[4]=$_POST['write3'];
$fff[5]=$_POST['write4'];
$fff[6]=$_POST['write5'];
$fff[7]=$_POST['write6'];
$fff[8]=$_POST['write7'];
$fff[9]=$_POST['write8'];
$autor=$_SERVER['REMOTE_ADDR']."_".$hostname."_".$_POST['write8'];
$osnovanie = $_POST['osnovanie'];
$comment = $_POST['osnovanie']." от ".$dateInter." :".$_POST['write7']." ".$_POST['write6'];
$fff[1] = (int)$fff[1];
$fff[2] = (int)$fff[2];
$fff[3] = (int)$fff[3];
$fff[4] = (int)$fff[4];

// проверка что вообще что то введено 
$stopBTS = $fff[1] + $fff[2] + $fff[3] + $fff[4];
$stopElectro = $fff[5] + $fff[6];
if (($stopBTS == 0) && ($stopElectro == 0) ) {echo "Внесите данные";}
elseif (($stopBTS == 0) && ($stopElectro !== 0)) {
    //преобразование числа для записи в бд
$fff[1] = format($fff[1]);
if ($fff[1] == "0,00"){$fff[1]="-";}
$fff[2] = format($fff[2]);
if ($fff[2] == "0,00"){$fff[2]="-";}
$fff[3] = format($fff[3]);
if ($fff[3] == "0,00"){$fff[3]="-";}
$fff[4] = format($fff[4]);
if ($fff[4] == "0,00"){$fff[4]="-";}

//ВНИМАНИЕ для записи в бд нужно привести число к виду х,у иначе пишется х.00
$pg = pg_query($conn,"INSERT INTO write_journal VALUES ('$date','$house','$flat', '$fff[1]','$fff[2]','$fff[3]','$fff[4]','$autor','$comment','$fff[5]','$fff[6]')");
}
else {    
//в счетчик ВНИМАНИЕ в отличии от чтения где №канала = канал *4 при записи № канала идет без изменений
$count=count($chanals);
$e=1;
 for($k=1;$k<$count;$k++){
     if($fff[$e] == "0") {$e++; $k++; continue;}
     else{
        $nBTS = $chanals[$k];
        $c=$k-1;
        $writeBTS = "$ipAddres $nBTS $chanals[$c] $fff[$e] write ks";
		$send = send($writeBTS);
        //print_r ($send);
		//print_r ($writeBTS);
        $e++;
     $k++;}
 }
//преобразование числа для записи в бд
$fff[1] = format($fff[1]);
if ($fff[1] == "0,00"){$fff[1]="-";}
$fff[2] = format($fff[2]);
if ($fff[2] == "0,00"){$fff[2]="-";}
$fff[3] = format($fff[3]);
if ($fff[3] == "0,00"){$fff[3]="-";}
$fff[4] = format($fff[4]);
if ($fff[4] == "0,00"){$fff[4]="-";}

//ВНИМАНИЕ для записи в бд нужно привести число к виду х,у иначе пишется х.00
$pg = pg_query($conn,"INSERT INTO write_journal VALUES ('$date','$house','$flat', '$fff[1]','$fff[2]','$fff[3]','$fff[4]','$autor','$comment','$fff[5]','$fff[6]')");
//echo "pg_query($conn,\"INSERT INTO write_journal VALUES ('$date','$house','$flat', '$fff[1]','$fff[2]','$fff[3]','$fff[4]','$autor','$comment','$fff[5]','$fff[6]')\")<br>";
    }        
}

//текущие показания на счетчике
if (!empty($_POST['house'])){
 $count=count($chanals);
 for($k=1;$k<$count;$k++){
        $nBTS = $chanals[$k];
        $c=$k-1;
        $chanals0 = $chanals[$c]*4;
        $BTS = "$ipAddres $nBTS $chanals0 0 read ks";
        $resulted[] = send($BTS);
        $k++;
    }
  $SN0=explode("_",$sensors[8]);
  $SN=$SN0[1];
  //$Electro = "$ipAddres $rsNum 0 $SN m203read ks";
  
  //режим проверки  закоментить строку выше снять комент со строки ниже
  if ($regim == 'apply') {   
      $Electro = "$ipAddres rsNum 0 $SN m203read ks";}
      else { $Electro = "$ipAddres $rsNum 0 $SN m203read ks";}
  
$resulted[] = send($Electro);}

$invent0 = $resulted[0][1];
$invent1 = $resulted[1][1];

$curent0 = format($resulted[0][1]);
$curent1 = format($resulted[1][1]);
if ($d == 4) {
$curent3 = format($resulted[3][1]);
$invent3 = $resulted[3][1];
$curent2 = format($resulted[2][1]);
$invent2 = $resulted[2][1];
$curentEl0 = format($resulted[4][2]);
$curentEl1 = format($resulted[4][3]);
$invent4 = $resulted[4][2];
$invent5 = $resulted[4][3];
}
if ($d == 3) {
    $curent3 =0;
    $curent2 = format($resulted[2][1]);
    $invent2 = $resulted[2][1];
    $invent3 = 0;
 $curentEl0 = format($resulted[3][2]);
$curentEl1 = format($resulted[3][3]); 
$invent4 = $resulted[3][2];
$invent5 = $resulted[3][3];
}
if ($d == 2){
    $curent3 = 'неисправен';
    $curent2 = 'неисправен';
    $invent3 = '-';
    $invent2 = '-';
$curentEl0 = format($resulted[2][2]);
$curentEl1 = format($resulted[2][3]);}
$invent4 = $resulted[2][2];
$invent5 = $resulted[2][3];
if ($d == 0){
    $curent0 = "Неисправен";
    $curent1 = "Неисправен";
    $curent2 = "Неисправен";
    $curent3 = "Неисправен";
    $curentEl0 = "Неисправен";
    $curentEl1 = "Неисправен";
}

for ($i=0;$i<$d;$i++) {
if ($resulted[$i][2] == 1) {$state[$i] = "Саботаж"; $color[$i] = $colorBad;}
}
if ($resulted[$d][5] == "Отключен") {
    $state[4] = "Отключен"; $color[4] = $colorWarning;
    $state[5] = "Отключен"; $color[5] = $colorWarning;
} elseif ($resulted[$d][0] == "null") {
   $state[4] = "Неисправен"; $color[4] = $colorBad;
   $state[5] = "Неисправен"; $color[5] = $colorBad; 
} elseif ($resulted[$d][5] == "Включен") {
   $state[4] = "Включен"; $color[4] = $colorGood;
   $state[5] = "Включен"; $color[5] = $colorGood;
}   


//информация о собственнике
if (!empty($_POST['house'])){
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
    }
}

require 'request_button.php';
//выводим формы
require 'BTS_forms.php';

//последние введеные показания
if(!empty($_POST['house'])){
echo "<div style=\"width:80%; overflow:auto; position: absolute; left:5%; top: 650px;\">"
    ."<p style=\"width:45%; text-align: center; font-weight:bold;\">Посление переданные/введеные показания</p>"
. "<table bgcolor=white border=\"1\"; table-layout: fixed; style=\"border-collapse: collapse;\">";
echo "<tr style=\"font-size: 12px; text-align: center;\"> <td style=\"width:\"9%\";\">Дата</td> <td style=\"width:\"9%\";\">Дом</td> "
                . "<td style=\"width:\"9%\"; \">Квартира</td> <td style=\"width:\"9%\";\">ХВС</td> "
                . "<td style=\"width:\"9%\";\">ГВС</td> <td style=\"width:\"9%\";\">ХВС2</td> "
                . "<td style=\"width:\"9%\";\">ГВС2</td> <td style=\"width:\"9%\";\">Т1</td> "
                . "<td style=\"width:\"9%\";\">Т2</td> <td style=\"width:\"9%\";word-break: break-all;\">Кто записал</td> "
                . "<td style=\"width:\"9%\";word-break: break-all;\">На основании</td> </tr>";
$write_j = pg_query($conn, 
        "SELECT * FROM write_journal WHERE ndoma = '$house' AND nkvart='$flat' ORDER BY date DESC LIMIT 5");
 while (($string = pg_fetch_row($write_j))) {
     $string[0] = Reload($string[0]);
        echo "<tr style=\"font-size: 12px; text-align: center;\"> <td style=\"width:\"9%\";\">$string[0]</td> <td style=\"width:\"9%\";\">$string[1]</td>"
                . "<td style=\"width:\"9%\";\">$string[2]</td> <td style=\"width:\"9%\";\">$string[3]</td>"
                . "<td style=\"width:\"9%\";\">$string[4]</td> <td style=\"width:\"9%\";\">$string[5]</td>"
                . "<td style=\"width:\"9%\";\">$string[6]</td> <td style=\"width:\"9%\";\">$string[9]</td>"
                . "<td style=\"width:\"9%\";\">$string[10]</td> <td style=\"width:\"9%\";\">$string[7]</td>"
                . "<td style=\"width:\"9%\";\">$string[8]</td> </tr>";
        }
echo "</table> </div>";}

echo "</body>";
