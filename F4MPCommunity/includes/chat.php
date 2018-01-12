<?php
?>

<html>

	<head>
		<title>Live Chat</title>
		<link rel="stylesheet" type="text/css" href="styles/chat.css"/>
		<script>
			function submitChat() {
				if (form1.uname.value == '' || form1.msg.value == ''){
					alert('all fields are mandatory!');
					return;
				}
				var uname = form1.uname.value;
				var msg = form1.msg.value;
				var xmlhttp = new XMLHttpRequest();
				
				//prepares the xml object
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
						document.getElementById('chatlogs').innerHTML = xmlhttp.responseText;
					}
				}

				xmlhttp.open('GET', 'insert.php?uname='+uname+'&msg='+msg, true);
				//sends username and the message to insert.php as an xml object
				xmlhttp.send();
			}
			// AJAX function loading the logs to the chatlogs dic
			$(document).ready(function(e){
				$.ajaxSetup({
					cache: false
				});
				setInterval( function(){ $('#chatlogs').load('logs.php'); }, 2000 );
			});
			//refreshs the <div> which is the chatlogs every 2 seconds
		</script>
	</head>
	
	
	<body>
		<form name="form1">
			Name: <input type="text" name="uname" /><br />
			Message: <br />
			<textarea name="msg" style="width:250px; height:40px"></textarea><br />
			<a href="#" onclick="submitChat()">Send</a><br /><br />
			</form>
			<div id="chatlogs">
			loading...
			</div>
	</body>

</html>