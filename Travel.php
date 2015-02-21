<?php 

//problem, 
//Try to find suitable three cities by given cities using interest percentage of users 
//and cities adventure, historical and environmental values to arrange trip. 

require_once('GAlgo.class.php'); 

//object class 
class City { 
    var $adventure; 
    var $history; 
    var $enviorment; 
     
    function City($adventure=0,$history=0,$enviorment=0) { 
        $this->adventure = $adventure; 
        $this->history = $history; 
        $this->enviorment = $enviorment; 
    } 
} 

//assume total of properties = 10; 
$anuradhapura = new City(1,8,1); //32 
$nuwaraeliya = new City(4,1,5); //36 
$mahanuwara = new City(1,6,2); //27 
$sinharaja = new City(0,2,7); //13 
$mathara = new City(5,2,3); //44 
$kataharagama = new City(2,3,5); //28 
$polonnaruwa = new City(1,3,7); //27 
$hikkduwa = new City(6,0,4); //46 
$galle = new City(5,1,4); //42 
$amapara = new City(2,4,4); //30 

//town lists 
$towns = array($anuradhapura,$nuwaraeliya,$mahanuwara,$sinharaja,$mathara,$kataharagama,$polonnaruwa,$hikkduwa,$galle, $amapara); 

//select random population 
for ($i = 0; $i < 10 ; $i++) 
{ 
    foreach(array_rand($towns, 3) as $key){ 
        $objects[] = $towns[$key]; 
    } 
    
    $population[] = array_slice($objects, $i, 3); 
} 


//This will be the fitness function. 
function fitnessFunction($obj) { 
    
    $adventurePrecentage = 7; 
    $enviormentPrecentage = 3; 
    $historyPrecentage = 1; 
    
    foreach($obj as $key => $objs){ 
        $fitnessValue += (($objs->adventure * $adventurePrecentage) + ($objs->history * $historyPrecentage) + ($objs->enviorment * $enviormentPrecentage) ); 
    } 
    
    return $fitnessValue; 
} 

$galgo = new GAlgo(); 

$galgo->population = $population; 
$galgo->generations = 10; 
$galgo->mutationProbability = 10; 
$galgo->fitnessFunction = 'fitnessFunction'; 
$galgo->evolve(); 


//no use for genetic 
function debug($x) { 
    echo "<pre style='border: 1px solid black'>"; 
    print_r($x); 
    echo '</pre>'; 
} 

?> 
