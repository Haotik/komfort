<?php
require 'menu.php';
require 'default.php';
require 'header.php';


if (isset($_GET['action'])){
    $id = $_GET['key_id'];
    $taker = $_GET['subject'];
    $time = date("d-m-Y h:i:s");
    $last = pg_query($conn,"SELECT operation_id FROM key_operations ORDER BY operation_id DESC LIMIT 1");
    $last = pg_fetch_row($last);
    $last = $last[0] + 1;
    if ($_GET['action'] == "Принять") {
        pg_query($conn, "UPDATE public.keys 
                        SET key_status = 'В шкафу', 
                            key_taker = 'Диспетчер',
                            last_operation_id = '$last'
                        WHERE key_id = $id");

        pg_query($conn,"INSERT INTO public.key_operations 
                            (operation_id, operation_name, \"from\", \"to\", dt, key_id) 
                        VALUES (DEFAULT, 'Прием', '$taker', 'Диспетчер', '$time', '$id')");
    } else {
        pg_query($conn, "UPDATE public.keys 
                        SET key_status = 'Выдан',
                            key_taker = '$taker',
                            last_operation_id = '$last'
                        WHERE key_id = $id");

        pg_query($conn,"INSERT INTO public.key_operations 
                            (operation_id, operation_name, \"from\", \"to\", dt, key_id) 
                        VALUES (DEFAULT, 'Выдача', 'Диспетчер','$taker', '$time', '$id')");
    }
}

$keys = pg_fetch_all(pg_query($conn, "SELECT * FROM keys ORDER by key_id"));

$key_journal = pg_fetch_all(pg_query($conn,"SELECT * FROM key_operations"));
    foreach ($key_journal as $record) {
        $index = $record['key_id'] - 1;
        $record['key_id'] = $keys[$index]['key_name'];
        $key_journal_final[]=$record;
    }

$k = 1;
foreach ($keys as $key) {
    if ($key['key_group'] == 1) {
        $key_group_1[] = $key;
    }
    if ($key['key_group'] == 2) {
        $key_group_2[] = $key;
    }
    if ($key['key_group'] == 3) {
        $key_group_3[] = $key;
    }
    if ($key['key_group'] == 4) {
        $key_group_4[] = $key;
    }
}
unset($keys);
$keys[] = $key_group_1;
$keys[] = $key_group_2;
$keys[] = $key_group_3;
$keys[] = $key_group_4;
?>

<div class="all_in">
    <input type="radio" name="tab" id="tab-1" class="radio" checked>
    <label class="label" for="tab-1">1 группа</label>
    <input type="radio" name="tab" id="tab-2" class="radio">
    <label class="label" for="tab-2">2 группа</label>
    <input type="radio" name="tab" id="tab-3" class="radio">
    <label class="label" for="tab-3">3 группа</label>
    <input type="radio" name="tab" id="tab-4" class="radio">
    <label class="label" for="tab-4">4 группа</label>
    <input type="radio" name="tab" id="tab-5" class="radio">
    <label class="label" for="tab-5">Журнал выдачи</label>
    <div class="keys container">
        <?php foreach ($keys as $key_group) {
            echo "<div class=\"key_group$k\">";
            foreach ($key_group as $key) {
                if ($key['key_status'] == 'В шкафу') {
                    $class = "here";
                    $form = "
                    <form action=\"#\" class='key_form'>
                        <input type=\"text\" class='key_form_input' name=\"subject\" placeholder=\"Кому выдан\">
                        <input type='hidden' name='key_id' value='{$key['key_id']}'>
                        <input type=\"submit\" class='key_form_button' name=\"action\" value=\"Выдать\">
                    </form>
                    ";
                } else {
                    $class = "away";
                    $form = "
                        <form action=\"#\" class='key_form'>
                            <input type='hidden' name='key_id' value='{$key['key_id']}'>
                            <input type='hidden' name='subject' value='{$key['key_taker']}'>
                            Ключ взял: {$key['key_taker']} <br>
                            <input type=\"submit\" class='key_form_button' name=\"action\" value=\"Принять\">
                        </form>
                    ";
                }
                echo "<div class=\"keys items $class\">{$key['key_name']} <br> $form</div>";
            }
            echo "</div>";
            $k++;
        }?>
    </div>
</div>
</body>


