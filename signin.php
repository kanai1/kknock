<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>로그인</title>
</head>
<body>
	<?php
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$id = $_POST['txtId'];
			$password = $_POST['txtPassword'];

			$conn = new mysqli('localhost', 'kknock', 'kknock', 'test');
			$Stmt = $conn->prepare("SELECT user_name, login_id FROM user_login WHERE login_id=? && login_pw=?");
			$stmt->bind_param("ss", $id, $password);
			$stmt->execute();

			$stmt->bind_result($name, $login_id);
			if($stmt->fetch())
			{
				session_start();

				$_SESSION['user_name'] = $name;
				$_SESSION['user_id'] = $login_id;

				$heredoc = <<< HERE
				<script>location.replace('/')</script>
				HERE;

				echo $heredoc;
			}
			else
			{
				$heredoc = <<< HERE
				<h2>로그인 실패</h2>
				<br><button onclick="history.back()">돌아가기</button>
				HERE;

				echo $heredoc;
			}

			$stmt->close();
			$conn->close();
		}
	?>
</body>
</html>
