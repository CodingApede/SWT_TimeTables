<?php
require 'class.swt_timetables.php';

$timetable= new swt_timetables();

$timetable->addStation("23604");
$timetable->addStation("23004");

print_r($timetable->getStationArray());
echo"<br /><br /><br />";
$timetable->getDataFromSWT();
