<?php
require 'menu.php';
require 'default.php';
require 'header.php';

/* суть
 * Поиск среди собственников при чтении из файла
 * 
 */
$arrcount = 0;

$handle = fopen("docs\\report.csv","r");

    while ($data = fgetcsv($handle,1000,";")) {
		$ls = str_split($data[5],4);
		
		switch($ls[0]) {
			case "1110":	
				$street = "Ленина";
				break;
			case "0590": 
				$street = "Всесвятская";
				break;
			default: 
				$street = "Батова";
		}
			
			$house = ltrim($ls[1],0);
			$house = rtrim($house,0);
			$flat = ltrim($ls[2],0);
			$flat = substr($flat,0,-1);
			
		switch($house) {
			case "592":
				$house = "59-2";
				break;
			case "632":
				$house = "63-2";
				break;
			case "652":
				$house = "65-2";
				break;
			case "653":
				$house = "65-3";
				break;
			case "671":
				$house = "67-1";
				break;
			case "692":
				$house = "69-2";
				break;
			case "693":
				$house = "69-3";
				break;
			case "712":
				$house = "71-2";
				break;
			case "732":
				$house = "73-2";
				break;
			case "772":
				$house = "77-2";
				break;
			case "42":
				$house = "4-2";
				break;
			case "43":
				$house = "4-3";
				break;				
		}
		if ($house == "6302") continue;
		$address = $street . " " . $house;
		$extractResult[] = array($data[5],$data[6],$address, $flat);
    }
	
	foreach ($extractResult as $row) {
		$flat = $row[3];
		$house = $row[2];
		$Owner_data =  pg_fetch_row(pg_query($conn, "SELECT fio, dolg, phone FROM owners1c WHERE kv='$flat' AND adress='$house'"));
		$writeJurnal =  pg_fetch_row(pg_query($conn,"SELECT * FROM write_journal WHERE ndoma = '$house' AND nkvart='$flat' ORDER BY date DESC"));
		if(strpos($writeJurnal[8],"января 2020") or strpos($writeJurnal[8],"февраля 2020")) {
		continue;
		}
		$row[] = $Owner_data[2];
		$row[] = $writeJurnal[8];
		$result[] = $row;	
		$arrcount++;
	}
	
	$fp = fopen("C:\\OSPanel\\domains\\Komfort\\docs\\report2.csv", 'w');

	foreach ($result as $fields) {
		fputcsv($fp, $fields,';');
	}
	fclose($fp);

	$test = file_get_contents("C:\\OSPanel\\domains\\Komfort\\docs\\report2.csv");
	$test = iconv('UTF-8','CP1251', $test);
	file_put_contents("C:\\OSPanel\\domains\\Komfort\\docs\\report2.csv", $test);
echo "Вcего записей $arrcount";
?>

<div class="table">
    <table>
        <caption>Список оплат через банк</caption>
        <tr>
            <td>ЛС</td>
            <td>Ф.И.О.</td>
            <td>Адресс</td>
            <td>Телефон</td>
            <td>Последний раз передавали показания</td>
        </tr>
        <?php
            foreach ($result as $tableRecord) {
        ?>
        <tr>
			<td><?=$tableRecord[0] ?></td>
            <td><?=$tableRecord[1] ?></td>
            <td><?=$tableRecord[2]." ".$tableRecord[3] ?></td>
            <td><?=$tableRecord[4] ?></td>
            <td><?=$tableRecord[5] ?></td>
        </tr>
<?php } ?>
    </table>
</div>