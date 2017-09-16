<?php 

// -----------------------
// Created by lepola, 14/09/2017. 
// http://lepola.co.nf
// -----------------------

include 'config.php';

if(!json_db_logged_in()){

	if(isset($_POST['login'])){
		json_db_login($_POST['username'], $_POST['password']);
		header("Location: index.php");
	}

}else{
	if(isset($_GET['logout'])){
		json_db_logout();
		header("Location: index.php");	
	}
}

?>

<html>
	
	<head>
		<title>Json Database Admin Panel</title>
		<script src="//code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

		<link rel="stylesheet" href="css/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<script src="json-db.js"></script>

	</head>

	<body>

	<?php if(json_db_logged_in()){ ?>

	<div class="w3-container w3-indigo w3-margin-bottom">
		<header>
			<h4>Admin Panel - <a href="?logout">Logout</a></h4>
		</header>
	</div>	


	<div class="w3-container w3-margin-bottom">
		
		<div class="w3-card-4 w3-padding w3-light-grey" style="max-width: 800px;">
			
			<div class="">
				<button onclick="createTable();" class="w3-btn w3-white w3-border"><span class="fa fa-plus"></span> Create table</button>
			</div>

		</div>

	</div>


	<div class="w3-container" id="tables"></div>


	<script>

	// Getting tables
	$(document).ready(function(){

		json_db.path = "";

		printTables();
	});

	function printTables(){
		$("#tables").html("");
		json_db.getTables(function(response){

			var tables = response.response;

			if(tables.length > 0){

				for(var i = 0; i < tables.length; i++){

					var tableName = tables[i].tableName;
					var table = tables[i].content;

					var html = '<div id="'+tableName+'" class="w3-card-4 w3-padding w3-margin-bottom w3-light-grey" style="max-width: 800px;">';
					html += '<header>';
					html += '<h5>'+tableName+' <span onclick="removeTable(\''+tableName+'\')" style="cursor:pointer;" class="fa fa-close w3-right"></span></h5>';
					html += '</header>';
			
					html += '<div class="w3-white">';
					html += '<textarea cols="30" rows="10" class="content w3-border w3-input">'+JSON.stringify(table)+'</textarea>';
					html += '</div>';

					html += '<button class="w3-btn w3-indigo w3-block" onclick="saveTable(\''+tableName+'\')">Save table</button>';

					html += '</div>';

					$("#tables").append(html);

				}

			}

		});
	}
		
	function saveTable(id){

		var newContent = $("#"+id+" .content").val();

		try{
			JSON.parse(newContent);

			json_db.updateTableContent(id, newContent, function(data){
				alert(data.message);
				$("#"+id+" .content").removeClass("w3-border-red");
			});

		}catch(e){
			$("#"+id+" .content").addClass("w3-border-red");
			alert("Invalid json data!");
		}

	}

	function removeTable(id){
		
		var c = confirm("Are you sure?");

		if(c){
			json_db.removeTable(id, function(data){
				alert(data.message);
				printTables();
			});
		}
	}

	function createTable(){
		var name = prompt("Type table name:");

		if(name != "" && name.indexOf("/") == -1 && name.indexOf("\\") == -1){
			json_db.createTable(name, function(data){
				alert(data.message);
				printTables();
			});
		}else{
			alert("Name can not be null and can not contains: '/' and '\\'.");
		}
	}

	</script>

	<?php }else{ ?>

	<div class="w3-container w3-indigo w3-margin-bottom">
		<header>
			<h4>Admin Panel - Login</h4>
		</header>
	</div>


	<div class="w3-content w3-margin-top w3-margin-bottom" style="max-width:500px;">

		<div class="w3-card-4 w3-light-grey">
			
			<div class="w3-container">
				<header class="w3-light-grey">
					<h4>Login</h4>
				</header>
			</div>

			<div class="w3-container w3-white">
				
				<form action="index.php" method="post">
					<label for="">Username:</label>	
					<input type="text" name="username" class="w3-input w3-border" required>

					<label for="">Password:</label>
					<input type="password" name="password" class="w3-input w3-border" required>

					<button class="w3-btn w3-indigo w3-block" name="login" type="submit">Login</button>
				</form>

			</div>
		</div>

	</div>

	<?php } ?>
		
	</body>

	<script>
		
		

	</script>

</html>