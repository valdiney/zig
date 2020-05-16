<?php
$commandName = readline("Write the command: ");
$array = explode(' ', $commandName);

$commandList = '
     controller TestController (To create a Controller)
     model Test (To create a Model)
';

if (strtolower($array[0]) == 'controller') {
	require_once('CommandLine/CreateController.php');
	if (controller($array[1])) {
		echo 'Controller created Successfuly!';
	} else {
		echo 'Not work!';
	}

} elseif ($commandName == 'help') {
	echo $commandList; exit;
}

else {
	echo 'Command not fould!';
}
?>