<div class="row">
	<div class="col-md-12 visible-md visible-lg">
		<table class="events-list ">
		<thead>
     	<tr>
        	<th>Tanggal</th>
            <th>Jenis Diklat</th>
            <th>Wilayah</th>
            <th>Tempat</th>
            <th>Waktu</th>
            <th>Sasaran Peserta</th>
            <th>Fasilitator</th>
        </tr>
        </thead>
        <tbody>	
		<?php

		$database->query($sql_agenda);
		$database->execute();
		$nResults = $database->rowCount();
		if($nResults > 0){
			$i = 0;
			while($row = $database->fetch()){
				if($i <= 4){
					$output ="<tr>";
						$output .="<td>";
							$output .="<div class=\"event-date\">";
								$phpdate = strtotime( $row['tanggal'] );
		          				$mysqldate1 = date( 'd ', $phpdate );
								$mysqldate2 = date( 'M ', $phpdate );
								$output .="<div class=\"event-day\">{$mysqldate1}</div>";
								$output .="<div class=\"event-month\">{$mysqldate2}</div>";
							$output .="</div>";
						$output .="</td>";
						$output .="<td>{$row['name']}</td>";

						if($row['wilayah']==1)
							$output .="<td class=\"event-venue \">Barat</td>";
						else if($row['wilayah']==2)
							$output .="<td class=\"event-venue \">Tengah</td>";
						else if($row['wilayah']==3)
							$output .="<td class=\"event-venue \">Timur</td>";
						else
							$output .="<td class=\"event-venue \">-</td>";

						$output .="<td class=\"event-venue hidden-xs\">{$row['tempat']}</td>";
						$startTimeStamp = strtotime($row['tanggal']);
						$endTimeStamp = strtotime($row['tanggal2']);
						$timeDiff = abs($endTimeStamp - $startTimeStamp);
						$numberDays = $timeDiff/86400;
						$numberDays = intval($numberDays);

						$output .="<td class=\"event-venue \">{$numberDays} Hari</td>";
						if(!empty($row['sasaran']))
							$output .="<td class=\"event-venue \">{$row['sasaran']}</td>";
						else
							$output .="<td class=\"event-venue \">-</td>";
						if(!empty($row['fasilitator']))
							$output .="<td class=\"event-venue \">{$row['fasilitator']}</td>";
						else
							$output .="<td class=\"event-venue \">-</td>";
						
						$output .="<td >&nbsp</td>";
					$output .="</tr>";
					
					if($fullpage == 0)
						$i++;
					
					echo $output;	
				}	
			}
			if($fullpage == 0){
				if($nResults > 5){
					$output2 ="<tr >";
						$output2 .="<td colspan=\"7\"><a href=\"agenda_diklat.php\" class=\"btn btn-grey btn-block\">Selengkapnya &raquo</a></td>";
					$output2 .="</tr>";
					echo $output2;
				}
			}	
		}else{
			$output ="<tr>";
				$output .="<td colspan=\"7\"><a class=\"btn btn-grey btn-block\">Belum terdapat agenda...</a></td>";
			$output .="</tr>";
			echo $output;
		}


		?>
		</tbody>
		</table>
	</div>
	<div class="col-sm-12 visible-sm visible-xs">
				<?php

		$database->query($sql_agenda);
		$database->execute();
		$nResults = $database->rowCount();
		if($nResults > 0){
			$i = 0;
			while($row = $database->fetch()){
				if($i <= 4){
					$output ="<div class=\"well well-sm\">";
						$phpdate = strtotime( $row['tanggal'] );
          				$mysqldate1 = date( 'd ', $phpdate );
						$mysqldate2 = date( 'M ', $phpdate );
						$output .="<b>Tanggal</b> {$mysqldate1} {$mysqldate2}<br/>";
						$output .="<b>Jenis Diklat :</b> {$row['name']}<br/>";
						if($row['wilayah']==1)
							$output .="<b>Wilayah :</b> Barat<br/>";
						else if($row['wilayah']==2)
							$output .="<b>Wilayah :</b> Tengah<br/>";
						else if($row['wilayah']==3)
							$output .="<b>Wilayah :</b> Timur<br/>";
						else
							$output .="<b>Wilayah :</b> -<br/>";

						$output .="<b>Tempat :</b> {$row['tempat']}<br/>";
						$startTimeStamp = strtotime($row['tanggal']);
						$endTimeStamp = strtotime($row['tanggal2']);
						$timeDiff = abs($endTimeStamp - $startTimeStamp);
						$numberDays = $timeDiff/86400;
						$numberDays = intval($numberDays);
						$output .="<b>Waktu :</b> {$numberDays} Hari<br/>";
						$output .="<b>Sasaran :</b> {$row['sasaran']}<br/>";
						$output .="<b>Fasilitator :</b> {$row['fasilitator']}<br/>";
					$output .="</div>";
					
					if($fullpage == 0)
						$i++;
					
					echo $output;	
				}	
			}
			if($fullpage == 0){
				if($nResults > 5){
						$output2 ="<a href=\"agenda_diklat.php\" class=\"btn btn-grey btn-block\">Selengkapnya &raquo</a>";
					echo $output2;
				}
			}	
		}else{
			$output ="<div class=\"well well-sm\">";
				$output .="Belum terdapat agenda...";
			$output .="</div>";
			echo $output;
		}
		?>
	</div>
</div>
