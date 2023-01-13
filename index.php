<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>메인페이지</title>
	<style>
		.post_num{width: 70px;}
		.post_title{width: 500px;}
		.user_name{width: 120px;}
		.post_time{width: 100px;}
		th, td{
			border-bottom: 1px solid #444444;
			align-content: center;
		}
		div > a{
			text-decoration: none;
			color: black;
		}
	</style>
	<?php
		session_start();

		$conn = mysqli_connect('localhost', 'kknock', 'kknock', 'test');
		$sql_index = "SELECT * FROM board";
		$result = mysqli_query($conn, $sql_index);
	?>
</head>
<body>
	<div>
		<span style="float:right">
			<?php
				if(!isset($_SESSION['user_name']))
				{
					$heredoc = <<< HERE
					<a href="login.html">로그인</a>하세요.
					HERE;

					echo $heredoc;
				}
				else
				{
					$user_name = htmlspecialchars($_SESSION['user_name']);
					
					$heredoc = <<< HERE
					{$user_name}님 어서오세요
					<button onclick="location.href='logout.php'">로그아웃</button>
					HERE;

					echo $heredoc;
				}
			?>
		</span>
	</div>
	<div style="width:70%; margin: 0 auto;">
		<h1>게시판</h1>
		<div style="width:70%; margin: 0 auto;">
			<form action="search.php" method="get">
				<input type="text" name="query" placeholder="검색">
			</form>
			<table style="margin:0 auto;">
				<thead>
					<tr>
						<th class="post_num">번호</th>
						<th class="post_title">제목</th>
						<th class="user_name">아이디</th>
						<th class="post_time">작성일시</th>
					</tr>
				</thead>
				<tbody>
					<!-- <a href='flag.php'>숨겨진 페이지</a> -->
					<?php
						while($row = mysqli_fetch_assoc($result))
						{
							$title = htmlspecialchars($row['title']);
							$user_id = htmlspecialchars($row['user_id']);
							$heredoc = <<< HERE
							<tr>
								<td class="post_num" style="text-align: center;">{$row['post_num']}</td>
								<td class="post_title"><a href="view.php?number={$row['post_num']}">{$title}</a></td>
								<td class="user_name" style="text-align: center;">{$user_id}</td>
								<td class="post_time">{$row['posted']}</td>
							</tr>
							HERE;

							echo $heredoc;
						}
					
					?>
				</tbody>
			</table>
		</div>
		<?php
			if(isset($_SESSION['user_id']))
			{
				$heredoc = <<< HERE
				<button onclick="location.href='write.html'" style="float:right">
				<span>글쓰기</span>
				</button>
				HERE;

				echo $heredoc;
			}
		?>
		
	</div>
</body>
</html>
