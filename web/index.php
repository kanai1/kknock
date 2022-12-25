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
		$sql_index = "SELECT * FROM board ORDER BY post_num $order";
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
					$heredoc = <<< HERE
					{$_SESSION['user_name']}님 어서오세요
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
						<th class="user_name">글쓴이</th>
						<th class="post_time">작성일시</th>
					</tr>
				</thead>
				<tbody>
					<?php
						while($row = mysqli_fetch_assoc($result))
						{
							$heredoc = <<< HERE
							<tr>
								<td class="post_num" style="text-align: center;">{$row['post_num']}</td>
								<td class="post_title"><a href="view.php?number={$row['post_num']}">{$row['title']}</a></td>
								<td class="user_name" style="text-align: center;">{$row['user_name']}</td>
								<td class="post_time">{$row['posted']}</td>
							</tr>
							HERE;

							echo $heredoc;
						}
					?>
				</tbody>
			</table>
		</div>
		<button onclick="location.href='write.html'" style="float:right">
			<span>글쓰기</span>
		</button>
	</div>
</body>
</html>
