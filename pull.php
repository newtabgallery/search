<?php

header('Content-Type: application/json');

$output = "";
if ($_SERVER["HTTP_X_GITHUB_EVENT"] == "push") {
	$output = shell_exec("./pull.sh");
} else {
	$output = "Invalid hook request.";
}
echo $output;
?>

