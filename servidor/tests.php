<?php
class Tester{
var $passeds = 0;
var $faileds = 0;

function test($name, $lambda, $expected){

	$result = $lambda();
	if($result == $expected){
		$this->passeds += 1;
		echo "PASSED TEST: ".$name."<BR>";
	}
	else {
		echo "FAILED TEST: ".$name." --- [EXPECTED: $expected] -- [RETURNED: $result] <BR>";	
		$this->faileds++;
	}
}

function printResult(){
	echo "<BR>PASSEDS: ".$this->passeds."<br>";
	echo "FAILEDS: ".$this->faileds."<BR>";
}

}

$t = new Tester();

echo "=================== TDD ======================<BR>";

$t->test("login Success",function(){
	$user = base64_encode("jordan");
	$pass = "MTIz";

	$r = file_get_contents("http://restfull.hol.es/les/user/login/".$user."/".$pass);
	$json = json_decode($r,true);

	return $json["data"]["user_id"];

}, "5");


$t->test("login Success - leo",function(){
	$user = base64_encode("leo");
	$pass = "MTIz";

	$r = file_get_contents("http://restfull.hol.es/les/user/login/".$user."/".$pass);
	$json = json_decode($r,true);

	return $json["success"];

}, "1");

$t->test("My trips - ID 1",function(){
	$id = "1";

	$r = file_get_contents("http://restfull.hol.es/les/user/trips/my/".$id);
	$json = json_decode($r,true);

	return $json["data"][1]["id_trip"];

}, "1");


$t->test("My trips - ID 10",function(){
	$id = "10";

	$r = file_get_contents("http://restfull.hol.es/les/user/trips/my/".$id);
	$json = json_decode($r,true);

	return count($json["data"]);

}, "1");



$t->test("Place Search 'a'",function(){
	$search = "a";

	$r = file_get_contents("http://restfull.hol.es/les/place/search/".$search);
	$json = json_decode($r,true);

	return $json["data"]["name_place"];

}, "Lugar teste");



echo "=================== BDD ======================<BR>";


$t->test("[Usuario digita login e senha] -- [usuario busca suas viagens]",function(){
	$user = base64_encode("leo");
	$pass = "MTIz";

	$r = file_get_contents("http://restfull.hol.es/les/user/login/".$user."/".$pass);
	$json = json_decode($r,true);

	$id =  $json["data"]["user_id"];

	$r = file_get_contents("http://restfull.hol.es/les/user/trips/my/".$id);
	$json = json_decode($r,true);

	return $json["data"][1]["id_trip"];

}, "1");



echo "==========================================<br>";
$t->printResult();
?>