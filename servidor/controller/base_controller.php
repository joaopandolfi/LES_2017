<?php 

define("SEED",10354532);
date_default_timezone_set("America/Sao_Paulo");

class Controller{

	/* Executa uma consulta simples no banco
	* @receive $bd 		{bd_manip}
	* @receive $lambda	{Lambda function to call}
	* @return $res 		{Resultado da busca formatada}
	*/
	protected function _makeLambdaConsult($bd,$lambda){
		try {
			$bd->connectDB();
			$result = $lambda($bd);
			$bd->closeConnection();

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


	/* Formata resposta base 
	* @receive $result {Array}
	* @returs $response {JsonString}
	*/
	protected function _makeBaseResponse($result){
		$response = array("success" => 1,
				"error" => 0,
				"data" => $result);
		return json_encode($response);
	}
}

?>