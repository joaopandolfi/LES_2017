<?php
	/*
		Created by João Carlos Pandolfi Santana
		
		This file is responsible to control trip activityes

		System libs useds:
			Using json_decode() for decode json strings
			Using json_encode() for encode json arrays
		
		Personalized libs useds:
			Using bd_manip for control database
	*/

class Trip extends Controller{
	/* ===================================== GET FUNCTIONS ====================================*/

	/* Recupera todas as trips
	* @todo {Adicionar paginacao}
	* @receive $req {$_REQUEST}
	* @returns $res {Funcion Response}
	*/
	function _getAllTrips($req){
		$res = "";
		$bd = new bd_manip();
		
		$bd->setTable("short_route");
		$bd->setOrder("id_trip");

		return $this->_makeLambdaConsult($bd,function($bd){
			return $bd->consultAll();
		});
	}

	/*
	* Recupera trip completa no banco de dados
	* @receive $req {$_REQUEST} => (id_trip)
	* @returns $res {Function Response}
	*/
	function _getTrip($req){
		$res = "";
		$bd = new bd_manip();
		
		$_idTripKey = "id_trip = '".$bd->removeSuspectsFromString($req["id_trip"])."'";

		$bd->setTable("short_route");
		$bd->setOrder("id_trip");
		$bd->setKey($_idTripKey);
		
		try {
			$bd->connectDB();
			$result = $bd->consultAllByType();
			
			//Pictures
			$bd->setTable("trip_images");
			$bd->setOrder("id_trip");
			$bd->setKey($_idTripKey);
			$pictures = $bd->consultAllByType();
			
			//Route
			$bd->setTable("trip_places");
			$bd->setOrder("id_trip");
			$bd->setKey($_idTripKey);
			$route = $bd->consultAllByType();
			

			//Comments
			$bd->setTable("trip_evaluations");
			$bd->setOrder("id_trip");
			$bd->setKey($_idTripKey);
			$comments = $bd->consultAllByType();
			

			$bd->closeConnection();


			//Montando
			$result = $result[0];
			$result["tags"] = array($result["tag"]);
			$result["pictures"] = $pictures;
			$result["comments"] = $comments;

			$response = array("success" => 1,
					"error" => 0,
					"data" => $result
					);

			$res = json_encode($response);
	

		} catch (Exception $e) {
			$res = "{'success':0,'error':'$e',data:{}}";
		}
		
		return $res;
	}


	/* ===================================== CONTROL FUNCTIONS ====================================*/

	/* Usuario curte a trip
	* 
	*/
	function _like($req){
		$res = "";
		/*..code*/
		return $res;
	}

	/* Usuario marca que vai na viagem
	*
	*/
	function _iWill($req){
		$res = "";
		/*..code*/
		return $res;
	}

	/* Usuario marca que quer ir mas n tem grana
	*
	*/
	function _iDontHaveMoney($req){
		$res = "";
		/*..code*/
		return $res;
	}

	/* Usuario avalia a trip
	*
	*/
	function _rateTrip($req){
		$res = "";
		/*..code*/
		return $res;
	}


	/* Retorna as trips do usuário
	*
	*/
	function _userTrips($req){
		$res = "";
		/*..code*/
		return $res;
	}

	/* Cria uma trip
	*
	*/
	function _newTrip($req){
		$res = "";
		/*..code*/
		return $res;
	}


	/* Adciona imagem a trip
	*
	*/
	function _putImage($req){
		$res = "";
		/*..code*/
		return $res;
	}


	/* Adiciona as rotas na trip
	*
	*/
	function _putRoutes($req){
		$res = "";
		/*..code*/
		return $res;
	}

}
?>