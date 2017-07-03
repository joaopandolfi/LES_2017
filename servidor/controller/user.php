<?php
	/*
		Created by João Carlos Pandolfi Santana
		
		This file is responsible to control user activityes

		System libs useds:
			Using json_decode() for decode json strings
			Using json_encode() for encode json arrays
		
		Personalized libs useds:
			Using bd_manip for control database
	*/
	

class User extends Controller{

	const USER_TABLE = "user";
	const USER_ID = "iduser";

	/* Faz login
	* @receive $req {$_REQUEST}
	* @returns $res {Funcion Response}
	*/
	function login($req){
		$res = "";
		$bd = new bd_manip();

		$email = $bd->removeSuspectsFromString(base64_decode($req["email"]));
		$pass = $bd->removeSuspectsFromString($req["pass"]);

		$bd->setTable(self::USER_TABLE);
		$bd->setOrder(self::USER_ID)
		$bd->setKey(" email ='$email' AND password = '$pass' ");
		
		$bd->connectDB();
		$result = $bd->consultAllByType();
		$bd->closeConnection();
		if(count($result) >0){
			$result = $result[0];
			$response = array("success" => 1,
				"error" => 0,
				"data" => array(
					"user_id" 	=> $result["iduser"],
					"hash" 		=> generateAPIKey($result["email"], $result["iduser"]),
					"name" 		=> $result["nickname"],
					"email" 	=> $result["email"],
					"url_picture" => $result["photo"]
					) 
				);
			$res = json_encode($response);
		}
		else
			$res = "{'success':0,'error':1,data:{}}";

		return $res;
	}

	/*
	* Registra o usuario no banco
	* @receive {email:(String),senha:(String),nome:(String)}
	* @returns {base_return}
	*/
	function register($req){
		$bd = new bd_manip();

		$sql = "SELECT new_user('{name}','{email}','{pass}','{hash}');";
		$data = array('{name}' => base64_decode($req["name"]), 
				'{email}'=> base64_decode($req["email"]),
				'{pass}'=>$req["pass"],
				'{hash}' =>"");
		$data["hash"] = generateAPIKey($data["email"]);

		$bd->setFormatedSql($sql,$data);

		$bd->connectDB();

		$id_user = $bd->consultAllWithSql();
		$id_user = array_pop($id_user);
		
		$bd->closeConnection();
		$bd->flushSql();

		return $this->_makeBaseResponse($id_user);
	}


	/* Adiciona imagem ao perfil do usuario
	* @receives id_user 	{ID do usuario}
	* @receives hash 		{Hash de confirmacao}
	* @receives url_image	{Url da foto do usuario}
	* @returns {base_return}
	*/
	function setImage($req){
		$bd = new bd_manip();

		$data = array('photo' => $req["url_image"]);
		
		$sql_where = " id_user = '{id_user}' AND hash = {hash} ";
		$data_where = array('{id_user}' => $req["id_user"], 
					'{hash}' = > $req["hash"]);

		$bd->setTable(self::USER_TABLE);
		$bd->setData($data);
		$bd->setFormatedKey($sql_where,$data_where);

		$bd->connectDB();
		$bd->update();
		$bd->closeConnection();

		return $this->_makeBaseResponse(array())
	}


	/*
	* Gera a API_KEY do usuario
	* @receives email
	* @receives id
	* @returns api_key -> base64
	*/
	private function generateAPIKey($data){
		return base64_encode("-".$data." -||-".SEED."-");
	}

}

?>