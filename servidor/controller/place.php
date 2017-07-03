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

	public function delegateRoute($code, $codes,$req){
		switch ($code) {
			case $codes["get_place"]:
				return $this->showPlace($req);
			break;
		
			case $codes["search_place"]:
				return $this->searchPlace($req);
			break;
			
			default:
				return self::PATTERN_ERROR;
			break;
		}
	}

	/* Exibe Local pelo ID
	* @receive $req {$_REQUEST} => (id_place)
	* @returns $res {Function Response}
	*/
	public function showPlace($req){

		$query = "id_place = '{id_place}'";
		$itens = array("{id_place}" => $req["id_place"]);

		return $this->_getPlace($query,$itens);
	}


	/* Exibe Local pelo Nome
	* @receive $req {$_REQUEST} => (query)
	* @returns $res {Function Response}
	*/
	public function searchPlace($req){
		
		$query = " name_place LIKE '{query}%' OR name_place LIKE '%{query}' OR name_place LIKE '%{query}%' ";
		//$itens = array("{query}" => base64_decode($req["query"]));
		$itens = array("{query}" => $req["query"]);

		return $this->_getPlace($query,$itens);
	}


	/*
	* Acessa o banco de dados e recupera o Place (local)
	* @receive $where {where clause} => with key to replace
	* @receive $wherekey {Key to replace in where clause}
	* @returns $res {Function Response}
	*/
	protected function _getPlace($where,$itemMap){
		$res = "";
		$bd = new bd_manip();

		$bd->setTable("show_place");
		$bd->setOrder("id_place");
		$bd->setFormatedKey($where,$itemMap);
		
		return $this->_makeLambdaConsult($bd,function($bd){
			$result = $bd->consultAllByType();

			//Formatting
			$result = $result[0];
			$result["location"] = array("lat" => $result["lat"], "lng" => $result["lng"]);

			return $result;
		});
	}
}
?>