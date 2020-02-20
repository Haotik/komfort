<?php

if (!$_POST['flat']) {
    if ($_COOKIE['flat'] && $_COOKIE['flat']!=="Все"){$flat = $_COOKIE['flat'];}
    else {$flat = 1;}
} else {$flat = $_POST['flat'];}
require 'default.php';
if (!$_POST['house']) {
    if ($_COOKIE['house']) {$house = $_COOKIE['house'];}
    } else {$house = $_POST['house'];}

require 'header.php';
echo "<form action=\"archiv_pokazanij.php\" method=\"post\" style=\"position:absolute; top:25px; left:60px; text-align: right;\">
 <p>Дом <select name=\"house\">
                <option>$house</option>
		<option>Ленина 59</option>
		<option>Ленина 59-2</option>
		<option>Ленина 61</option>
		<option>Ленина 63</option>
                <option>Ленина 63-2</option>
                <option>Ленина 65</option>
                <option>Ленина 65-2</option>
                <option>Ленина 65-3</option>
                <option>Ленина 67</option>
                <option>Ленина 67-1</option>
                <option>Ленина 69</option>
                <option>Ленина 69-2</option>
                <option>Ленина 69-3</option>
                <option>Ленина 71</option>
                <option>Ленина 71-2</option>
                <option>Ленина 73</option>
                <option>Ленина 73-2</option>
                <option>Ленина 75</option>
                <option>Ленина 77</option>
                <option>Ленина 77-2</option>
                <option>Ленина 79</option>
                <option>Всесвятская 2</option>
                <option>Всесвятская 4</option>
                <option>Всесвятская 4-2</option>
                <option>Всесвятская 4-3</option>
                <option>Всесвятская 6</option>
                <option>Всесвятская 8</option>
                <option>Батова 2</option>
                <option>Батова 4</option>
                <option>Батова 6</option>
</select></p>
<p style=\"text-align: center;\">№ квартиры <input type=\"text\" name=\"flat\" value=$flat size=\"10px\"></p>
<p style=\"position:absolute; left:200px; top:1px; text-align: center;\"><input type=\"image\" src=\"images/find.png\" alt=\"Найти\"></p>
</form>";
      
if (!$conn) {
  echo "Нет соединения с базой.\n";
  exit;
}

require "houses.php";
require 'menu.php';

$i = 0;
$n = 8;
$d = 0;



echo "<div style=\"width:90%; height:80%; overflow:auto; position: absolute; left:5%; top:150px;\">"
. "<table bgcolor=white border=\"1\" table-layout: fixed; style=\"border-collapse: collapse;\">";

//require 'rashod.php' ;
		$BTS1 = "'$sensors[0]'";
		$BTS_data1 = pg_query($conn, "SELECT v1i, ts FROM archdata_bts2 WHERE devid = $BTS1 ORDER BY ts DESC");
        
		$BTS2 = "'$sensors[2]'";
		$BTS_data2 = pg_query($conn, "SELECT v1i, ts FROM archdata_bts2 WHERE devid = $BTS2 ORDER BY ts DESC");
                
                if ($sensors[4]!= "0") {
		$BTS3 = "'$sensors[4]'";
                $BTS_data3 = pg_query($conn, "SELECT v1i, ts FROM archdata_bts2 WHERE devid = $BTS3 ORDER BY ts DESC");}
                
                if ($sensors[6]!= "0")	{
		$BTS4 = "'$sensors[6]'";
                $BTS_data4 = pg_query($conn, "SELECT v1i, ts FROM archdata_bts2 WHERE devid = $BTS4 ORDER BY ts DESC");}
                
                $Electro_data = pg_query($conn,"SELECT e1i, e2i, ts FROM archdata_mrc2 WHERE devid='$sensors[8]' ORDER BY ts DESC");
                $row5 = pg_fetch_row($Electro_data);
                if (empty($row5)) {$row5 = "NN.";}
                

              
		if (!empty($BTS4)) {$d=4;
                echo "<tr style=\"font-size: 14px; text-align: center;\">" 
                . "<td style=\"width:9%;\">Дата</td>"
                . "<td style=\"width:9%;\">ХВС</td>"
                . "<td style=\"width:9%;\">ГВС</td>"
                . "<td style=\"width:9%;\">ХВС2</td>"
                . "<td style=\"width:9%;\">ГВС2</td>"
                . "<td style=\"width:9%;\"></td>"
                . "<td style=\"width:9%;\">Дата</td>"
                . "<td style=\"width:9%;\">Т1</td>"
                . "<td style=\"width:9%;\">Т2</td></tr>";

                  while (($row1 = pg_fetch_row($BTS_data1)) && ($row2 = pg_fetch_row($BTS_data2)) 
                          && ($row3 = pg_fetch_row($BTS_data3)) 
                          && ($row4 = pg_fetch_row($BTS_data4)) 
                          && ($row5 = pg_fetch_row($Electro_data))) {
                
                $rown51=explode('.', $row5[0]);
                $rown52=explode('.', $row5[1]);
                if ((count($rown51) > 1)) {
                $c = strval ($rown51[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown51 = $rown51[0].".".$c; 
                
                if ((count($rown52) > 1)) {
                $c = strval ($rown52[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown52 = $rown52[0].".".$c; 
                
                      
                $rown1=explode('.', $row1[0]);
                if ((count($rown1) > 1)) {
                $c = strval ($rown1[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown1 = $rown1[0].".".$c;
                
                $rowt1= strval($row1[1]);
                $rowt1 = explode('.', $rowt1);
                $row1[1] = $rowt1[0];
                
                $rowt5 = strval($row5[2]);
                $rowt5 = explode('.', $rowt5);
                $row5[2] = $rowt5[0];
                
                $rown2=explode('.', $row2[0]);
                if ((count($rown2) > 1)) {
                $c = strval ($rown2[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown2 = $rown2[0].".".$c;
                
                $rown3=explode('.', $row3[0]);
                if ((count($rown3) > 1)) {
                $c = strval ($rown3[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown3 = $rown3[0].".".$c;
                
                $rown4=explode('.', $row4[0]);
                if ((count($rown4) > 1)) {
                $c = strval ($rown4[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown4 = $rown4[0].".".$c;
                
                $row1[1] = Reload($row1[1]); $row5[2] = Reload($row5[2]);
                echo "<tr style=\"font-size: 14px; text-align: center;\"> <td style=\"width:9%;\">$row1[1]</td> <td style=\"width:9%;\">$rown1</td> ";
                echo "<td style=\"width:9%;\">$rown2</td> <td style=\"width:9%;\">$rown3</td> <td style=\"width:9%;\">$rown4</td> "
                        . "<td style=\"width:9%;\"></td> <td style=\"width:9%;\">$row5[2]</td> <td style=\"width:9%;\">$rown51</td> <td style=\"width:9%;\">$rown52</td></tr>";
                }
                }
                else if (!empty($BTS3)) {
                                                                            
                echo "<tr style=\"font-size: 14px; text-align: center;\">" 
                . "<td style=\"width:9%;\">Дата</td>"
                . "<td style=\"width:9%;\">ХВС</td>"
                . "<td style=\"width:9%;\">ГВС</td>"
                . "<td style=\"width:9%;\">ХВС2</td>"
                . "<td style=\"width:9%;\"></td>"
                . "<td style=\"width:9%;\">Дата</td>"
                . "<td style=\"width:9%;\">Т1</td>"
                . "<td style=\"width:9%\";\">Т2</td></tr>";
                $d=3;
                     while (($row1 = pg_fetch_row($BTS_data1)) && ($row2 = pg_fetch_row($BTS_data2)) 
                          && ($row3 = pg_fetch_row($BTS_data3)) 
                          && ($row5 = pg_fetch_row($Electro_data))) {
                         
                $rown51=explode('.', $row5[0]);
                $rown52=explode('.', $row5[1]);
                if ((count($rown51) > 1)) {
                $c = strval ($rown51[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown51 = $rown51[0].".".$c; 
                
                if ((count($rown52) > 1)) {
                $c = strval ($rown52[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown52 = $rown52[0].".".$c; 
                
                $rown1=explode('.', $row1[0]);
                if ((count($rown1) > 1)) {
                $c = strval ($rown1[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown1 = $rown1[0].".".$c;
                
                $rowt1= strval($row1[1]);
                $rowt1 = explode('.', $rowt1);
                $row1[1] = $rowt1[0];
                
                $rowt5 = strval($row5[2]);
                $rowt5 = explode('.', $rowt5);
                $row5[2] = $rowt5[0];
                
                $rown2=explode('.', $row2[0]);
                if ((count($rown2) > 1)) {
                $c = strval ($rown2[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown2 = $rown2[0].".".$c;
                
                $rown3=explode('.', $row3[0]);
                if ((count($rown3) > 1)) {
                $c = strval ($rown3[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown3 = $rown3[0].".".$c;
                
                $row1[1] = Reload($row1[1]); $row5[2] = Reload($row5[2]);
                echo "<tr style=\"font-size: 14px; text-align: center;\"> <td style=\"width:9%;\">$row1[1]</td> <td style=\"width:9%;\">$rown1</td> ";
                echo "<td style=\"width:9%;\">$rown2</td> <td style=\"width:9%;\">$rown3</td>"
                        . "<td style=\"width:9%;\"></td> <td style=\"width:9%;\">$row5[2]</td> <td style=\"width:9%;\">$rown51</td> <td style=\"width:9%;\">$rown52</td> ";   
                }
                }
                else if ($BTS2){
                echo "<tr style=\"font-size: 14px; text-align: center;\">" 
                . "<td style=\"width:9%;\">Дата</td>"
                . "<td style=\"width:9%;\">ХВС</td>"
                . "<td style=\"width:9%;\">ГВС</td>"
                . "<td style=\"width:9%;\"></td>"
                . "<td style=\"width:9%;\">Дата</td>"
                . "<td style=\"width:9%;\">Т1</td>"
                . "<td style=\"width:9%;\">Т2</td> </tr>";
                $d=2;
                    while (($row1 = pg_fetch_row($BTS_data1)) 
                          && ($row2 = pg_fetch_row($BTS_data2)) 
                          && ($row5 = pg_fetch_row($Electro_data))) {
                $rown51=explode('.', $row5[0]);
                $rown52=explode('.', $row5[1]);
                if ((count($rown51) > 1)) {
                $c = strval ($rown51[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown51 = $rown51[0].".".$c; 
                
                if ((count($rown52) > 1)) {
                $c = strval ($rown52[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown52 = $rown52[0].".".$c; 
                        
                $rown1=explode('.', $row1[0]);
                if ((count($rown1) > 1)) {
                $c = strval ($rown1[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown1 = $rown1[0].".".$c;
                
                $rowt1= strval($row1[1]);
                $rowt1 = explode('.', $rowt1);
                $row1[1] = $rowt1[0];
                
                $rowt5 = strval($row5[2]);
                $rowt5 = explode('.', $rowt5);
                $row5[2] = $rowt5[0];
                
                $rown2=explode('.', $row2[0]);
                if ((count($rown2) > 1)) {
                $c = strval ($rown2[1]);
                $c = substr($c, 0,2);}
                else {$c = "00";}
                $rown2 = $rown2[0].".".$c;
                
                $row1[1] = Reload($row1[1]); $row5[2] = Reload($row5[2]);
                echo "<tr style=\"font-size: 14px; text-align: center;\"> <td style=\"width:9%;\">$row1[1]</td> <td style=\"width:9%;\">$rown1</td> ";
                echo "<td style=\"width:9%;\">$rown2</td>"
                        . "<td style=\"width:9%;\"></td> <td style=\"width:9%;\">$row5[2]</td> <td style=\"width:9%;\">$rown51</td> <td style=\"width:9%;\">$rown52</td> ";    
                }
                }

echo "</table> </div>";