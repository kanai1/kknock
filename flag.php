<?php
	$flag = 'KCTF{this_is_flag!!}';

	if(!isset($_SESSION['user_id']))
	{
		header("HTTP/1.0 404 Not Found");
		exit();
	}
	else if(strcmp($_SESSION['user_id'], "admin"))
	{
		$heredoc = <<< HERE
		접근할 수 없는 페이지입니다.
		HERE;
	}
	else
	{
		echo $flag;
	}
?>
