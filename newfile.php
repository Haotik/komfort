<?php
function findNb($m) {
    $n = 0;
    for ($i=0; $n < $m; $i++) {
        $n = pow($i,3) +$n;
    }
    $i--;
    echo $i; 
}

findNb(1071225);