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
			
			$stmt = $conn->prepare("SELECT login_id FROM user_login WHERE login_id=?");
			$stmt->bind_param("s", $id);
			$stmt->bind_result($login_id);
			$stmt->execute();

			if($stmt->fetch())
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
				$stmt->close();

				$stmt = $conn->prepare("INSERT INTO user_login(login_id, login_pw, created, user_name) VALUES (?, ?, now(), ?)");
				$stmt->bind_param("sss", $id, $password, $name);

				if($stmt->execute())
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
		$stmt->close();
		$conn->close();
	?>
</body>
</html>
