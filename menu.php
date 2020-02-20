<?php

echo "<form action=\"index.php\" method=\"post\"> <p>"
. "<input type=\"image\" src=\"/images/pokazania.png\" alt=\"Внести показания\""
        . "style=\"position:absolute; top:20px; left:55%; white-space: pre-line;\">"
        . "</p> </form>";

echo "<form action=\"archiv_pokazanij.php\" method=\"post\"> <p>"
. "<input type=\"image\" src=\"/images/archiv-pokazaniy.png\" alt=\"Архив показаний\""
        . "style=\"text-align: center; "
        . "position:absolute; top:20px; left:64%; white-space: pre-line;\">"
        . "</p></form>";

echo "<form action=\"write_jurnal.php\" method=\"post\"> <p>"
. "<input type=\"image\" src=\"/images/jurnal_zapisi.png\" alt=\"Журнал записи\""
        . "style=\"text-align: center;"
        . "position:absolute; top:20px; left:73%;white-space: pre-line;\">"
        . "</p></form>";
             
echo "<form action=\"offlist.php\" method=\"post\"> <p>"
. "<input type=\"image\" src=\"/images/switch_off.png\" alt=\"Журнал питания\""
        . "style=\"text-align: center;"
        . "position:absolute; top:20px; left:82%; white-space: pre-line;\">"
        . "</p></form>";

echo "<form action=\"zayavki.php\" method=\"post\"> <p>"
. "<input type=\"image\" src=\"/images/zayavki.png\" alt=\"Журнал заявок\""
        . "style=\"text-align: center;"
        . "position:absolute; top:20px; left:91%;white-space: pre-line;\">"
        . "</p></form>";
