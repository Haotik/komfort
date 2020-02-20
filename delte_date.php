<?php
require 'default.php';
$filter_date = $_POST['number'];
$readings = pg_query($conn, "SELECT * FROM write_journal WHERE date ='$filter_date'");
$row = pg_fetch_row($readings);

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
        <p style=\"position: absolute; left: 150px; top: 30px; font-size:20px; font-weight: bold;\"> Удалить внесенные данные?  <br></p>
        <form action=\"write_jurnal.php\" method=\"post\" style=\"position: absolute; left: 75px; top: 80px;\">
            <div class=\"first\">
                <p> Дата:
                    $row[0]
                </p>
                <p> Адрес: 
                    $row[1] кв $row[2]
                </p>
                <p> Показания:
                    Вода: $row[3] $row[4] $row[5] $row[6] Т1: $row[9] Т2: $row[10] 
                </p>
                <p> Кто внес:  $row[7]
                </p>
                <p> На оснвоании: $row[8]
                </p>
            </div>
            <p>
                 Пароль:<br>
                 <input type=\"password\" name=\"password\" required><br><br>
                 <input type=\"submit\" name=\"delete\" value=\"Удалить\"> &nbsp;&nbsp;
                 <input type=\"submit\" name=\"back\" value=\"Вернутся\">
             </p>
            <input type=\"hidden\" name=\"delete_date\" value=\"$row[0]\">
        </form>       
    </body>
</html>";
