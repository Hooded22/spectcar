<?php
require './htmlpurifier-4.14.0/library/HTMLPurifier.auto.php';
class Pdo_
{
 private $db;
 private $purifier;
 public function __construct() {
 $config = HTMLPurifier_Config::createDefault();
 $this->purifier = new HTMLPurifier($config);
 try {
 $this->db = new PDO('mysql:host=localhost;dbname=integracja', 'root', '');
 }catch (PDOException $e){
 // add relevant code
 die();
 }
 }
 public function add_user($login,$email,$password){
	 //generate salt
//hash password with salt
 $login=$this->purifier->purify($login);
 $email=$this->purifier->purify($email);
 try {
 $sql="INSERT INTO `users`( `login`, `email`, `password`, `name`, `last_name`, `token`, `token_expire_date`, `type`)
 VALUES (:login,:email,:password,:name,:last_name,:token,:token_expire_date,:type)";
 $data= [
 'login' =>$login,
 'email' =>$email,
 'password' =>$password,
 'name' => "imie",
 'last_name'=>"nazwisko",
 'token'=>NULL,
 'token_expire_date'=>NULL,
 'type'=>NULL
 ];
 $this->db->prepare($sql)->execute($data);
 } catch (Exception $e) {
//modify the code here
 print 'Exception' . $e->getMessage();
 }
 }
 
	public function log_user_in($login,$password){
		echo "HERE";
		$curl = curl_init();
		$url = 'http://localhost:9000/api/auth/login';
		$data = (object) array('login' => $login, 'password' => $password);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		try {
			$result = json_decode(curl_exec($curl));
			echo $result;
		} catch (\Throwable $th) {
			echo $th;
		} finally {
			curl_close($curl);
		}
		
	}
}