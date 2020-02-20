<?php
require 'menu.php';
require 'default.php';
require 'header.php';

/* суть
 * 1 список должников загружается в бд - вручную? - лучше вести обработку файла excel csv но это потом
 * Таблица offlist
 * потом происходит обращение к таблице owners1s откуда берется текущая задолженность и данные собственника
 * по умолчанию текущий долг = 0 при обращении в первый раз она просто переписывается (что бы вручную не разносить)
 * в дальнейшем мы считаем движение относительно нее
 * если сумма задолженности увеличивается то это начисления которые нам не нужны ??? поставить как сумма начислений за последний месяц - справочно
 * если сумма задолженности уменьшаются то это оплаты за период которые нам как раз и нужны
 * далее мы сравниваем отслеживаемую задолженность и оплаты - погасил ли челвоек долг или нет
 */

$list = pg_fetch_all(pg_query($conn, "SELECT * FROM offlist ORDER BY house"));

    foreach ($list as $record) {
        $id = $record['id'];
        $house = $record['house'];
        $flat = $record['flat'];

        $result = pg_fetch_all(pg_query($conn,"SELECT * FROM owners1c WHERE adress = '$house' AND kv = '$flat'"));
        $dolg = strtr($result[0]['dolg'],',','.');

        //первичное заполнение строк
            if ($record['current'] == 0) {
                $record['current'] = $current = $dolg;
                pg_query("UPDATE offlist SET current = '$current' WHERE id = '$id'");
            } else
        //Проверяем оплаты
            if ($record['current'] > $dolg) {
                $record['payouts'] += $payout = $record['current'] - $dolg;
                pg_query("UPDATE offlist SET payouts = '$payout', current = '$dolg' WHERE id = '$id'");
            } else if ($record['current'] < $dolg) {
                $record['adds'] += $adds = $dolg - $record['current'];
                pg_query("UPDATE offlist SET adds = '$adds', current = '$dolg' WHERE id = '$id'");
            }
        $record['fio'] = $result[0]['fio'];
        $record['current'] = $dolg;
        $records[] = $record;
    }

?>

<div class="table">
    <table>
        <caption>Список должников на отключение в феврале 2020 года</caption>
        <tr>
            <td>Адрес</td>
            <td>Ф.И.О.</td>
            <td>Отслеживаемый долг</td>
            <td>Текущая задолженность</td>
            <td>Оплаты</td>
            <td>Начисления</td>
        </tr>
        <?php
            foreach ($records as $tableRecord) {
        ?>
        <tr>
            <td><?=$tableRecord['house']." ".$tableRecord['flat'] ?></td>
            <td><?=$tableRecord['fio'] ?></td>
            <td><?=$tableRecord['debt'] ?></td>
            <td><?=$tableRecord['current'] ?></td>
            <td><?=$tableRecord['payouts'] ?></td>
            <td><?=$tableRecord['adds'] ?></td>
        </tr>
<?php } ?>
    </table>
</div>
