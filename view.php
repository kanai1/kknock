<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$post_num = $_GET['number'];

			if(is_int($post_num))
			{
				$heredoc = <<< HERE
				<script>
				alert('글을 찾을 수 없습니다.');
				location.replace('/');
				</script>
				HERE;
				
				echo $heredoc;
			}

			$conn = mysqli_connect('localhost', 'kknock', 'kknock', 'test');
			$stmt = mysqli_stmt_init($conn);
			mysqli_stmt_prepare($stmt, "SELECT * FROM board WHERE post_num=?");
			mysqli_stmt_bind_param($stmt, 'i', $post_num);
			mysqli_stmt_execute($stmt);
			$result = mysqli_fetch_array(mysqli_stmt_get_result($stmt));

			if($result == "")
			{
				$heredoc = <<< HERE
				<script>
				alert('글을 찾을 수 없습니다.');
				location.replace('/');
				</script>
				HERE;
				
				echo $heredoc;
			}
		}
	?>
	<h1><a href="/">자유게시판</a></h1>
	<title><?php echo $result['title'] ?></title>
	<style>
		textarea{resize:none}
		a{
			text-decoration: none;
			color: black;
		}
	</style>
</head>
<body>
	<div>
		<h2><?php echo htmlspecialchars($result['title']) ?></h2>
		<p> <?php echo nl2br(htmlspecialchars($result['body'])) ?></p>
</body>
</html>
