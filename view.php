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

			$comment_sql = "SELECT * FROM comment WHERE post_num = $post_num ORDER BY comment_num ASC";

			$comment_result = mysqli_query($conn, $comment_sql);
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
	<script src="edit_comment.js"></script>
</head>
<body>
	<div>
		<h2><?php echo $result['title'] ?></h2>
		<?php
			if(isset($_SESSION['user_id']))
			{
				if($_SESSION['user_id'] == $result['user_id'])
				{
					$heredoc = <<<HERE
					<button onclick="location.href='delete.php?number={$result['post_num']}'">삭제</button>
					<button onclick="location.href='edit.php?number={$result['post_num']}'">수정</button>
					HERE;
					
					echo $heredoc;
				}
			}
		?>
		<p> <?php echo nl2br($result['body']) ?></p>
	</div>
</body>
</html>
