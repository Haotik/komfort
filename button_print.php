<?php

echo "<form action=\"actPrint.php\" method = post style='padding: 0px; margin: 0px;'>"
."<input type=\"hidden\" name=\"number\" value=\"$row[1]\">"
. "<button style=' width: 100px'>Акт</button>"
. "</form>";

echo "<form action=\"requestPrint.php\" method = post style='padding: 0px; margin: 0px;'>"
    ."<input type=\"hidden\" name=\"number\" value=\"$row[1]\">"
. "<button style=' width: 100px'>Заявка</button>"
. "</form>";
