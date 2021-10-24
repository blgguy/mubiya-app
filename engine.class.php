<?php
require_once('config.php');
require_once('httpMsg.php');

class model extends DB
{
	

    public function __construct(){

        parent::__construct();
    }

    public function create($table, $fields)
    {
        $SQL = "";
        $SQL .= "INSERT INTO ".$table;
        $SQL .= " (".implode(",", array_keys($fields)).") VALUES ";
        $SQL .= "('".implode("','", array_values($fields))."')";
        $query = $this->Jigo->query($SQL);

        if ($query) {
            return true;
        }
    }

    public function view($table)
    {
    		$sql = "SELECT * FROM $table ORDER BY id ASC";
	        $query = $this->Jigo->query($sql);

	        if($query->num_rows > 0){
	        	$postData = array();
	            while ($row = $query->fetch_array()){
	            	//$postData[] = $row;
	            	$postData[$row['id']] = array(
	            		'id' 	        => $row['id'],
	            		'name'          => $row['name'],
                        'email'         => $row['email'], 
	            		'password'      => $row['password'],
	            		'dateJoined'    => $row['dateJoined'], 
	            	);	
	            }
	            $resultData = array(
		    		'status' 	=> 	getHttpMsg(302),
		    		'usersData'	=>	$postData
		    	);
	        }
	        else{
	            $resultData = array(
		    		'status' 	=> 	getHttpMsg(404),
		    		'message'	=>	getHttpMsg(204)
		    	);
	        }
	        //return json_encode($resultData);
    	return json_encode($resultData);
    }

     public function viewById($table, $id)
    {
            $sql = "SELECT * FROM $table WHERE `id` = '$id'";
            $query = $this->Jigo->query($sql);

            if($query->num_rows > 0){
                $fetchData = array();
                while ($row = $query->fetch_array()){
                    //$postData[] = $row;
                    $fetchData[$row['id']] = array(
                        'id' 	        => $row['id'],
	            		'name'          => $row['name'],
                        'email'         => $row['email'], 
	            		'password'      => $row['password'],
	            		'dateJoined'    => $row['dateJoined'], 
                    );
                }
                $result = array(
                    'status'    =>  getHttpMsg(302),
                    'UserData'  =>  $fetchData
                );
            }
            else{
                $result = array(
                    'status'    =>  getHttpMsg(404),
                    'message'   =>  getHttpMsg(204)
                );
            }
            //return json_encode($resultData);
        return json_encode($result);
    }

    public function authEmail($email)
    {
        // Check the Requested id is valid or not
        $sql = "SELECT `email` FROM `users` WHERE `email` = '$email'";
    
        $duplicate = $this->Jigo->query($sql);
        if (mysqli_num_rows($duplicate)>0){
          return true;
        }
    }

    public function delete($table, $id)
    {
        $sql = "SELECT * FROM ".$table;
        $sql .= " WHERE id = ".$id;
        $array = array();
        $query = $this->Jigo->query($sql);
            while ($row = $query->fetch_array()) {
                $array[] = $row;
            }
            foreach ($array as $row) {
                $id = $row['id'];
                $sql    = "";
                $sql    .= "DELETE FROM ".$table;
                $sql    .= "WHERE id=".$id;
                $query  = $this->Jigo->query($sql);
                if ($query) {
                    return true;
                }
            }
    }
/*
    public function update($table, $fields, $id)
	{
		$sql = "";
		$codition = "";
		foreach ($id as $key => $value) {
			$codition .= $key. "='".$value."' , ";
		}
		$codition = substr($codition, 0, -5);
		foreach ($fields as $key => $value) {
			// Update table SET name='' , skill ='' , email ='' where id = ''	
			$sql .= $key ."='".$value."', ";	
		}

		$sql = substr($sql, 0, -2);
		$sql = "UPDATE ".$table." SET ".$codition."' WHERE ".$sql;
		//echo $sql;
		$query 	= 	$this->Jigo->query($sql);

        if ($query) {
            return true;
        }
    }
    
    

*/

}


?>