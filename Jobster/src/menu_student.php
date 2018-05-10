<div class = "full">
	<header class = "mainheader">
		<nav id = "mainheader">
			<ul>
				<li class = "logo">JOBSTER</li>
				<li class = "search"><input type = "text" name = "search" placeholder = "Search..."/><div class = "search_btn"></div></li>
				<li><a href = "#">Help</a></li>
				<li id = "setting"><div class = "setting_btn"></div><span class = "setting_title">Hi, <?php echo $_SESSION['username'];?></span>
					<div class = "setting">
						<div class = "setting_content"><a href="detail_student.php?detail_student=<?php echo $_SESSION['student_id']?>">My info</a></div>
						<div class = "setting_content"><a href="index_student.php?logout='1'">Logout</a></div>
					</div>
				</li>
			</ul>
		</nav>
	</header>
</div>