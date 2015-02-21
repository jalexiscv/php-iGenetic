<?php 
//GAlgo a Simple Genetic Algorithm Library 
//Author : Ravindu Thaveesha(thaveesha.ravindu2@gmail.com) 
//Date : 6/2/15 

//This program is free software: you can redistribute it and/or modify 
//it under the terms of the GNU General Public License as published by 
//the Free Software Foundation, either version 3 of the License, or 
//(at your option) any later version. 
// 
//This program is distributed in the hope that it will be useful, 
//but WITHOUT ANY WARRANTY; without even the implied warranty of 
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
//GNU General Public License for more details. 
// 
//You should have received a copy of the GNU General Public License 
//along with this program. If not, see http://www.gnu.org/licenses/. 

class GAlgo{ 
    
    var $population; 
    var $generations; 
    var $fitnessFunction; 
    //var $crossoverProbability; 
    var $mutationProbability; 
        
    //The most fit members of each generation are guaranteed to be selected. 
    function elitistSelection($objs, $fitnessFunction, $limit = 2) 
    { 
        foreach($objs as $key => $obj) 
        { 
            $allSelection[] = array($obj,$fitnessFunction($obj)); 
            if ($allSelection[$key][1] != 0) 
            { 
                $selection[] = $allSelection[$key]; 
            } 
            
        } 
    
        if(!empty($selection)) 
        { 
            usort($selection, function($a, $b) 
            { 
                if ($a[1] == $b[1]) return 0; 
                return ($a[1] < $b[1]) ? 1 : -1; 
            }); 
        } 

        if(!empty($selection)) 
        { 
            $selection = array_slice($selection,0,$limit); 
        } 
        
        if(empty($selection)) return $selection; 
        
        foreach ($selection as $sel) 
        { 
            $fitMembers[] = $sel[0]; 
        } 
        
        return $fitMembers; 
    } 
    
    //crossover 
    public function crossover($objs, $point) 
    { 
        $children = array(); 

        if(empty($objs)) return $children; 
        
        for ($i=0; $i <= count($objs) - 2; $i = $i+2) 
        { 
            $couples[] = array_slice($objs, $i, 2); 
        } 
        
        foreach($couples as $couple) 
        { 
            if(isset($couple[0])) 
            { 
                $individual1 = $couple[0]; 
                $individual2 = $couple[1]; 
                
                $individualTemp1 = $couple[0]; 
                $individualTemp2 = $couple[1]; 

                //change individual elements 
                array_splice($individual1, -$point, $point, array_slice($individualTemp2, -$point)); 
                array_splice($individual2, -$point, $point, array_slice($individualTemp1, -$point)); 
     
                //check individual 1 values, same or not 
                $individualValues1 = array(); 
                foreach($individual1 as $objIndividual1) 
                { 
                    $propertyValue1 = array(); 
                    $obj1Vars = get_object_vars($objIndividual1); 
                    foreach ($obj1Vars as $property1 => $value1) 
                    { 
                        $propertyValue1[] = $value1; 
                    } 
                    
                    $individualValues1[] = $propertyValue1; 
                    
                } 
                
                //check individual 2 values, same or not 
                $individualValues2 = array(); 
                foreach($individual2 as $objIndividual2) 
                { 
                    $propertyValue2 = array(); 
                    $obj2Vars = get_object_vars($objIndividual2); 
                    foreach ($obj2Vars as $property2 => $value2) 
                    { 
                        $propertyValue2[] = $value2; 
                    } 
                    
                    $individualValues2[] = $propertyValue2; 
                } 
                
                //if values not same 
                if((count(array_unique($individualValues1, SORT_REGULAR)) != 2) && (count(array_unique($individualValues2, SORT_REGULAR)) != 2)) 
                { 
                    $children[] = $individual1; 
                    $children[] = $individual2; 
                } 
            } 
            
        } 
        
        //debug($children); 
        return $children; 
    } 
    
    //mutation 
    function mutation(&$objs) 
    { 
        //mutation count 
        $childrenCount = ceil(($this->mutationProbability/100) * count($objs)); 
        
        //randomally select to mutation 
        if(!empty($childrenCount)) 
        { 
            $randomKey = array_rand($objs, $childrenCount); 
        } 
        $randomSelect[] = $objs[$randomKey]; 
    
        foreach($randomSelect as $single) 
        { 
            if(!empty($single)) 
            { 
                $singleLength = count($single); 
                $part1 = array_slice($single,1); 
                $part2 = array_slice($single,-$singleLength,1); 
                $single = array_merge($part1,$part2); 
            } 
        } 
    } 
        
    //run 
    function evolve() 
    { 
        for ($i = 0; $i < $this->generations + 1; $i++) 
        { 
            $couples = $this->elitistSelection($this->population,$this->fitnessFunction,10); 
            $children = $this->crossover($couples,2); 
            $this->mutation($children); 
            $this->population = $children; 
        } 
        
        //select most suitable value 
        debug($this->population[0]); 
    } 
         
} 

?> 
