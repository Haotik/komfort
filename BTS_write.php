<?php

require 'default.php';
$flat = $_POST['flat'];
$house = $_POST['house'];
$date = $_POST['calendar'];
$f0=$_POST['write0'];
$f1=$_POST['write1'];
$f2=$_POST['write2'];
$f3=$_POST['write3'];
$f4=$_POST['write4'];
$f5=$_POST['write5'];
$f6=$_POST['write6'];
$f7=$_POST['write7'];
$f8=$_POST['write8'];
$autor=$_POST['write8'];
$osnovanie = $_POST['osnovanie'];
$comment = $_POST['osnovanie']." от ".$date." :".$_POST['write7']." ".$_POST['write6'];

echo "<form action=\"index.php\" method=\"post\" style=\"position:absolute; top:145px; left:293px; text-align: center;\">
 Данные внесены <br>
<p>Дом <select name=\"house\">
 <option>$house</option>
 </select></p>
  <p>№ квартиры <input type=\"text\" name=\"flat\" value=$flat size=\"10px\"></p>
  <p><input type=\"text\" name=\"0\" size=\"10px\" value=\"ХВС\" style=\"text-align: center; background-color: #1E90FF;\">
 <input type=\"text\" name=\"1\" size=\"10px\" value=\"ГВС\" style=\"text-align: center;  background-color: #FF4500;\">
 <input type=\"text\" name=\"2\" size=\"10px\" value=\"ХВС2\" style=\"text-align: center; background-color: #1E90FF;\">
 <input type=\"text\" name=\"3\" size=\"10px\" value=\"ГВС2\" style=\"text-align: center; background-color: #FF4500;\">
 <input type=\"text\" name=\"4\" size=\"10px\" value=\"Електро Т1\" style=\"text-align: center; background-color: #FFD700;\">
 <input type=\"text\" name=\"5\" size=\"10px\" value=\"Електро Т2\" style=\"text-align: center; background-color: #FFD700;\"></p> 
  <p><input type=\"text\" name=\"write0\" value=$f0 size=\"10px\">
  <input type=\"text\" name=\"write1\" value=$f1 size=\"10px\">
  <input type=\"text\" name=\"write2\" value=$f2 size=\"10px\">
  <input type=\"text\" name=\"write3\" value=$f3 size=\"10px\">
  <input type=\"text\" name=\"write4\" value=$f4 size=\"10px\">
  <input type=\"text\" name=\"write5\" value=$f5 size=\"10px\"></p>
  
  <p> Внесено на основании </p>
 <p><select name=\"osnovanie\">
                <option>$osnovanie<option>
                <option>Телефон</option>
		<option>Сайт</option>
                <option>АКТ осмотра приборов учета</option>
                <option>АКТ замены приборов учета</option>
                <option>Лично</option>
                <option>Инвентаризация</option></select>
 на дату <input type=\"date\" name=\"calendar\" value=$date></p>
   <p> Ф.И.О <input type=\"text\" name=\"write6\" value=$f6 size=\"10px\"> 
    Телефон <input type=\"text\" name=\"write7\" value=$f7 size=\"10px\">
    Кто внес <input type=\"text\" name=\"write8\" value=$f8 size=\"10px\"></p>
 <p><input type=\"submit\" name=\"break\" value=\"назад\" /></p>
</form>";

echo "pg_query($conn,\"INSERT INTO write_journal VALUES ('$date', '$house', '$flat', '$f0', '$f1', '$f2', '$f3', '$autor', '$comment', '$f4','$f5')\");";