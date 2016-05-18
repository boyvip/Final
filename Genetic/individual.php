<?php 
include_once("connection.php");
include_once("fitnesscalc.php");

class individual
{
	public $size_cols = 22;
	public $size_param=50;
	public $param=array();
	public $y=0;
	public $fitness = array();
	public $results=array();
	
	//Random 50 phuong an 
	public function randomSolution()
	{
		for($j=0;$j < $this->size_param;$j++)
		{
			$q=0;
			for($i=0;$i < $this->size_cols-1;$i++)
			{
				$this->param[$j][$i]=(float)rand()/(float)getrandmax();
				$q +=$this->param[$j][$i];
			}
			for($t=0;$t < $this->size_cols-1;$t++)
			{
				
				$this->param[$j][$t]=$this->param[$j][$t]/$q;
			}
		
		}
		return $this->param;
	
	}
	//Lay ra cac thuoc tinh cua tung ca the trong tap training
	public  function generateIndividual($id)
	{
		
		$sql="SELECT * FROM train WHERE id=$id";
		$result=pg_query($sql);
		while($row = pg_fetch_array($result)){	
			for($i=0;$i<=$this->size_cols-2;$i++)
			{
				if($i==$this->size_cols-2)
				{
					$this->y=$row[$i+2];	
				}else{
					$this->results[$i]=$row[$i+2];	
				}
			}
		}
		
		return $this->results;
	}
	//Lay ra cac thuoc tinh cua tung ca the trong tap testing
	
	public  function generateIndividual1($id)
	{
		
		$sql="SELECT * FROM test WHERE id=$id";
		$result=pg_query($sql);
		while($row = pg_fetch_array($result)){
			
			for($i=0;$i<=$this->size_cols-2;$i++)
			{
				if($i==$this->size_cols-2)
				{
					$this->y=$row[$i+2];	
				}else{
					$this->results[$i]=$row[$i+2];	
				}
			}
		}
		return $this->results;
	}
	
	// Lay ra phuong an thu index
	 public function getSolution($index) {
        return $this->param[$index];
    }
	//Set lai gia tri cua phuong an thu index
    public function setSolution($index,$value) {
        $this->param[$index] = $value;
        $this->fitness[$index] = 0;
    }
	public function size() {
		return count($this->param);
	}
	//Lay ra fitness cua moi ca the
	public function getFitness(){
		
		$this->fitness=fitnesscalc::getFitness($this);	
		return $this->fitness;
	}	
	// Lay ra tat ca cac phuong an da duoc sap xep theo thu tu fitnes tang dan
	public function getSortFitness()
	{
		
		$this->getFitness();
		$temps= array();
		for($i=0;$i<sizeof($this->fitness);$i++)
		{
			$temps[$i]=$i;
		}
		for($j=0;$j<sizeof($temps)-1;$j++)
		{
			for($k=$j+1;$k<sizeof($temps);$k++)
			{
				if($this->fitness[$k] < $this->fitness[$j])
				{
					
					$t1=$this->fitness[$k];
					$this->fitness[$k]=$this->fitness[$j];
					$this->fitness[$j]=$t1;
					
					$t2=$temps[$k];
					$temps[$k]=$temps[$j];
					$temps[$j]=$t2;
				}	
			}	
		}
		$this->param=array_combine($temps,$this->param);
		ksort($this->param);
		
		return $this->param;
	}
	
	
}
