<?php
/*******************************
 * 
 * @author Adam Pfeilsticker
 * Codingape.de
 * 24.6.2016
 * Version 0.1
 * 
 * Class to extract depature times of Busses at Tübingen, Germany.
 * Just needed parameters ar busstations ID and busstations Name.
 */


class swt_timetables{
	
	private $stations= array();
	
	function swt_timetables(){
		
	}
	
	/**
	 * Get the Times for all added busstations
	 * @return array of busline, destination, timedeltas in minutes, and busstation
	 */
	function getDataFromSWT(){
		$alltimes=array();
		foreach($this->getStationArray() as $staion){
			libxml_use_internal_errors(true);
			$html = file_get_contents('http://www.swtue.de/abfahrt.html?halt='.$staion['id']);
			$dom = new DOMDocument();
			$dom->loadHTML($html);
			//print_r($html);
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
										array_push($cells, $time,$staion['name']);
										break;
							}
							$tmp++;
							
						
						
					}
					array_push($row, $cells);
				}
			libxml_use_internal_errors(false);
			
			//print_r($row);
			$alltimes=array_merge($row,$alltimes);
			
			
		}
		//$this->sortTimes($alltimes[1],'3');
		//print_r($alltimes);
		return $alltimes;
	}
	
	/**
	 * not used at the moment
	 * @param  $array
	 * @param  $key
	 */
	private function sortTimes($array, $key){
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
	
	/**
	 * Add a Station for timetables
	 * @param $StationID ,the ID of a station
	 * @param $StationName ,the name of a station
	 */
	function addStation($StationID,$StationName){
		$tmp=array();
		$tmp['id']=$StationID;
		$tmp['name']=$StationName;
		array_push($this->stations, $tmp);
	}
	
	/**
	 * Remove all stations from array
	 */
	function removeAllStations(){
		$this->stations=array();
	}
	/**
	 * Remove last stations from array
	 */
	function removeLastStation(){
		array_pop($this->stations);
	}
	
	/**
	 * Retunrs the arry of stations
	 * @return array of stations
	 */
	function getStationArray(){
		return $this->stations;
	}
	
	
}
