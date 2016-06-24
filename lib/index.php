<?php
require 'class.swt_timetables.php';

$timetable= new swt_timetables();

$timetable->addStation("23604","Hans Geiger Weg");
$timetable->addStation("23004","Ochsenweide");

//print_r($timetable->getStationArray());
//echo"<br /><br /><br />";
print_r($timetable->getDataFromSWT());