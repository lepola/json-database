<?php 
// -----------------------
// Created by lepola, 14/09/2017. 
// http://lepola.co.nf
// -----------------------


include 'config.php';



$templateStartProtected = '<?php $protected = 1; include \'../config.php\'; $data = \'[]\'; if(json_db_logged_in()){ $data = \'';
$templateStart = '<?php $protected = 0; $data = \'';
$templateEndProtected = '\'; } ?>';
$templateEnd = '\'; ?>';

function response($data){
	$r = array("error" => 0, "message" => "", "response" => $data);
	//array_push($r->response, $data);
	return json_encode($r);
}

function error($txt){
	$r = array("error" => 1, "message" => $txt);
	return json_encode($r);
}

function success($txt){
	$r = array("error" => 0, "message" => $txt);
	return json_encode($r);
}



function createTable($json){
	global $templateEnd, $templateStart, $templateStartProtected, $templateEndProtected;

	return $templateStart . json_encode($json) . $templateEnd;	

}

function createProtectedTable($json){
	global $templateEnd, $templateStart, $templateStartProtected, $templateEndProtected;

	return $templateStartProtected . json_encode($json) . $templateEndProtected;	

}




// Getting ajax variables


function main(){
	
	$command = $_POST["command"];
	
	switch ($command) {
		case 'createTable':
			if(json_db_logged_in()){
			
				$table = $_POST["table"];

				$path = "tables/".$table. ".php";

				$json = (isset($_POST["json"])) ? json_decode($_POST["json"]) : json_decode("[]");

				if(file_exists($path)){
					return error("Table already exist.");
				}else{

					$table = createTable($json);

					$file = fopen($path, "w") or die("Cannot access database"); //or return error("Unable to access databases");

					fwrite($file, $table);

					fclose($file);

					return success("Table created!");

				}
			}

			break;

		case 'createProtectedTable':
			if(json_db_logged_in()){
			
				$table = $_POST["table"];

				$path = "tables/".$table. ".php";

				$json = (isset($_POST["json"])) ? json_decode($_POST["json"]) : json_decode("[]");

				if(file_exists($path)){
					return error("Table already exist.");
				}else{

					$table = createProtectedTable($json);

					$file = fopen($path, "w"); //or return error("Unable to access databases");

					fwrite($file, $table);

					fclose($file);

					return success("Table created!");

				}
			}

			break;

		case 'updateTable':
			if(json_db_logged_in()){
			
				$table = $_POST["table"];

				$path = "tables/".$table. ".php";

				$protect = $_POST["protected"];

				if($protect == ""){return error("Invalid protected value.");}

				if(file_exists($path)){

					include $path;

					$json = json_decode($data);

					$table = ($protect == 1) ? createProtectedTable($json) : createTable($json);

					$file = fopen($path, "w"); //or return error("Unable to access databases");

					fwrite($file, $table);

					fclose($file);

					return success("Table updated!");
					
				}else{

					return error("Table not exist");

				}
			}

			break;


		case 'updateTableContent':
			if(json_db_logged_in()){
			
				$table = $_POST["table"];

				$path = "tables/".$table. ".php";

				$json = json_decode($_POST['content']);

				if(file_exists($path)){

					include $path;

					$table = ($protect == 1) ? createProtectedTable($json) : createTable($json);

					$file = fopen($path, "w"); //or return error("Unable to access databases");

					fwrite($file, $table);

					fclose($file);

					return success("Table content updated!");
					
				}else{

					return error("Table not exist");

				}
			}

			break;

		case 'removeTable':
			if(json_db_logged_in()){

				$table = $_POST["table"];

				$path = "tables/".$table. ".php";

				if(file_exists($path)){
					
					unlink($path);
					return success("Table removed!");

				}else{

					return error("Table not exist.");

				}

			}
			break;

		

		case 'addItem':
			if(json_db_logged_in()){

				$table = $_POST["table"];
				$item = $_POST["item"];

				$path = "tables/".$table. ".php";

				if(file_exists($path)){
					
					if($item != ""){
						$item = json_decode($item);

						include $path;

						$json = json_decode($data);

						array_push($json, $item);

						$new_json = ($protected == 1) ? createProtectedTable($json) : createTable($json);

						$file = fopen($path, "w"); //or return error("Unable to access databases");

						fwrite($file, $new_json);

						fclose($file);

						return success("Item added!");

					}

				}else{

					return error("Table not exist.");

				}
				
			}
			break;

		case 'removeItem':
			if(json_db_logged_in()){
				
				$table = $_POST["table"];
				$index = $_POST["index"];

				$path = "tables/".$table. ".php";

				if(file_exists($path)){
					
					

						include $path;

						$json = json_decode($data);

						unset($json[$index]);

						$new_json = ($protected == 1) ? createProtectedTable($json) : createTable($json);

						$file = fopen($path, "w"); //or return error("Unable to access databases");

						fwrite($file, $new_json);

						fclose($file);

						return success("Item removed!");

					

				}else{

					return error("Table not exist.");

				}

			}
			break;

		case 'editItem':
			if(json_db_logged_in()){
				
				$table = $_POST["table"];
				$index = $_POST["index"];
				$item = $_POST['item'];

				$path = "tables/".$table. ".php";

				if(file_exists($path)){
					
					if($item != ""){
						$item = json_decode($item);

						include $path;

						$json = json_decode($data);

						$json[$index] = $item;

						$new_json = ($protected == 1) ? createProtectedTable($json) : createTable($json);

						$file = fopen($path, "w"); //or return error("Unable to access databases");

						fwrite($file, $new_json);

						fclose($file);

						return success("Item updated!");

					}

				}else{

					return error("Table not exist.");

				}

			}
			break;



		case 'getTable':
				$table = $_POST["table"];

				$path = "tables/".$table. ".php";

				if(file_exists($path)){

					include $path;

					$json = json_decode($data);

					return response($json);

				}else{

					return error("Table not exist.");

				}

			break;

		case 'getTables':
				
				$paths = scandir("tables");

				$response = '';

				if(count($paths) < 1){
					return response(json_decode("[]"));
				}

				for($i = 0; $i < count($paths); $i++){

					if(strpos($paths[$i], ".php")){

						if($response != ""){$response .= ",";}

						$tableName = str_replace(".php", "", $paths[$i]);

						$path = "tables/".$paths[$i];

						if(file_exists($path)){

							include $path;

							$json = json_decode($data);

							$response .= '{"tableName":"'.$tableName.'","content":'.json_encode($json).'}';

						}
					}

				}

				return response(json_decode("[".$response."]"));

			break;

		case 'getItem':
				$table = $_POST["table"];
				$index = $_POST['index'];

				$path = "tables/".$table. ".php";

				if(file_exists($path)){

					include $path;

					$json = json_decode($data);

					return response($json[$index]);

				}else{

					return error("Table not exist.");

				}
			break;
		
		default:
			return error("Invalid command!");
			break;
	}
}

echo main();

?>