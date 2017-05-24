<?php
	/*
		Created by João Carlos Pandolfi Santana 03-10-2016
		
		This file is responsible to control user activityes

		System libs useds:
			Using json_decode() for decode json strings
			Using json_encode() for encode json arrays
		
		Personalized libs useds:
			Using bd_manip for control database
	*/

	//Iniciando sessao
	@session_start();

	//includes
	include("libs/bd_manip.php");
	include("libs/regex.php");
	include("libs/extra_functions.php");

	$bd = new bd_manip();
	$type = $_REQUEST["t"];

	$result = array();
	switch ($type) {
		/*
		* Faz login
		* @receive {login:(String),senha:(String)}
		* @returns {success:(1 or 0)}
		*/
		case 1: // Login
			$email = $bd->removeSuspectsFromString(base64_decode($_REQUEST["email"]));
			$pass = $bd->removeSuspectsFromString($_REQUEST["pass"]);
			
			$sql = "SELECT u.iduser, u.token, p.nome, u.foto, u.tipo_usuario,u.idpessoa, u.idinstituicao FROM usuario as u 
			INNER JOIN pessoa as p ON p.idpessoa = u.idpessoa
			where login='$email' AND senha='$pass'";

			$bd->setSql($sql);
			
			$bd->connectDB();
			$result = $bd->consultAllWithSql();
			$bd->closeConnection();
			if(count($result) >0){
				
				$response = array("success" => 1,
					"error" => 0,
					"data" => array(
						"user_id" => $result[0]["iduser"],
						"hash" => $result[0]["hash"],
						"name" => $result[0]["name"],
						"email" =>,
						"url_picture" =>
						) 
					);
				echo json_encode($response);
			}
			else
				echo "{'success':0,'error':1,data:{}}";
			
			break;

		/*
		* Registra o usuario no banco
		* @receive {email:(String),senha:(String),nome:(String)}
		* @returns {success: 1 or 0}
		*/
		case 2: // Register
			//$data = json_decode(file_get_contents('php://input'), true); // Recupera body
			$data = $_REQUEST;
			$data["token"] = generateAPIKey($data["email"]);
			$bd->setTabela("user");
			$bd->setSafeData($data);
			$bd->connectDB();
			$bd->inserir();
			$bd->closeConnection();
			echo "{success:1}";
			break;

		default:
			# Do Nothing
			echo "{error:404}";
			break;
	}

?>