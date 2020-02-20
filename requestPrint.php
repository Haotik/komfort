<?php
require 'default.php';
$filter_date = $_POST['number'];
$zayavki = pg_query($conn, "SELECT * FROM request_journal WHERE date ='$filter_date'");
$row = pg_fetch_row($zayavki);
//test($row);
?>
<html>
    <head>
        <title>Распечатать заявку</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <style>
            @media print{
                #noprint{
                    display: none;
                }
            }
            #noprint {
                position: absolute;
                left: 20px;
                bottom: 400px;
            }
            * {
                box-sizing: border-box;
                margin: 0px;
                padding: 0px;
                line-height: 24px;
            }
           .block {
                width: 760px;
                height: 100px;
                margin-bottom: 40px;
            }
            .first_left, .first_right, .second_left, .second_right {
                width: 375px;
                padding-left: 10px;
            }
            .first_left, .first_right {
                border: 1px solid black;
            }
            .first_left, .first_head, .second_left{
                float: left;
            }
             .first_right, .first_right, .second_right {
                 float: right;
                 margin-right: 10px;
             }
             .first_text, p{
                 text-align: center;
             }
             p{
                 font-weight: bold;
                 font-size: 20px;
                 margin-bottom: 5px;
             }
             textarea{
                 border: 1px solid black;
                 margin-left: 55px;
                 padding: 10px;
                 text-align: center;
                 height: 80px;
                 width: 600px;
             }
             .top{
                 position: relative;
                 bottom: 70px;
             }
             table{
                 border-collapse: collapse;
             }
             td{
                 border-bottom: 1px solid black;
                 border-top: 1px solid black;
                 width: 360px;
                 height: 20px;
             }
             td:first-child {
                 border-right: 1px solid black;
             }
             .right {
                 margin-left: 280px;
              }
             .left {
                 margin-right: 250px;
             }
             .signature {
                 float: right;
                 margin-right: 10px;
             }
             .center {
                 text-align: center;
             }
        </style>
    </head>
    <body>
          <form action="zayavki.php" method="post" style="position: absolute; left: 10px; top: 10px;">
            <p><u> Заявка </u></p>
            <div class='first block'>
                <span class="left">Данные заявителя: </span>
                <span>Данные заявки:</span><br>
                <div class='first_left'>
                    <div class='first_head'>
                        Дата: <br>
                        Адрес: <br>
                        Ф.И.О.: <br>
                        Телефон:
                    </div>
                    <div class='first_text'>
                        <?= Reload($row[1]) ?> <br>
                        <?= $row[2] . " " . $row[3]?> <br>
                        <?= $row[8]?> <br>
                        <?= $row[9]?>
                    </div>
                </div>
                <div class='first_right'>
                    <div class='first_head'>
                        Тип заявки: <br>
                        Способ подачи: <br>
                        Отдел: <br>
                        Назначеное время:
                    </div>
                    <div class='first_text'>
                        <?= $row[16] ?> <br>
                        <?= $row[7]?> <br>
                        <?= $row[4]?> <br>
                        <?= $row[6]?>
                    </div>
                </div>
            </div>
            <div class='second block'>
            <span class="top">Текст заявки:</span>
            <textarea><?= $row[5]?></textarea>
            <br><br>
            <div class="second_left">
                Кто принял заявку: <u> <?= $row[10]?></u>
            </div>
            <div class="second_right">
                Исполнитель: ________________
            </div>
            </div>
            <div class='third block'>
                <br>
                <span>Что сделано:</span>
                <span class="right">Используемые материалы:</span>
                <table>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <br>
                Дата и время начала работ: ____________________________<br>
                Дата и время окончания работ: _________________________
                <span class="signature">Подпись: _______________________</span>
                <br>
                - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
                - - - - - - - - - - - - -
            </div>

        </form>

          <div id='noprint'><A HREF="javascript:window.print()" >Распечатать</a>
          <br> <A HREF="zayavki.php" >Назад</a></div>
    </body>
</html>

