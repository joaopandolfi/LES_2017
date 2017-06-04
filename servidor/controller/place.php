<?php
	/*
		Created by João Carlos Pandolfi Santana
		
		This file is responsible to control Place Ativityes

		System libs useds:
			Using json_decode() for decode json strings
			Using json_encode() for encode json arrays
		
		Personalized libs useds:
			Using bd_manip for control database
	*/

class Place extends Controller{
	
	/* Exibe Local pelo ID
	* @receive $req {$_REQUEST} => (id_place)
	* @returns $res {Function Response}
	*/
	function _showPlace($req){
		$res = "";
		$bd = new bd_manip();
		
		$id_place = $bd->removeSuspectsFromString($req["id_place"]);

		$bd->setTable("show_place");
		$bd->setOrder("id_place");
		$bd->setKey("id_place = '".$id_place."'");
		
		return $this->_makeLambdaConsult($bd,function(){
			$result = $bd->consultAllByType();

			//Formatting
			$result = $result[0];
			$result["location"] = array("lat" => $result["lat"], "lng" => $result["lng"]);

			return $result;
		});
	}

?>