<?php 
require_once("individual.php");

class algorithm
{
	public $sortResult=array();
	
	public function random()
	{
		$posit = (float)rand()/(float)(getrandmax());	
		return $posit;
	}
	//phuong thuc cua thuat toan di truyen
	public function evolvePopulation($newPop)
	{
		for($i=$newPop->size_param/2;$i < $newPop->size_param;$i++) //size_param: so cac phuong an
		{
			if( $this->random() < 0.5)
			{
				$sol1=$this->selectSol($newPop);
				$sol2=$this->selectSol($newPop);
				if($sol1 === $sol2){
					$sol2=$this->selectSol($newPop);	
				}
				$temp1=$this->crossover($sol1,$sol2);
				$newPop->setSolution($i,$temp1);
				
			}else{
				$sol3=$this->selectSol($newPop);
				$temp2=$this->mutate($sol3);
				$newPop->setSolution($i,$temp2);
			}
		
		}
		$result=$newPop->getSortFitness();
		return $result[0];	
	}
	// phuong thuc lai giua 2 phuong an
	private function crossover($sol1,$sol2)
	{
		$newSols=array();// tao mang de luu con sau khi lai
		$temp=0;
		$pos=round((sizeof($sol1)-1) * $this->random());
		//lay mot nua cua cha
		for($i=0;$i<$pos;$i++)
		{
			$newSols[$i]=$sol1[$i];
			$temp +=$sol1[$i];
		}
		//lay mot nua cua me
		for($j=$pos;$j<sizeof($sol2);$j++)
		{
			$newSols[$j]=$sol2[$j];
			$temp +=$sol2[$j];	
		}
		
		//chuan hoa con
		for($k=0;$k<sizeof($newSols);$k++)
		{
			$newSols[$k]=$newSols[$k]/$temp;
		}
		return $newSols;
	}
	//phuong thuc dot bien phuong an
	private function mutate($sol)
	{
		$pos1=round((sizeof($sol)-1) * $this->random());//lay vi tri thu nhat de dot bien
		$pos2=round((sizeof($sol)-1) * $this->random());//lay vi tri thu hai de dot bien
		$temp=$sol[$pos1];
		$sol[$pos1]=$sol[$pos2];
		$sol[$pos2]=$temp;	
	}
	//phuong thuc chon mot phuong an trong tap cac phuong an
	public function selectSol($newPop)
	{
		$posSol=rand(0,round($newPop->size()/2));//$newPop->getSortFitness() : lay ra tap cac phuong an duoc sap xep tang dan cua fitness
		$popSol=$newPop->getSortFitness();	
		return $popSol[$posSol];
	}
	
	
}

?>