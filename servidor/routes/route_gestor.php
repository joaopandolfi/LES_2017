<?php 
	/*
		Created by João Carlos Pandolfi Santana
		
		This file is responsible to control All routes in Server

		System libs useds:
			Using json_decode() for decode json strings
			Using json_encode() for encode json arrays
		
		Personalized libs useds:
			Using bd_manip for control database
	*/

	//Constants
	include_once("constants/routes_constants.php");

	//Basic
	include_once("libs/bd_manip.php");
	include_once("libs/regex.php");
	include_once("libs/extra_functions.php");

	//Controller
	include_once("controller/base_controller.php");
	include_once("controller/user.php");
	include_once("controller/trip.php");
	include_once("controller/route.php");

	//Getting Route code
	$code = $_REQUEST["r_code"];

	//Working
	switch ($code) {
		case $route_codes["login"]:
			$user = new User();
			echo $user._login($_REQUEST);
			break;
		
		case $route_codes["all_trips"]:
			$trip = new Trip();
			echo $trip._getAllTrips($_REQUEST);
			break;
		

		default:
			# code...
			break;
	}

?>