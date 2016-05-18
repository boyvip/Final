<?php 
	require_once("individual.php");
	
class fitnesscalc
{
	//Tinh Fitness cho tung ca the
	public static function getFitness($individual)
	{
		$fitness = array();
		$solution=$individual->randomSolution();
		for($j=0;$j < sizeof($solution);$j++)
		{	
			if(!isset($fitness[$j]) || $fitness[$j]==0 )//kiem tra xem da tinh fitness chưa
			{
				$temp=0;
				for($i=0;$i<sizeof($individual->size_cols);$i++)
				{
					$temp+=$individual->results[$i] * $solution[$j][$i];// tinh tong xích ma
					
				}
				$fitness[$j]=abs(sqrt(abs(cos($temp)/531))- $individual->y);
			}
		}
		
		return $fitness;
	}	
	
?>
