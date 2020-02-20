<?php
require 'default.php';
$filter_date = $_POST['number'];
$zayavki = pg_query($conn, "SELECT * FROM request_journal WHERE date ='$filter_date'");
$row = pg_fetch_row($zayavki);

echo "<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
             <style>
    body {
    background-image: url(images/done.jpg); 
    background-repeat: no-repeat;
    background-size: 550px 440px ;
    }
    </style>
    </head>
    <body>
        <p style=\"position: absolute; left: 150px; top: 30px; font-size:20px; font-weight: bold;\"> Отчет о выполнении заявки: <br></p>
        <form action=\"zayavki.php\" method=\"post\" style=\"position: absolute; left: 75px; top: 80px;\">
            <div class=\"first\">
                <p> Исполнитель:
                    <input type=\"text\" name=\"donefio\" style=\"margin-left: 25px;\">
                </p>
                <p> Начало работ: 
                    <input type=\"text\" name=\"donetime\" style=\"margin-left: 25px;\">
                </p>
                <p> Окончание работ:
                    <input type=\"text\" name=\"donetimeend\">                    
                </p>
            </div>
            
            <div class=\"second\">
                Что сделано: <br>
                <textarea cols=\"25\" rows=\"10\" name=\"donetext\"></textarea>
            </div>
            
            <div class=\"third\" style=\"position: absolute;left: 220px; top: 128px;\">
                Материалы: <br>
                <textarea cols=\"25\" rows=\"10\" name=\"donematerial\"></textarea>
            </div>
            <input type=\"submit\" name=\"closeRequest\" value=\"Сохранить\" style=\"margin-left: 160px; margin-top: 10px;\">
            <input type=\"hidden\" name=\"closedate\" value=\"$row[1]\">
        </form>       
    </body>
</html>";
