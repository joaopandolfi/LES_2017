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
	/* Faz login
	* @receive $req {$_REQUEST}
	* @returns $res {Funcion Response}
	*/
	function _login($req){
		$res = "";
		$bd = new bd_manip();

		$email = $bd->removeSuspectsFromString(base64_decode($req["email"]));
		$pass = $bd->removeSuspectsFromString($req["pass"]);

		$bd->setTable("user");
		$bd->setOrder("iduser")
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
	* @returns {success: 1 or 0}
	*/
	function _register($req){
		//$data = json_decode(file_get_contents('php://input'), true); // Recupera body
		$data = $_REQUEST;
		$data["token"] = generateAPIKey($data["email"]);
		$bd->setTabela("user");
		$bd->setSafeData($data);
		$bd->connectDB();
		$bd->inserir();
		$bd->closeConnection();
		echo "{success:1}";
	}
}

?>