<?php 
require_once("connection.php");
require_once("individual.php");
require_once("algorithm.php");
require_once("fitnesscalc.php");
class gas
{
	public $save = array();// mang dung de luu cac phuong an toi uu qua moi lan di truyen
	public $fitness =array();
	
	public function solOpstooimal()
	{
		for($i=1;$i<=531;$i++)
		{
		$indiv[$i]= new individual();
		$algo = new algorithm();
		$indiv[$i]->generateIndividual($i);
		$indiv[$i]->randomSolution();
		$indiv[$i]->getSortFitness();
		if($i !=1 && $i != 531)
		{
			$indiv[$i]->setSolution(0,$save[$i-1]);// set lai gia tri cho phuong an dau tien
		}
		$save[$i]=$algo->evolvePopulation($indiv[$i]);
		if($i==531)
		{
			$this->fitness=$algo->evolvePopulation($indiv[$i]);	
		}
		
		}
		
		return $this->fitness;	
	}
}

$gas= new gas();
$starttime = microtime(true);
$gas->solOpstooimal();
$a = array();
for($i=0; $i < sizeof($gas->fitness); $i++)
{
	$a[$i] = (float)$gas->fitness[$i];
}
$query1 = "INSERT INTO fitness(district,headage,totnumr,occuptn,edulevel,houstyle,sepgstrm,
										sepbedrm,gfa,plotarea,btlyear,frontage,centdis,electric,
										plumbing,wastcoll,security,schooqlt,storeys,hougrade,hpricvnd)
										VALUES ($a[0],$a[1],$a[2],$a[3],$a[4],$a[5],$a[6],$a[7],$a[8],$a[9],$a[10],$a[11],$a[12],
											$a[13],$a[14],$a[15],$a[16],$a[17],$a[18],$a[19],$a[20])";
pg_query($query1);

$finishtime = microtime(true);
echo "<br/><br/>";
echo "Execution time: ".($finishtime-$starttime);
echo "<br/><br/>";

?>