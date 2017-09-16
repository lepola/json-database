# Json-db by Lepola

Simple json db javascript library, create json 'tables' and save data to it.

Requires JQuery, PHP.

# Getting start

<b>PHP for login and logout, Javascript for edit, delete and get table / item.</b>

1. Copy <b>json-db</b> folder to your website.

2. Open <b>json-db/config.php</b> and set your database username and password.

3. For editing, creating or deleting tables / items and selecting protected table data, you need login with php:
	
		- include 'json-db/config.php';
		- json_db_login($yourusername, $yourpassword);

4. After this you can edit tables with Javascript using <b>json-db/json-db.js</b>.


# PHP functions

1. include 'config.php';

Log in with config.php username and password.

<code>
	json_db_login($USERNAME, $PASSWORD);
  
</code><br><br>
Logout

<code>
	json_db_logout();
  
</code><br><br>
If you are logged in -> return true, else return false.

<code>
	json_db_logged_in();
  
</code>


# Javascript (json-db.js) functions


Response message format:

<code>
  
	{
  
		response: (object), // if error is 1, this won't exist.
    
		message: (string),
    
		error: (0 = No error, 1 = error)
    
	}
</code>



Json db library path

<code>
 
	json_db.folder.path = "json_db/"; // This is default path. This needs to be valid and <b>use slash at end of path!</b>
</code>

Create table, eg:

<code>
  
	json_db.createTable("tableName", function(response){
  
		console.log(response);
    
	});
</code>


Create Protected table, you can read only if you are logged in. eg:

<code>
  
	json_db.createProtectedTable("tableName", function(response){
  
		console.log(response);
    
	});
</code>


Update table protected status. eg:

json_db.updateTableContent(TABLE_NAME, PROTECTED_STATUS, SUCCESS_FUNCTION);

<code>
  
	json_db.updateTable("tableName", 1 /*1 = protected, 0 = non-protected*/, function(response){
  
		console.log(response);
    
	});
</code>


Update table content. This replace old table to JSON_VARIABLE parameter. eg:

json_db.updateTableContent(TABLE_NAME, JSON_VARIABLE, SUCCESS_FUNCTION);

<code>
  
	json_db.updateTableContent("tableName", {"name": "test"}, function(response){
  
		console.log(response);
    
	});
</code>


Remove table eg:

<code>
  
	json_db.removeTable("tableName", function(response){
  
		console.log(response);
    
	});
</code>


Get table eg:

<code>
  
	json_db.getTable("tableName", function(response){
  
		console.log(response);
    
	});
</code>


Get all tables eg:

<code>
  
	json_db.getTables(function(response){
  
		console.log(response);
    
	});
</code>


Get item eg:

json_db.getItem(TABLE_NAME, ITEM_INDEX, SUCCESS_FUNCTION);

<code>
  
	json_db.getItem("tableName", 0, function(response){
  
		console.log(response);
    
	});
</code>


Edit item eg:

json_db.editItem(TABLE_NAME, ITEM_INDEX, NEW_ITEM, SUCCESS_FUNCTION);

<code>
  
	json_db.editItem("tableName", 0, {"item":"newItem"}, function(response){
  
		console.log(response);
    
	});
</code>


Add item eg:

json_db.addItem(TABLE_NAME, ITEM, SUCCESS_FUNCTION);

<code>
  
	json_db.addItem("tableName", {"title":"this item will be added."}, function(response){
  
		console.log(response);
    
	});
</code>


# License

GNU General Public License v3.0
