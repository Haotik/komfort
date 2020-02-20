<?php
require 'menu.php';
require 'default.php';
require 'header.php';

/* суть
 * Поиск среди собственников при чтении из файла
 * 
 */
$arrcount = 0;

$handle = fopen("docs\\1.csv","r");

    while ($data = fgetcsv($handle,1000,";")) {
        $result[] = $data;
    }

$k = 0; //счетчик делитель по квартирам
$h = 0; //счетчик делитель по домам
$peoples = [];

for ($i = 2; $i < count($result);$i++) {

    if (substr_count($result[$i][0],"Курская обл") > 0) {
        $house = houseRename($result[$i][0]);
        $h++;
        $k = 0;
        continue;
    } else if (substr_count($result[$i][0],"Кв.") > 0
        OR substr_count($result[$i][0],"Оф.")) {
        $flat = intval(substr($result[$i][0],6));
        $k++;
        continue;
    }
    else if ($result[$i][1] != "Нет" OR $result[$i][3] == "Да" ) {
        $result[$i][] = $flat;
        $result[$i][] = $house;
        if($result[$i][4] != "Не указан") $result[$i][4] = str_replace(['-',' '],'',$result[$i][4]);
        $peoples[$h][$k][] = $result[$i];
    }
}
?>

<span class="info">
    Для поиска нажмите на клавиатуре одновременно ctrl+f и введите запрос. <br>
    Имена и фамилии вводятся с большой буквы. <br>
    При поиске по номеру телефона - номер вводится без пробелов
</span>
<div class="table">
    <table>
        <caption>Список всех жильцов на 1 февраля 2020 г.</caption>
        <tr>
            <td>Адрес</td>
            <td>Ф.И.О.</td>
            <td>Проживает</td>
            <td>Статус</td>
            <td>Собственник</td>
            <td>Телефон</td>
        </tr>
        <?php
        foreach ($peoples as $tableHouse) {
            $house = $tableHouse[1][0][6];
            usort($tableHouse, "cmp3");
        ?>
            <tr>
                <td colspan="6" style="text-align: center">
                    <?=$house?>
                </td>
            </tr>
        <?php
        foreach ($tableHouse as $tableFlat) {
            foreach ($tableFlat as $tableRecord) {
        ?>
            <tr>
                <td><?=$house." кв ".$tableRecord[5] ?></td>
                <td><?=$tableRecord[0] ?></td>
                <td><?=$tableRecord[1] ?></td>
                <td><?=$tableRecord[2] ?></td>
                <td><?=$tableRecord[3] ?></td>
                <td><?=$tableRecord[4] ?></td>
            </tr>
        <?php }}} ?>
    </table>
</div>
