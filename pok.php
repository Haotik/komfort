<?php
 //снятие текущих показаний
function send($msg) {
   $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
   
    $len = strlen($msg);

    socket_sendto($sock, $msg, $len, 0, '192.168.0.120', 11000);

    if (false !== ($bytes = socket_read($sock, 2048))) {
       $bytes0 = mb_convert_encoding($bytes,"UTF-8","windows-1251");
       $result = explode(" ",$bytes0);
    } else {
    echo "Dont can read becouse " . socket_strerror(socket_last_error($sock)) . "\n";
    }
    socket_close($sock);
    return $result;
}

//форматирование выходных данных
function format($msg){
  if ($msg !== "null") {
  $length = strlen($msg)-2;
  if ($length == 0) {$answer = "0,".$msg;}
  elseif ($length < 0) {$answer = "0,0".$msg;}
  else {
  $answer = substr($msg,0,$length).",".substr($msg,-2);
  $answer = ltrim($answer, "0");}}
  else {$answer = "неисправен";}
  return $answer;
}
 
 $count=count($chanals);
 for($k=1;$k<$count;$k++){
        $nBTS = $chanals[$k];
        $c=$k-1;
        $chanals0 = $chanals[$c]*4;
        $BTS = "$ipAddres $nBTS $chanals0 0 read ks";
        $resulted[] = send($BTS);
        $k++;
    }
  $SN0=explode("_",$sensors[8]);
  $SN=$SN0[1];
  $Electro = "$ipAddres $rsNum 0 $SN m203read ks";
$resulted[] = send($Electro);

$invent0 = $resulted[0][1];
$invent1 = $resulted[1][1];

$curent0 = format($resulted[0][1]);
$curent1 = format($resulted[1][1]);
if ($d == 4) {
$curent3 = format($resulted[3][1]);
$invent3 = $resulted[3][1];
$curent2 = format($resulted[2][1]);
$invent2 = $resulted[2][1];
$curentEl0 = format($resulted[4][2]);
$curentEl1 = format($resulted[4][3]);
$invent4 = $resulted[4][2];
$invent5 = $resulted[4][3];
}
if ($d == 3) {
    $curent3 =0;
    $curent2 = format($resulted[2][1]);
    $invent2 = $resulted[2][1];
    $invent3 = 0;
 $curentEl0 = format($resulted[3][2]);
$curentEl1 = format($resulted[3][3]); 
$invent4 = $resulted[3][2];
$invent5 = $resulted[3][3];
}
if ($d == 2){
    $curent3 = 'неисправен';
    $curent2 = 'неисправен';
    $invent3 = '-';
    $invent2 = '-';
$curentEl0 = format($resulted[2][2]);
$curentEl1 = format($resulted[2][3]);}
$invent4 = $resulted[2][2];
$invent5 = $resulted[2][3];
if ($d == 0){
    $curent0 = "Неисправен";
    $curent1 = "Неисправен";
    $curent2 = "Неисправен";
    $curent3 = "Неисправен";
    $curentEl0 = "Неисправен";
    $curentEl1 = "Неисправен";
}

for ($i=0;$i<$d;$i++) {
if ($resulted[$i][2] == 1) {$state[$i] = "Саботаж"; $color[$i] = $colorBad;}
}
if ($resulted[$d][5] == "Отключен") {
    $state[4] = "Отключен"; $color[4] = $colorWarning;
    $state[5] = "Отключен"; $color[5] = $colorWarning;
} elseif ($resulted[$d][0] == "null") {
   $state[4] = "Неисправен"; $color[4] = $colorBad;
   $state[5] = "Неисправен"; $color[5] = $colorBad; 
} elseif ($resulted[$d][5] == "Включен") {
   $state[4] = "Включен"; $color[4] = $colorGood;
   $state[5] = "Включен"; $color[5] = $colorGood;
}   