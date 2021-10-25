<?php
require_once('engine.class.php');
//header('Content-Type:application/json');

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', __DIR__.DS);
require BASE_PATH.'route/vendor/autoload.php';

$app            = System\App::instance();
$app->request   = System\Request::instance();
$app->route     = System\Route::instance($app->request);

$route          =$app->route;

$route->post('/api/create/{name}/{email}/{password}',
    function($name, $email, $password){

		if (empty($name) || empty($email) || empty($password)) {
			$inserted = array(
				'status' 	=>	getHttpMsg(400),
				'message'   => 'Check the field name, email or password for empty input'
			);
			echo json_encode($inserted);
		}
		header('Content-Type:application/json');
		$engine = new model();	
		date_default_timezone_set("Africa/Lagos");
		$dateJoined = date("Y-m-d H:i:s");
		$dublicateEmail = $engine->authEmail(sentize($email));

	if (!$dublicateEmail) {
		$array = array(
			'name'          => $name,
			'email'         => $email, 
			'password'      => $password,
			'dateJoined'    => $dateJoined, 
		);
		$k = $engine->create('users', $array);
		if ($k) {
			$inserted = array(
				'status' 	=>	getHttpMsg(201),
				'message'   => 'New User Added Sucessfully'
			);
			echo json_encode($inserted);
		}else{
			$inserted = array(
				'status' 	=>	getHttpMsg(503),
				'message'   => 'Service Error!'
			);
			echo json_encode($inserted);
		}
	}else{
		$inserted = array(
			'status' 	=>	getHttpMsg(300),
			'message'   => 'Dublicate Error!'
		);
		echo json_encode($inserted);
	}
});

$route->get('/api/view', function(){
	header('Content-Type:application/json');
	$engine = new model();
	echo $engine->view('users');
});

$route->get('/api/view/{id}', function($id){
	header('Content-Type:application/json');
	$engine = new model();
	echo $engine->viewById('users', $id);
	
});

$route->post('/api/create/{name}/{email}/{password}',
    function($name, $email, $password){

		if (empty($name) || empty($email) || empty($password)) {
			$inserted = array(
				'status' 	=>	getHttpMsg(400),
				'message'   => 'Check the field name, email or password for empty input'
			);
			echo json_encode($inserted);
		}
		header('Content-Type:application/json');
		$engine = new model();	
		date_default_timezone_set("Africa/Lagos");
		$dateJoined = date("Y-m-d H:i:s");
		$dublicateEmail = $engine->authEmail(sentize($email));

	if (!$dublicateEmail) {
		$array = array(
			'name'          => $name,
			'email'         => $email, 
			'password'      => md5($password),
			'dateJoined'    => $dateJoined, 
		);
		$k = $engine->create('users', $array);
		if ($k) {
			$inserted = array(
				'status' 	=>	getHttpMsg(201),
				'message'   => 'New User Added Sucessfully'
			);
			echo json_encode($inserted);
		}else{
			$inserted = array(
				'status' 	=>	getHttpMsg(503),
				'message'   => 'Service Error!'
			);
			echo json_encode($inserted);
		}
	}else{
		$inserted = array(
			'status' 	=>	getHttpMsg(300),
			'message'   => 'Dublicate Error!'
		);
		echo json_encode($inserted);
	}
});

$route->get('/api/auth/{email}/{pass}',
    function($email, $pass){

		$engine = new model();	
		echo $engine->loginn($email, $pass);

});
$route->update('/api/update/{id}/{name}/{email}/{password}',
	function($id, $name, $skill, $email){

	$engine = new model();	
	$authID = $engine->authId('team', $id);

	if ($authID) {
		$id = array('id' => $authID);
		$array = array(
			"name"     =>  $name,
			"skill"    =>  $skill,
			"email"    =>  $email
		);
		
		$update = $engine->update('team', $id, $array);

		if ($update) {
			$inserted = array(
				'status' 	=>	getHttpMsg(201),
				'message'   => 'data sucessfully Updated'
			);
			echo json_encode($inserted);
		}else{
			$inserted = array(
				'status'    =>  getHttpMsg(404),
				'teamData' =>  'data not Updated'
			);
			echo json_encode($inserted);
		}
	}else{
		$inserted = array(
			'status'    =>  getHttpMsg(404),
			'teamData' =>  'The ID you used is incorrect'
		);
		echo json_encode($inserted);
	}
});

$route->delete('/api/delete/{id}', function($id){

	$engine = new model();	
	$authID = $engine->authId('team', $id);

	if ($authID) {
		$id = array('id' => $authID);

		$delete = $engine->delete('team', $id);

		if ($delete) {
			$inserted = array(
				'status' 	=>	getHttpMsg(201),
				'message'   => 'data sucessfully Deleted'
			);
			echo json_encode($inserted);
		}else{
			$inserted = array(
				'status'    =>  getHttpMsg(404),
				'message'	=>  'data not Deleted'
			);
			echo json_encode($inserted);
		}
	}else{
		$inserted = array(
			'status'    =>  getHttpMsg(404),
			'teamData' 	=>  'The ID you used is incorrect'
		);
		echo json_encode($inserted);
	}
});

$route->end();

?>