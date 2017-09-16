// -----------------------
// Created by lepola, 14/09/2017. 
// http://lepola.co.nf
// -----------------------

var json_db = {

	"path": "json-db/",

	"createTable": function(tableName, success){

		$.ajax({
			type: "post",
			url: this.path+"json-db.php",
			data: { command: "createTable", table:tableName },
			success: function(data){
				  success(JSON.parse(data));
			} 
		});

	},

	"createProtectedTable": function(tableName, success){

		$.ajax({
			type: "post",
			url: this.path+"json-db.php",
			data: { command: "createProtectedTable", table:tableName },
			success: function(data){
				  success(JSON.parse(data));
			} 
		});

	},

	"updateTable": function(tableName, protected, success){

		$.ajax({
			type: "post",
			url: this.path+"json-db.php",
			data: { command: "updateTable", protected:protected, table:tableName },
			success: function(data){
				  success(JSON.parse(data));
			} 
		});

	},

	"updateTableContent": function(tableName, content, success){

		$.ajax({
			type: "post",
			url: this.path+"json-db.php",
			data: { command: "updateTableContent", content: content, table:tableName },
			success: function(data){
				  success(JSON.parse(data));
			} 
		});

	},

	"removeTable": function(tableName, success){

		$.ajax({
			type: "post",
			url: this.path+"json-db.php",
			data: { command: "removeTable", table:tableName },
			success: function(data){
				  success(JSON.parse(data));
			} 
		});

	},

	"getTable": function(tableName, success){

		$.ajax({
			type: "post",
			url: this.path+"json-db.php",
			data: { command: "getTable", table:tableName },
			success: function(data){
				  success(JSON.parse(data));
			} 
		});

	},

	"getTables": function(success){

		$.ajax({
			type: "post",
			url: this.path+"json-db.php",
			data: { command: "getTables" },
			success: function(data){
				  success(JSON.parse(data));
			} 
		});

	},

	"getItem": function(tableName, itemIndex, success){

		$.ajax({
			type: "post",
			url: this.path+"json-db.php",
			data: { command: "getItem", table:tableName, index:itemIndex },
			success: function(data){
				  success(JSON.parse(data));
			} 
		});

	},

	"editItem": function(tableName, itemIndex, item, success){

		$.ajax({
			type: "post",
			url: this.path+"json-db.php",
			data: { command: "editItem", table:tableName, index:itemIndex, item: JSON.stringify(item) },
			success: function(data){
				  success(JSON.parse(data));
			} 
		});

	},

	"addItem": function(tableName, item, success){

		$.ajax({
			type: "post",
			url: this.path+"json-db.php",
			data: { command: "addItem", table:tableName, item: JSON.stringify(item) },
			success: function(data){
				  success(JSON.parse(data));
			} 
		});

	},




};
