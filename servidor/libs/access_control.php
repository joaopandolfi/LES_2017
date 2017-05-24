<?php

	function getFactoryTypeUser($type_user){
		$factory = null;
			if($type_user >= 4 || $type_user == 0){
				include("factoryes/client_factory.php");
				$factory = new ClientFactory();
			}
			else if($type_user == 3){
				include("factoryes/especialist_factory.php");
				$factory = new EspecialistFactory();	
			}

		return $factory;
	}

?>