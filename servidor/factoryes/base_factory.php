<?php
	/*
	* This abstract class is a base class factory
	*/

	abstract class BaseFactory {
		abstract public function initialize();
		abstract public function createBody($section);
		abstract public function createNavBar();
		abstract public function createMenuLateral();
	}

?>