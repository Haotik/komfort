<?php

require 'default.php';
$house = "Все адреса";
if ($_POST['house']) {$house = $_POST['house'];}
if ($_POST['calendar0']) {$date0 = $_POST['calendar0'];}
if ($_POST['calendar']) {$date = $_POST['calendar'];}
if ($_POST['otdel']) {$otdel = $_POST['otdel'];}
if ($_POST['status']) {$status = $_POST['status'];}

require 'header.php';
echo "<form action=\"zayavki.php\" method=\"post\" style=\"position:absolute; top:20px; left:60px; whidth:700px; text-align: right;\">
 <p style=\"position:absolute; text-align: center;\">Дом <select name=\"house\">
                <option>$house</option>
                <option>Все адреса</option>
                <option>13-й микрорайон</option>
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
<p style=\"position:absolute; left:150px; text-align: center;\">Отдел</p>
<p style=\"text-align: center;position:absolute; top:20px; left:130px;\"> <select name=\"otdel\"> 
<option>$otdel</option>
<option>Все заявки</option>
<option>Сантехники</option>
<option>Электрики</option>
<option>Общедомовой</option>
<option>КИПиА</option>
<option>Программист</option>
<option>РКЦ</option></select></p>
<p style=\"position:absolute; left:270px; text-align: center;\">Статус</p>
<p style=\"position:absolute; top:20px; left:250px; text-align: center;\"> <select name=\"status\"> 
<option>$status</option>
<option>Все заявки</option>
<option>В работе</option>
<option>Выполнено</option>
<option>Не выполнено</option></select></p>
<p style=\"position:absolute; left: -30px; top:55px; width:100px; text-align: center;\">За период 
<input type=\"date\" name=\"calendar0\" value=$date0 style=\"position:absolute; left:90px;\">
<input type=\"date\" name=\"calendar\" value=$dateFilter style=\"position:absolute; left:247px;\">
<p style=\"position:absolute; left:390px; top:10px; text-align: center;\"><input type=\"image\" src=\"/images/find.png\" alt=\"Найти\"></p>
</form>";
      
if (!$conn) {
  echo "Нет соединения с базой.\n";
  exit;
}

require 'menu.php';
echo "<form action=\"newRequest.html\" method=\"post\"\>
    <input type=\"image\" src=\"/images/new-zayavka.png\" alt=\"Новая заявка\"
    style=\"position:absolute; top:47px; left:530px; white-space: pre-line;\">
    </form>";

echo "<div style=\"width:96%; height:80%; overflow:auto; position: absolute; left:2%; top: 140px;\">"
. "<table bgcolor=white border=\"1\" table-layout: fixed; style=\"border-collapse: collapse;>";
echo "<tr style=\"font-size: 12px; text-align: center;\"> "
. "<td style=\"width:5%;font-size: 12px;text-align: center;\">Статус</td> "
. "<td style=\"width:5%;font-size: 12px;text-align: center;\">Закрыть</td> "
. "<td style=\"width:5%;font-size: 12px;text-align: center;\">Просмотреть</td> "     
. "<td style=\"width:5%;font-size: 12px;text-align: center;\">Дата</td> "
. "<td style=\"width:5%;font-size: 12px;text-align: center;\">Дом</td> "
. "<td style=\"width:5%;font-size: 12px;text-align: center;\">Кв</td> "
. "<td style=\"width:5%;font-size: 12px;text-align: center;\">Отдел</td> "
. "<td style=\"width:5%;font-size: 12px;text-align: center;\">Текст заявки</td> "
. "<td style=\"width:5%;font-size: 12px;text-align: center;\">Время</td> "
. "<td style=\"width:5%;word-break: break-all;font-size: 12px;text-align: center;\">Способ подачи</td>"
. "<td style=\"width:5%;word-break: break-all;font-size: 12px;text-align: center;\">Ф.И.О</td> "
. "<td style=\"width:5%;font-size: 12px;text-align: center;\">Телефон</td> "
. "<td style=\"width:5%;font-size: 12px;text-align: center;\">Кто принял</td> </tr>";

/*
if ($date == $date0) {$filter_date = "date >= '$date0' AND date <= '$date 23:59:59'";}
else {$filter_date = "date >= '$date0' AND date <= '$date 23:59:59'";}*/

$filter_date = "date >= '$date0' AND date <= '$date 23:59:59'";

if ($otdel !== "Все заявки") {
    if ($status !== "Все заявки"){
        if ($house == "Все адреса") {$zayavki = pg_query($conn, "SELECT * FROM request_journal WHERE $filter_date AND otdel = '$otdel' AND status = '$status' ORDER BY date DESC");}
        if ($house !== "Все адреса") {$zayavki = pg_query($conn, "SELECT * FROM request_journal WHERE $filter_date AND addres = '$house' AND otdel = '$otdel' AND status = '$status' ORDER BY date DESC");}
    } elseif ($status == "Все заявки"){
        if ($house == "Все адреса") {$zayavki = pg_query($conn, "SELECT * FROM request_journal WHERE $filter_date AND otdel = '$otdel' ORDER BY date DESC");}
        if ($house !== "Все адреса") {$zayavki = pg_query($conn, "SELECT * FROM request_journal WHERE $filter_date AND addres = '$house' AND otdel = '$otdel' ORDER BY date DESC");}
    }
}elseif ($otdel == "Все заявки") {
    if ($status !== "Все заявки"){
        if ($house == "Все адреса") {$zayavki = pg_query($conn, "SELECT * FROM request_journal WHERE $filter_date  AND status = '$status' ORDER BY date DESC");}
        if ($house !== "Все адреса") {$zayavki = pg_query($conn, "SELECT * FROM request_journal WHERE $filter_date AND addres = '$house'  AND status = '$status' ORDER BY date DESC");}
    } elseif ($status == "Все заявки"){
        if ($house == "Все адреса") {$zayavki = pg_query($conn, "SELECT * FROM request_journal WHERE $filter_date ORDER BY date DESC");}
        if ($house !== "Все адреса") {$zayavki = pg_query($conn, "SELECT * FROM request_journal WHERE $filter_date AND addres = '$house' ORDER BY date DESC");}
    }
}

//открытие заявки из квартиры
if ($_POST['time']) {$time = $_POST['time'];
$zayavki = pg_query($conn, "SELECT * FROM request_journal WHERE date = '$time' ORDER BY date DESC");
}

while (($row = pg_fetch_row($zayavki))) {
    $row[1] = Reload($row[1]);
    if ($row[0] == "Выполнено") {$color = $colorGood;}
    if ($row[0] == "В работе") {$color = $colorWarning;}
    if ($row[0] == "Не выполнено") {$color = $colorBad;}
    echo "<tr style=\"font-size: 12px; text-align: center;\"> <td style=\"background-color:$color;\">$row[0]</td><td>";
      if ($row[0] !== "Выполнено"){
          require 'button_done.php';}
      else {require 'button_notdone.php';}
            echo "</td><td>";
            require 'button_print.php';
            echo "</td>"
                ." <td>$row[1]</td> "
                . "<td>$row[2]</td> <td>$row[3]";
            if (!empty($row[3])) {require 'go2.php';}
            echo "</td> "
                . "<td>$row[4]</td> <td>$row[5]</td> "
                . "<td>$row[6]</td> <td>$row[7]</td> "
                . "<td>$row[8]</td> <td>$row[9]</td> "
                . "<td>$row[10]</td> </tr>";
    unset($color);
    $arhivZayavok[] = $row;
        }
echo "</table> </div>";   

//добавление заявки
if (!empty($_POST['newZayvka'])){
    $status = "В работе";
    $addres = $_POST['house0'];
    $kv = $_POST['kv'];
    $otdel = $_POST['otdel0'];
    $request = $_POST['text'];
    $requestTime = $_POST['date']." c ".$_POST['timeStart']." по ".$_POST['timeEnd'];
    $acceptMetod = $_POST['chanal'];
    $requestFIO = $_POST['FIO'];
    $phoneNumber = $_POST['tel'];
    $dispetcher = $_POST['dispetcher'];
    $donefio = "-";
    $donetime = "-";
    $donetext = "-";
    $type = $_POST['type'];
    $phonesms = $_POST['SMS'];
    $donematerial = "-";
    $donetimeend = "-";
    $newzayavka = pg_query($conn, "INSERT INTO request_journal VALUES ('$status', '$date', '$addres', '$kv', '$otdel', '$request', '$requestTime', '$acceptMetod', 
            '$requestFIO', '$phoneNumber', '$dispetcher', '$donefio', '$donetime', '$donetext', 
            '$type', '$phonesms', '$donematerial', '$donetimeend');");
    }

//закрытие заявки
if(!empty($_POST['closeRequest'])) {
    echo "Работаем";
   $donefio = $_POST['donefio'];
   $donetime = $_POST['donetime'];
   $donetimeend = $_POST['donetimeend'];
   $donetext = $_POST['donetext'];
   $donematerial = $_POST['donematerial'];
   $closeDate = $_POST['closedate'];
           
   $closeRequest = pg_query($conn,"UPDATE request_journal SET status = 'Выполнено', "
           . "donefio = '$donefio', donetime = '$donetime', "
           . "donetimeend = '$donetimeend', donetext = '$donetext', "
           . "donematerial = '$donematerial' where date = '$closeDate'");
}