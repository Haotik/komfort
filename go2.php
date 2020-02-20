<?php

echo "<form action=\"index.php\" method=\"post\"> 
    <input type=\"image\" src=\"/images/go.png\" alt=\"Журнал заявок\"
    style=\"text-align: center;\">
    <input type=\"hidden\" name=\"h\" value=\"$row[2]\">"
    . "<input type=\"hidden\" name=\"flat\" value=\"$row[3]\"></form>";