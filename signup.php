<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>회원가입중</title>
</head>
<body>
	<?php
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$name = $_POST['userName'];
			$id = $_POST['userId'];
			$password = $_POST['userPassword'];
			$password_again = $_POST['userPasswordAgain'];

			$conn = mysqli_connect('localhost', 'kknock', 'kknock', 'test');
			$sql_id_find = "SELECT * FROM user_login WHERE login_id='$id'";

			if($result = mysqli_fetch_array(mysqli_query($conn, $sql_id_find)))
			{
				$heredoc = <<< HERE
				<span>이미 존재하는 아이디입니다.</span>
				<button onclick="history.back()">돌아가기</button>
				HERE;

				echo $heredoc;
			}
			else if(strcmp($password, $password_again) != 0)
			{
				$heredoc = <<< HERE
				<span>비밀번호가 다릅니다.</span>
				<button onclick="history.back()">돌아가기</button>
				HERE;

				echo $heredoc;
			}
			else
			{
				$sql = "INSERT INTO user_login(login_id, login_pw, created, user_name) VALUES ('$id', '$password', now(), '$name')";

				if($result = mysqli_query($conn, $sql))
				{
					$heredoc = <<< HERE
					<span>계정 생성에 성공했습니다.</span>
					<button onclick="location.href='/'">로그인으로 돌아가기</button>
					HERE;

					echo $heredoc;
				}
				else
				{
					$heredoc = <<< HERE
					<span>계정 생성에 실패했습니다.</span>
					<button onclick="history.back()">돌아가기</button>
					HERE;

					echo $heredoc;
				}
			}
		}
		else
		{
			$heredoc = <<< HERE
			<span>잘못된 접근입니다.</span>
			HERE;

			echo $heredoc;
		}
	?>
</body>
</html>
