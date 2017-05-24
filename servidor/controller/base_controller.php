<?php 


class Controller{

	/* Executa uma consulta simples no banco
	* @receive $bd 		{bd_manip}
	* @receive $lambda	{Lambda function to call}
	* @return $res 		{Resultado da busca formatada}
	*/
	proteceted function _makeLambdaConsult($bd,$lambda){
		try {
			$bd->connectDB();
			$result = $lambda();
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

}

?>