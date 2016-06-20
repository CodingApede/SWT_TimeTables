<?php
class swt_timetables{

	private $stations= array();

	function swt_timetables(){

	}


	function getDataFromSWT(){
		$alltimes=array();
		foreach($this->getStationArray() as $staionId){
			libxml_use_internal_errors(true);
			$html = file_get_contents('http://www.swtue.de/abfahrt.html?halt='.$staionId);
			$dom = new DOMDocument();
			$dom->loadHTML($html);
			$row = array();
				foreach($dom->getElementsByTagName('tr') as $tr){
					$cells=array();
					$tmp=0;
					foreach($tr->getElementsByTagName('td') as $td){
							switch($tmp){
								case 0:
										array_push($cells, $td->nodeValue);
										break;
								case 1:
										array_push($cells, $td->nodeValue);
										break;
								case 2:
										//echo "Time1: ".$td->nodeValue."<br />";
										$time= str_replace(' ', '', $td->nodeValue);

										$time_arr=explode("h", $time);
										if(sizeof($time_arr)>1){
											$time_arr[0]=$time_arr[0]*60;
											$time_arr[1]=preg_replace("/([^0-9\/+]+)/", "", $time_arr[1] );
											$time=$time_arr[0]+$time_arr[1];
										}else{
											$time=preg_replace("/([^0-9\/+]+)/", "", $time_arr[0] );
										}
										//echo "Time2: ".$time."<br />";
										array_push($cells, $time);
										break;
							}
							$tmp++;



					}
					array_push($row, $cells);
				}
			libxml_use_internal_errors(false);

			print_r($row);
			$alltimes=array_merge($row,$alltimes);

			echo "<br /><br />";
		}
		//$this->sortTimes($alltimes[1],'3');
		print_r($alltimes);
	}

	private function sortTimes(&$array, $key){
		$sorter=array();
		$ret=array();
		reset($array);
		foreach ($array as $ii => $va) {
			$sorter[$ii]=$va[$key];
		}
		asort($sorter);
		foreach ($sorter as $ii => $va) {
			$ret[$ii]=$array[$ii];
		}
		$array=$ret;
		print_r($array);
	}


	function addStation($StationID){
		array_push($this->stations, $StationID);
	}

	function removeAllStations(){
		$this->stations=array();
	}

	function removeLastStation(){
		array_pop($this->stations);
	}

	function getStationArray(){
		return $this->stations;
	}


}

class depatureOffset{
	private $offset;
	private $line;
	private $stationName;
	private $direction;

	function depatureOffset(){

	}

	function setOffset($Offset){
		$this->offset=$Offset;
	}

	function getOffset(){
		return $this->offset;
	}

	function setLine($Line){
		$this->line=$Line;
	}

	function getLine(){
		return $this->line;
	}

	function setStationName($StationName){
		$this->stationName=$StationName;

	}

	function getStationName(){
		return $this->stationName;
	}

	function setDirection($Direction){
		$this->direction=$Direction;
	}

	function getDirection(){
		return $this->direction;
	}

}
