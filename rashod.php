<?php

		$BTS_ras1_today = pg_query($conn, "SELECT v1i FROM archdata_bts2 WHERE devid = $BTS1 AND dt = '$date'");
		$BTS_ras1_today = pg_fetch_row ($BTS_ras1_today);
		echo $BTS_ras1_today;
		$BTS_ras1_start = pg_query($conn, "SELECT v1i FROM archdata_bts2 WHERE devid = $BTS1 AND dt = '$date0'");
		$BTS_ras1_start = pg_fetch_row ($BTS_ras1_start);
		$BTS_ras1 = $BTS_ras1_today - $BTS_ras1_start;

	echo $BTS_ras1;
				?>