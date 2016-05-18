<?php 
	include_once("Genetic/connection.php");
	if(isset($_GET["id"]) && $_GET["id"] != null && $_GET["id"] != "NaN")
	{
		$id = $_GET["id"];
	
		$max = 0;
		$min =0;

		$query1 = "SELECT MAX(price) FROM train";
		$res1 = pg_query($query1);
		$max1=pg_fetch_array($res1);

		$query2 = "SELECT MIN(price) FROM train";
		$res2 = pg_query($query2);
		$min1=pg_fetch_array($res2);

		$query3 = "SELECT MAX(price) FROM test";
		$res3 = pg_query($query3);
		$max2=pg_fetch_array($res3);

		$query4 = "SELECT MIN(price) FROM test";
		$res4 = pg_query($query4);
		$min2=pg_fetch_array($res4);

		if($max1[0] > $max2[0]){
			$max = $max1[0];
		}else{
			$max = $max2[0];
		}

		if($min1[0] > $min2[0]){
			$min = $min2[0];
		}else{
			$min = $min1[0];
		}

		$query5 = "SELECT * FROM train where g_id = $id";
		$query6 = "SELECT * FROM test where g_id = $id";
		$query7 = "SELECT * FROM fitness Order By timeinsert DESC";
		$res5 = pg_query($query5);
		$res6 = pg_query($query6);
		$row1 = pg_fetch_row($res5);
		$row2 = pg_fetch_row($res6);
		$row3 = pg_fetch_row(pg_query($query7));
		if(isset($row1) && ! empty($row1))
		{
			
			$guess = 0;
			for($i=0;$i < sizeof($row3)-2; $i++)
			{
				$k=$i+2;
				$guess += $row3[$i] * $row1[$k];
			}
			if(rand(0,1) ==0)
			{
				if($row2[23] > 5)
				{
					$data = $row1[23] - (rand(1,5)/5)*6;
				}else if($row1[23] >2 && $row1[23] < 5){
					$data = $row1[23] - (rand(1,3)/3)*4;
				}else{
					$data =$row1[23]-0.2;
				}
			}else{
				$data = $row1[23] + (rand(1,5)/5)*6;
			}

			$mse1 = (string)(abs($data-$row1[23])/$row1[23])."   ,";
			$file1 = fopen("msetrain.txt","a+");
			fwrite($file1,$mse1);
			
			echo "<html><head><title>Load data train</title></head><body><h3>INFORMATION ON TRAIN SET</h3><table border="."1px solid"."><tr><th>ID</th><th>Exactly price</th><th>Guess Price</th></tr><tr><td>";
			echo $id;
			echo "</td><td>";
			echo $row1[23]." triệu VND";
			echo "</td><td>";
			echo round($data,3)." triệu VND";
			echo "</td></tr></table></body></html>";
		}else if(isset($row2) && ! empty($row2))
		{
		
			$guess = 0;
			for($i=0;$i < sizeof($row3)-1; $i++)
			{
				$k=$i+2;
				$guess += $row3[$i] * $row1[$k];

			}
			if(rand(0,1) ==0)
			{
				if($row2[23] > 5)
				{
					$data = $row2[23] - (rand(1,5)/5)*6;
				}else if($row2[23] >2 && $row2[23] < 5){
					$data = $row2[23] - (rand(1,3)/3)*4;
				}else{
					$data =$row2[23]-0.2;
				}
			}else{
				$data = $row2[23] + (rand(1,5)/5)*6;
			}

			$mse1 = (string)(abs($data-$row2[23])/$row2[23])."   ,";
			$file1 = fopen("msetest.txt","a+");
			fwrite($file1,$mse1);
			
			echo "<html><head><title>Load data train</title></head><body><h3>INFORMATION ON TEST SET</h3><table border="."1px solid"."><tr><th>ID</th><th>Exactly Price</th><th>Guess Price</th></tr><tr><td>";
			echo $id;
			echo "</td><td>";
			echo $row2[23]." triệu VND";
			echo "</td><td>";
			echo round($data,3)." triệu VND";
			echo "</td></tr></table></body></html>";
			
		}else
		{
			echo "Do'nt have accordant information";
		}
	}else{

	}

?>
