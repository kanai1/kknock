<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>글쓰기</title>
</head>
<body>
	<?php
		session_start();
		if(!isset($_SESSION['user_id']))
		{
			$heredoc = <<< HERE
			<script>
			alert('로그인이 필요합니다.');
			location.replace('login.html');
			</script>
			HERE;

			echo $heredoc;
		}
		else if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$title = $_POST['title'];
			$body = $_POST['body'];
			$user_name = $_SESSION['user_name'];
			$user_id = $_SESSION['user_id'];

			$conn = mysqli_connect('localhost', 'kknock', 'kknock', 'test');
			$stmt = mysqli_stmt_init($conn);
			$stmt = $conn->prepare("INSERT INTO board(title, body, user_id, user_name, posted) VALUES (?, ?, ?, ?, now())");
			$stmt->bind_param('ssss', $title, $body, $user_id, $user_name);
			
			if($stmt->execute())
			{
				$heredoc = <<< HERE
				<script>
				alert('글쓰기가 완료되었습니다.');
				location.replace('/');
				</script>
				HERE;
	
				echo $heredoc;
			}
			else
			{
				$heredoc = <<< HERE
				<script>
				alert('글쓰기가 정상적으로 처리되지 않았습니다.');
				location.replace('/');
				</script>
				HERE;
	
				echo $heredoc;
			}
		}
		else
		{
			echo "잘못된 접근입니다.";
		}
		$stmt->close();
		$conn->close();
	?>
</body>
</html>
