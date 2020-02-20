<?php
//Серийные номера и номера БТС
echo "<p style=\"position:absolute; top:25px; left:400px; text-align: left;\"> Установленно счетчиков ".($d)."<br>"
        . "№ БТС"."&nbsp".($chanals[1])."<br>"
        . "SN"."&nbsp".($resulted[0][0])
        ."<br> SN ЭЛС:"."&nbsp".$SN
		."<br><a href=\"sms.php\"> Обновить телефоны </a>"
        ."<br><a href=\"search.php\"> Найти жильца </a>";

/*Управление питанием
echo " 
<form action=\"index.php\" method=\"post\" style=\"position:absolute; top:150px;\"; >
<input type=\"submit\" name=\"powerOn\" value=\"Включить питание\" />
</form>
";*/
        for($i=0; $i<6; $i++) {
            $ff[$i] = Reload($ff[$i]);
        }
// форма вывода показаний
echo "<div style=\"position:absolute; top:150px; left:5%; text-align: right;  >
 <form action=\"index.php\" method=\"post\">
 <p><input type=\"text\" name=\"0\" size=\"10px\" value=\"ХВС\" style=\"text-align: center; background-color: #1E90FF;\">
 <input type=\"text\" name=\"1\" size=\"10px\" value=\"ГВС\" style=\"text-align: center;  background-color: #FF4500;\">
 <input type=\"text\" name=\"2\" size=\"10px\" value=\"ХВС2\" style=\"text-align: center; background-color: #1E90FF;\">
 <input type=\"text\" name=\"3\" size=\"10px\" value=\"ГВС2\" style=\"text-align: center; background-color: #FF4500;\">
 <input type=\"text\" name=\"4\" size=\"10px\" value=\"ЭЛС 1\" style=\"text-align: center; background-color: #FFD700;\">
 <input type=\"text\" name=\"5\" size=\"10px\" value=\"ЭЛС 2\" style=\"text-align: center; background-color: #FFD700;\"></p>    
</form>
 <form action=\"index.php\" method=\"post\">
 <p> <img src=\"/images/pok.png\" width=\"100\" alt=\"Показания\" style=\"position:relative; top:7px; right:10px;\"><input type=\"text\" name=\"0\" size=\"10px\" value=$f[0] style=\"text-align: center;\">
 <input type=\"text\" name=\"1\" size=\"10px\" value=$f[1] style=\"text-align: center;\">
 <input type=\"text\" name=\"2\" size=\"10px\" value=$f[2] style=\"text-align: center;\">
 <input type=\"text\" name=\"3\" size=\"10px\" value=$f[3] style=\"text-align: center;\">
 <input type=\"text\" name=\"4\" size=\"10px\" value=$f[4] style=\"text-align: center;\">
 <input type=\"text\" name=\"5\" size=\"10px\" value=$f[5] style=\"text-align: center;\"></p>    
</form>
<form action=\"index.php\" method=\"post\">
 <p><img src=\"/images/date.png\" width=\"100\" alt=\"На дату\" style=\"position:relative; top:7px; right:10px;\"><input type=\"text\" name=\"5\" size=\"10px\" value=$ff[0] style=\"text-align: center\";>
 <input type=\"text\" name=\"6\" size=\"10px\" value=$ff[1] style=\"text-align: center\";>
 <input type=\"text\" name=\"7\" size=\"10px\" value=$ff[2] style=\"text-align: center\";>
 <input type=\"text\" name=\"8\" size=\"10px\" value=$ff[3] style=\"text-align: center\";>
 <input type=\"text\" name=\"9\" size=\"10px\" value=$ff[4] style=\"text-align: center\";>
 <input type=\"text\" name=\"10\" size=\"10px\" value=$ff[4] style=\"text-align: center\";></p>
</form>
<form action=\"index.php\" method=\"post\">
 <p><img src=\"/images/sost.png\" width=\"100\" alt=\"Состояние\" style=\"position:relative; top:7px; right:10px;\"><input type=\"text\" name=\"5\" size=\"10px\" value=$state[0] style=\"text-align: center; background-color: $color[0];\">
 <input type=\"text\" name=\"6\" size=\"10px\" value=$state[1] style=\"text-align: center; background-color: $color[1];\";>
 <input type=\"text\" name=\"7\" size=\"10px\" value=$state[2] style=\"text-align: center; background-color: $color[2];\">
 <input type=\"text\" name=\"8\" size=\"10px\" value=$state[3] style=\"text-align: center; background-color: $color[3];\">
 <input type=\"text\" name=\"9\" size=\"10px\" value=$state[4] style=\"text-align: center; background-color: $color[4];\">
 <input type=\"text\" name=\"10\" size=\"10px\" value=$state[5] style=\"text-align: center; background-color: $color[5];\"></p>
</form>
<form action=\"index.php\" method=\"post\">
 <p><img src=\"/images/tek.png\" width=\"100\" alt=\"Текущие показания\" style=\"position:relative; top:7px; right:10px;\"><input type=\"text\" name=\"5\" size=\"10px\" value=$curent0 style=\"text-align: center;\">
 <input type=\"text\" name=\"6\" size=\"10px\" value=$curent1 style=\"text-align: center;\";>
 <input type=\"text\" name=\"7\" size=\"10px\" value=$curent2 style=\"text-align: center;\">
 <input type=\"text\" name=\"8\" size=\"10px\" value=$curent3 style=\"text-align: center;\">
 <input type=\"text\" name=\"9\" size=\"10px\" value=$curentEl0 style=\"text-align: center;\">
 <input type=\"text\" name=\"10\" size=\"10px\" value=$curentEl1 style=\"text-align: center;\"></p>
</form>
</div>";

//форма ввода показаний
echo "<form action=\"index.php\" method=\"post\" style=\"position:absolute; top:370px; left:5%; text-align: center;\">
  <p><img src=\"/images/vnesti.png\" width=\"100\" alt=\"OK\" style=\"position:relative; top:7px; right:10px;\"><input type=\"text\" size=\"10px\" name=\"write0\" value = $defis>
  <input type=\"text\" name=\"write1\" size=\"10px\" value =$defis>
  <input type=\"text\" name=\"write2\" size=\"10px\" value =$defis>
  <input type=\"text\" name=\"write3\" size=\"10px\" value =$defis>
  <input type=\"text\" name=\"write4\" size=\"10px\" value =$defis >
  <input type=\"text\" name=\"write5\" size=\"10px\" value =$defis></p>
  <p><input type=\"hidden\" name=\"house\" value=\"$house\">
  <input type=\"hidden\" name=\"flat\" value=$flat size=\"10px\">
   <img src=\"/images/osn.png\" width=\"150\" alt=\"ОСНОВАНИЕ\"><br><br>
 <select name=\"osnovanie\">
                <option>$osnovanie<option>
                <option>Телефон</option>
		        <option>Сайт</option>
                <option>АКТ осмотра приборов учета</option>
                <option>АКТ замены приборов учета</option>
                <option>Лично</option>
                <option>Инвентаризация</option>
                <option>ГИС ЖКХ</option>
                <option>Исправление ошибки ввода</option></select>
 от <input type=\"text\" name=\"calendar\" value=\"$dateInter\"></p>
 <p> Ф.И.О <input type=\"text\" name=\"write6\" value=$Name size=\"10px\"> 
    Телефон <input type=\"text\" name=\"write7\" value=\"$Telefon\" size=\"10px\">
    Кто внес <input type=\"text\" name=\"write8\" value='$operator' size=\"10px\">
 <p><input type=\"submit\" name=\"BTS_write\" value=\"Внести показания\" /></p>
</form>";

//информация о собственнике 
echo "<form method=\"post\" style=\"position:absolute; top:150px; left:60%; text-align: left; line-height: 23px\">
    <p> <img src=\"/images/sob.png\" width=\"120\" alt=\"СОБСТВЕННИК\"> </p>
    <p> <img src=\"/images/tel.png\" width=\"120\" alt=\"ТЕЛЕФОН\"></p>
    <p> <img src=\"/images/money.png\" width=\"120\" alt=\"НАЧИСЛЕНО\"></p>
    </form>";

echo "<form method=\"post\" style=\"position:absolute; top:150px; left:70%; text-align: left; font-size: 20px; font-weight: 600;\">
    <p> $Name</p>
    <p> $Telefon</p>
    <p> $Money</p>
    </form>";

//последние заявки
if(!empty($_POST['house'])){
echo "<div style=\"width:30%; height:25%; overflow:auto; position: absolute; left:60%; top: 370px;\">"
    ."<p style=\"width:100%; text-align: center; font-weight:bold;\">Заявки</p>"
. "<table bgcolor=white border=\"1\"; table-layout: fixed; style=\"border-collapse: collapse;\">";
echo "<tr style=\"font-size: 12px; text-align: center;\"> <td style=\"width:\"9%\";\">Статус</td> <td style=\"width:\"9%\";\">Дата</td> "
                . "<td style=\"width:\"9%\"; \">Отдел</td> <td style=\"width:\"9%\";\">Текст</td>
                    <td style=\"width:\"9%\";\">Перейти к заявке</td>
</tr>";
$zayavki = pg_query($conn, "SELECT * FROM request_journal WHERE addres = '$house' AND kv = '$flat' ORDER BY date DESC LIMIT 5");

/*$write_j = pg_query($conn, 
        "SELECT * FROM write_journal WHERE ndoma = '$house' AND nkvart='$flat' ORDER BY date DESC LIMIT 5");*/
 while (($string2 = pg_fetch_row($zayavki))) {
    if ($string2[0] == "Выполнено") {$color = $colorGood;}
    if ($string2[0] == "В работе") {$color = $colorWarning;}
    if ($string2[0] == "Не выполнено") {$color = $colorBad;}
   echo "<tr style=\"font-size: 12px; text-align: center;\"> <td style=\"background-color:$color;\">$string2[0]</td> <td style=\"width:\"9%\";\">$string2[1]</td>"
                . "<td style=\"width:\"9%\";\">$string2[4]</td> <td style=\"width:\"9%\";\">$string2[5]</td>"
                . "<td style=\"width:\"9%\";\">"; require 'go.php';
   echo "</td> </tr>";
        }
echo "</table> </div>";}