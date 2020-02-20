<?php

require 'default.php';

if (!$_POST['flat']) {
    $flat = "Все";
} else {$flat = $_POST['flat'];}
if (!$_POST['house']) {
    if ($_COOKIE['house']) {$house = $_COOKIE['house'];}
    else {$house = "Все адреса";}
    } else {$house = $_POST['house'];}
    
if ($_POST['calendar0']) {$date0 = $_POST['calendar0'];}
if ($_POST['calendar']) {$dateFilter = $_POST['calendar'];
//$date = $_POST['calendar'];
}

setcookie("flat", $flat);
setcookie("house", $house);
require 'header.php';
//echo "<p style=\"position:absolute; top:25px; left:700px; text-align: right;\">Журнал ввода показаний</p>";
$delete = $_POST['delete'];
$delete_date = $_POST['delete_date'];
$password = $_POST['password'];
if (!empty($delete) AND $password == '2741001'){
   $delete_from_write_j = pg_query($conn, "DELETE FROM write_journal WHERE date = '$delete_date'");
   require 'done.js'; 
} 

echo "<form action=\"write_jurnal.php\" method=\"post\" style=\"position:absolute; top:25px; left:50px; text-align: right;\">
 <p>Дом <select name=\"house\">
                <option>$house</option>
                <option>Все адреса</option>
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
<label> № кв <input type=\"textbox\" name=\"flat\" value=$flat size=\"10px\"></label></p>
<p style=\"text-align: center;\">С
<input type=\"date\" name=\"calendar0\" value=$date0> ПО
<input type=\"date\" name=\"calendar\" value=$dateFilter></p>
<p style=\"position:absolute; left:350px; top:1px; text-align: center;\">
<input type=\"image\" src=\"/images/find.png\" alt=\"Найти\"></p>
</form>";
      
if (!$conn) {
  echo "Нет соединения с базой.\n";
  exit;
}

require "houses.php";
require 'menu.php';

echo "<div style=\"width:90%; height:80%; overflow:auto; position: absolute; left:5%; top: 150px;\">"
. "<table bgcolor=white border=\"1\" table-layout: fixed; style=\"border-collapse: collapse;>";
echo "<tr style=\"font-size: 12px; text-align: center;\"> "
        . "<td style=\"width:5%;font-size: 12px;text-align: center;\">Удалить</td> "
        . "<td style=\"width:5%;font-size: 12px;text-align: center;\">Дата</td> "
        . "<td style=\"width:7%;font-size: 12px;text-align: center;\">Дом</td> "
        . "<td style=\"width:5%;font-size: 12px;text-align: center; \">Кв</td> "
        . "<td style=\"width:5%;font-size: 12px;text-align: center;\">ХВС</td> "
        . "<td style=\"width:5%;font-size: 12px;text-align: center;\">ГВС</td> "
        . "<td style=\"width:5%;font-size: 12px;text-align: center;\">ХВС2</td> "
        . "<td style=\"width:5%;font-size: 12px;text-align: center;\">ГВС2</td> "
        ."<td style=\"width:5%;font-size: 12px;text-align: center;\">Т1</td> "
        . "<td style=\"width:5%;font-size: 12px;text-align: center;\">Т2</td>"
        . "<td style=\"width:12%;word-break: break-all;font-size: 12px;text-align: center;\">Кто записал</td> "
        . "<td style=\"width:12%;font-size: 12px;word-break: break-all;text-align: center;\">На основании</td> </tr>";
if ($house == "Все адреса") {$write_j = pg_query($conn, "SELECT * FROM write_journal WHERE date >= '$date0' AND date < '$dateFilter 23:59:59' ORDER BY ndoma, date DESC");}
if ($house !== "Все адреса" AND $flat !== "Все") {$write_j = pg_query($conn, 
        "SELECT * FROM write_journal WHERE date >= '$date0' AND date < "
        . "'$dateFilter 23:59:59' AND ndoma = '$house' AND nkvart='$flat' ORDER BY date DESC");}
elseif($house !== "Все адреса" AND $flat == "Все") {$write_j = pg_query($conn, 
        "SELECT * FROM write_journal WHERE date >= '$date0' AND date < "
. "'$dateFilter 23:59:59' AND ndoma = '$house' ORDER BY date DESC");}
unlink('file.csv');
$count = 0; 
   while (($row = pg_fetch_row($write_j))) {
        settype($row[2],"integer");
        $row[0] = Reload($row[0]);
        echo "<tr style=\"font-size: 12px; text-align: center;\"> <td>";
        require 'button_del.php';
        echo "</td> <td>$row[0]</td> <td>$row[1]</td>"
                . "<td>$row[2]</td> <td>$row[3]</td>"
                . "<td>$row[4]</td> <td>$row[5]</td>"
                . "<td>$row[6]</td> <td>$row[9]</td>"
                . "<td>$row[10]</td> <td>$row[7]</td>"
                . "<td>$row[8]</td> </tr>";
        array_splice($row, 7, -2);
        foreach($row as $key){$key = iconv("UTF-8", "windows-1251", $key);}
        $inFile[]=$row;
		$count++;
    }
	//echo "<pre>";
	usort($inFile, "cmp2");
    //var_dump($inFile); echo "</pre>"; die;
	   
	   
echo "</table> </div>";
$c = $house . " " . $dateFilter;
$c = strtr($c," ","_");
$fp = fopen("C:\\OSPanel\\domains\\Komfort\\docs\\$c.csv", 'w');

foreach ($inFile as $fields) {
    fputcsv($fp, $fields,';');
}
fclose($fp);

$test = file_get_contents("C:\\OSPanel\\domains\\Komfort\\docs\\$c.csv");
$test = iconv('UTF-8','CP1251', $test);
$result = file_put_contents("C:\\OSPanel\\domains\\Komfort\\docs\\$c.csv", $test);

echo "<form action=\"\\docs\\$c.csv\"><p>"
. "<input type=\"image\" src=\"/images/savejurnal.png\" alt=\"Скачать журнал\""
        . "style=\"position:absolute; left:480px; top:40px; white-space: pre-line;\">"
        . "</p> </form>";

echo $count;
if(!empty($delete) AND $password != '2741001') {require 'wrong_pass.js';}