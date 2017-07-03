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

	public function delegateRoute($code, $codes,$req){
			switch ($code) {
				case $codes["all_trips"]:
					return $this->getAllTrips($req);
				break;
			
				case $codes["get_trip"]:
					return $this->getTrip($req);
				break;
				
				default:
					//return self::PATTERN_ERROR;
				break;
			}
		}


	/* ===================================== GET FUNCTIONS ====================================*/

	/* Recupera todas as trips
	* @todo {Adicionar paginacao}
	* @receive $req {$_REQUEST}
	* @returns $res {Funcion Response}
	*/
	function getAllTrips($req){
		$res = "";
		$bd = new bd_manip();
		
		$bd->setTable("short_trip");
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
	function getTrip($req){
		$res = "";
		$bd = new bd_manip();
		
		$_idTripKey = "id_trip = '".$bd->removeSuspectsFromString($req["id_trip"])."'";

		$bd->setTable("short_trip");
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
			$result["route"] 	= $route;
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
	* => DESATIVADO
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
	* @receives id_user 	{Id so usuario}
	* @receives title 		{Titulo da trip}
	* @receives short_route	{Rota minimizada}
	* @receives description {Descricao}
	* @returns {base_return}
	*/
	function newTrip($req){
		$bd = new bd_manip();

		$sql = "SELECT new_trip('{id_user}','{title}','{short_route}','{description}');";

		$data  = array('{id_user}' => $req["id_user"],
				'{title}' => $req["title"],
				'{short_route}' => $req["short_route"],
				'{description}' => $req["description"]);

		$bd->setFormatedSql($sql,$data);

		$bd->connectDB();

		$id_trip = $bd->consultAllWithSql();
		$id_trip = array_pop($id_trip[0]);
		$bd->flushSql();

		$tags = explode(";", $req["tags"]);
		$len_tags = count($tags)-1;

		while($len_tags >=0 ){
			$sql = "INSERT INTO route__tag (id_route,id_tag) VALUES ('{id_route}','{id_tag}')";
			$data = array('{id_route}' => $id_trip, '{id_tag}' => $tags[$len_tags]);
			$bd->setFormatedSql($sql,$data);
			$id_trip = $bd->consultAllWithSql();
			$bd->flushSql();
			$len_tags -= 1;
		}

		$bd->closeConnection();
	
		return $this->_makeBaseResponse(array('id_trip' => $id_trip));
	}


	/* Adciona imagem a trip
	* @receives id_user
	* @receives id_trip
	* @receives urls
	* @receives labels
	*/
	function putImages($req){
		$bd = new bd_manip();
		$bd->setTable("route_pics");

		$photos = $req["urls"];
		$labels = $req["labels"]; 
		$len_images = count($urls)-1;

		$bd->connectDB();
		while ($len_images >= 0) {
			$data = array('fk_route',$req["id_trip"],
					'photo' => $photos[$len_images],
					'label' => $labels[$len_images]);

			$bd->setSafeData($data);
			$bd->forceInsert();
			$len_images -=1;
		}

		$bd->closeConnection();

		return $this->_makeBaseResponse(array());
	}


	/* Adiciona as rotas na trip
	* @receives places 	{Lista dos lugares (IDs)}
	* @receives id_trip {ID da rota}
	* @returns {base_return}
	*/
	function putRoutes($req){
		$bd = new bd_manip();
		$bd->setTable("trip__place");

		$places = $req["places"];
		$len_places = count($places)-1;

		$bd->connectDB();
		while ($len_places >= 0) {
			$data = array('fk_route',$req["id_trip"],
					'fk_place' => $places[$len_places]);

			$bd->setSafeData($data);
			$bd->forceInsert();
			$len_places -=1;
		}

		$bd->closeConnection();

		return $this->_makeBaseResponse(array());
	}

}
?>