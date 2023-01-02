<?php
	session_start();
	$flag = 'KCTF{Th1s_1s_Adm1n_P4age..!}';

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
