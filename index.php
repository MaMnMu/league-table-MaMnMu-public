<?php 
	require "vendor/autoload.php";
	
	use eftec\bladeone\bladeone;
	
	$Views = __DIR__ . '\Views';
	$Cache = __DIR__ . '\Cache';
	
	$Blade = new BladeOne($Views, $Cache);
        
        $post = filter_input_array(INPUT_POST);
        $jorn = filter_input(INPUT_POST, 'mostrarjorn');
        $clas = filter_input(INPUT_POST, 'mostrarclas');

        session_start();
        
        if (empty($post)) {
            
            echo $Blade->run('index');
            
        } else if (isset($jorn)) {
            
            $strequipos = filter_input(INPUT_POST, 'equipos');
            $arrequipos = explode(",", $strequipos);
            $_SESSION['equipos'] = $arrequipos;
            
            echo $Blade->run('jornadas', ['arrequipos' => $arrequipos]);
            
        } else if (isset($clas)) {
            
            $arrresult = filter_input(INPUT_POST, 'arrequipos', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);
            $equipos = $_SESSION['equipos'];
            
            $clasif = array();
            foreach ($arrresult as $local => $partido) {
                $clasif[$local] = array();
                $clasif[$local]['puntos'] = 0;
                $clasif[$local]['golesfavorTotal'] = 0;
                $clasif[$local]['golescontraTotal'] = 0;
                $clasif[$local]['golaverage'] = 0;
            }
            
            // Cálculo de puntos y goles a favor y en contra totales
            foreach ($arrresult as $local => $partido) {
                foreach ($partido as $visitante => $result) { 
                    if ($arrresult[$local][$visitante]["golfavor"] > $arrresult[$local][$visitante]["golcontra"]) {
                        $clasif[$local]['puntos'] += 3;
                        $clasif[$visitante]['puntos'] += 0;
                    } else if ($arrresult[$local][$visitante]["golfavor"] < $arrresult[$local][$visitante]["golcontra"]) {
                        $clasif[$local]['puntos'] += 0;
                        $clasif[$visitante]['puntos'] += 3;
                    } else {
                        $clasif[$local]['puntos'] += 1;
                        $clasif[$visitante]['puntos'] += 1;
                    } 
                    $clasif[$local]['golesfavorTotal'] += $arrresult[$local][$visitante]['golfavor'];
                    $clasif[$visitante]['golesfavorTotal'] += $arrresult[$local][$visitante]['golcontra'];
                    $clasif[$local]['golescontraTotal'] += $arrresult[$local][$visitante]['golcontra'];
                    $clasif[$visitante]['golescontraTotal'] += $arrresult[$local][$visitante]['golfavor'];
                }  
            } 
            
            // Cálculo de gol average
            foreach ($clasif as $local => $resultFinal) {
                $clasif[$local]['golaverage'] = $clasif[$local]['golesfavorTotal'] - $clasif[$local]['golescontraTotal'];
            }
            
            $puntos = array_column($clasif, 'puntos');
            $golaverage = array_column($clasif, 'golaverage');
            $golesfavorT = array_column($clasif, 'golesfavorTotal');
            $golescontraT = array_column($clasif, 'golescontraTotal');
            
            array_multisort($puntos, SORT_DESC, SORT_NUMERIC, $golaverage, SORT_DESC, SORT_NUMERIC, $equipos, SORT_STRING, $golesfavorT, $golescontraT, $clasif); 
            
            echo $Blade->run('clasificacion', ['clasif' => $clasif]); 
            
        } else {
            
            header("Location: index.php");
            
        }  

