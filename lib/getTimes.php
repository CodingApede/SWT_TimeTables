<?php
require 'class.swt_timetables.php';

$timetable= new swt_timetables();

$timetable->addStation("23604","Hans Geiger Weg");
$timetable->addStation("23004","Ochsenweide");
$timetable->addStation("20704","Wanne Kusnthalle");

echo json_encode($timetable->getDataFromSWT());