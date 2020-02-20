<?php
require 'default.php';
$filter_date = $_POST['number'];
$zayavki = pg_query($conn, "SELECT * FROM request_journal WHERE date ='$filter_date'");
$row = pg_fetch_row($zayavki);

echo "<html>
    <head>
        <title>Распечатать Акт</title>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <style>
@media print{
   #noprint{
       display:none;
   }
}</style>
    </head>
    <body>
    <div id=\"noprint\"><A HREF=\"javascript:window.print()\" >Распечатать</a></div>
    <div id=\"noprint\"><A HREF=\"/zayavki.php\" >Назад</a></div>
        <p style=\"position: absolute; left: 250px; top: 10px; text-align: center; font-size:20px; font-weight: bold;\"> АКТ <br> ВЫПОЛНЕНЫХ РАБОТ</p>
        <form action=\"zayavki.php\" method=\"post\" style=\"position: absolute; left: 95px; top: 80px;\">
            <div class=\"first\">
                <p> Основание: 
                    <input type=\"text\" size=\"35\" value=\"Заявка:$row[7]\" style=\"border-color:black; margin-left: 150px; text-align:center;\"> 
                </p>
                <p> Дата, время: 
                    <input type=\"text\" size=\"35\" value=\"$row[1]\" style=\"border-color:black; margin-left: 145px; text-align:center;\">
                </p>
                <p> Адрес заявителя:
                    <input type=\"text\" size=\"35\" value=\"$row[2]&nbsp кв: $row[3]\" style=\"border-color:black; margin-left: 112px; text-align:center;\">
                </p>
                <p> Ф.И.О. заявителя:
                    <input type=\"text\"  size=\"35\" value=\"$row[8]\" style=\"border-color:black; margin-left: 106px; text-align:center;\">
                </p>
                <p> Телефон заявителя:
                    <input type=\"text\" size=\"35\" value=\"$row[9]\" style=\"border-color:black; margin-left: 95px; text-align:center;\">
                </p>
                <p> Тип заявки: 
                    <input type=\"text\" size=\"35\" value=\"$row[14]\" style=\"border-color:black; margin-left: 147px; text-align:center;\">
                </p>
                <p> Исполнитель:
                    <input type=\"text\" size=\"35\" value=\"$row[11]\" style=\"border-color:black; margin-left: 132px; text-align:center;\">
                </p>
                <p> Назначенное время:
                    <input type=\"text\" size=\"35\" value=\"$row[6]\" style=\"border-color:black; margin-left: 88px; text-align:center;\">
                </p>
                <p> Текст заявки:<br> 
                    <textarea rows=\"10\" cols=\"37\" style=\"border-color:black; position: relative;
                              left: 227;bottom: 15;\">$row[5]</textarea>
                </p>
                </div>
            
            <div>
                <p style=\"position: absolute; left: 180px; top: 460px; 
                   text-align: center; font-size:20px; 
                   font-weight: bold;\">Отчет о выполнении</p>
                <br>
                <p> Дата, время начала работ: 
                    <input type=\"text\" size=\"35\" value=\"$row[12]\" style=\"border-color:black; margin-left: 55px;text-align:center;\">
                </p>
                <p> Дата, время окончания работ: 
                    <input type=\"text\" size=\"35\" value=\"$row[17]\" style=\"border-color:black; margin-left: 30px;text-align:center;\">
                </p>
            </div>
            
            <div style=\"height:300px;\">
                <p style=\"position:absolute; bottom: 112;
                   text-align: center;\">Выполненые работы<br>
                    <textarea rows=\"10\" cols=\"22\" style=\"border-color:black;\">$row[13]</textarea></p>
                <p style=\"position:absolute; bottom: 112; left: 174; 
                   text-align: center;\">Материалы <br>
                    <textarea rows=\"10\" cols=\"22\" style=\"border-color:black;\">$row[16]</textarea></p>
                <p style=\"position:absolute; text-align: center;
                   bottom: 112; left: 348;\">Трудозатраты <br>
                    <textarea rows=\"10\" cols=\"22\" style=\"border-color:black;\"></textarea></p>
            </div>
            <div style=\"position:absolute; bottom: 0px;\">
                Исполнитель <span style=\"border-color:black; margin-left: 77px;\">___________________</span>
                <br><br>
                ИТР <span style=\"border-color:black; margin-left: 135px;\">___________________</span>
                <br><br>
                Утверждаю:<br>
                Ген. Директор <span style=\"border-color:black; margin-left: 68px;\">___________________</span>
            </div>
        </form>       
    </body>
</html>";