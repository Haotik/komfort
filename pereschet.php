<!DOCTYPE html>
<html>
    <head>
  <title>Перерасчет</title>
  <style>
   p {
       color: black; /* Цвет текста */
       position: relative;
       top: 86px;
       left:78px;
   } 
   form {
      background-image:url(images/planshet.png);
      background-repeat: no-repeat;
   }
   body {
   background-image:url(images/background22.png);
   background-repeat:repeat;
   }
   @media print{
   #noprint{
       display:none;
   }}
  </style>
 </head> 
 <body>
<?
$tarifGVS = 118.81;
$tarifHVS = 20.86;
$tarifVodotv = 14.11;

$pokHVS = 0;
$pokGVS = 0;
$tekpokHVS = 0;
$tekpokGVS = 0;
$pokGVS = $_POST['pokGVS'];
$pokHVS = $_POST['pokHVS'];
$tekpokGVS = $_POST['tekpokGVS'];
$tekpokHVS = $_POST['tekpokHVS'];

$vodootv = $pokGVS + $pokHVS;
$tekvodootv =  $tekpokGVS + $tekpokHVS;

$itogGVS = ($tekpokGVS - $pokGVS)* $tarifGVS;
$itogHVS = ($tekpokHVS - $pokHVS)* $tarifHVS;
$itogVOD = ($tekvodootv - $vodootv)*$tarifVodotv;
$itogo = $itogGVS + $itogHVS + $itogVOD;
?>

<form action="pereschet.php" method="post" style="position: absolute; left: 75px; top: 20px; width: 700px; height:700px;">
             <p style="position: absolute; left: 65px; top: 65px; font-size:14px; font-weight: bold;"> Пересчет услуг <br></p>
                          
            <div class="second">
            <p>Услуги <br>
                ГВС:<br> тариф: <? echo $tarifGVS; ?> <br> предыдущие показания
                <input type="text" name="pokGVS" size="10px" value="<? echo $pokGVS; ?>"><br>
                текущие показания 
                <input type="text" name="tekpokGVS" size="10px" value="<? echo $tekpokGVS; ?>">
                Итого по услуге
                <? echo $itogGVS; ?>
                <br> <br>
                ХВС:<br> тариф: <? echo $tarifHVS; ?> <br>предыдущие показания
                <input type="text" name="pokHVS" size="10px"value="<? echo $pokHVS; ?>"><br>
                текущие показания 
                <input type="text" name="tekpokHVS" size="10px" value="<? echo $tekpokHVS; ?>">
                Итого по услуге
                <? echo $itogHVS; ?>
                <br> <br>
                Водоотведение:<br> тариф: <? echo $tarifVodotv; ?> <br>предидущие показания 
                <input type="text" name="pokVOD" size="10px" value=" <? echo $vodootv; ?>" ><br>
                текущие показания 
                <input type="text" name="tekpokVOD" size="10px" value="<? echo $tekvodootv; ?>">
                Итого по услуге
                <? echo $itogVOD; ?>
                <br> <br>
                Электричество:  <br> 
                тариф ночь:  <br>
                тариф день:  <br>
                однотарифный:  <br>
                ИТОГО:   <? echo $itogo; ?><br>
            </div>
             <p>
                 <input type="submit" name="itogo" value="Пересчитать"> 
             </p>
            </form>
    </body>
</html>