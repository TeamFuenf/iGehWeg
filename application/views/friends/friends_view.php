<head>
	<link rel="stylesheet" type="text/css" href="../css/friends_mainview_style.css">
	
	<script src="../javascript/jquery.js" ></script>
	<script src="../javascript/jquery-ui.js" ></script>
	
	<script>
		$(function() {
			$( "#sortable" ).sortable();
			$( "#sortable" ).disableSelection();
		});
	</script>
</head>
<body>
	<div id="friends">
		<div id="friends_you"><div class="imgbox"><img align='absmiddle' src="http://profile.ak.fbcdn.net/hprofile-ak-ash2/260743_1054310596_3552414_n.jpg" /></div> <?php echo $current_user  ?> </div>
		<div id="friends_add"><a href="">+</a></div>
		<div id="friends_list">
			<div class="demo">
				<ul id="sortable">
					<?php
						$names = $friends["friend_names"];
						$pics = $friends["friend_pics"];
						foreach($names as $name)
						{
							echo "<li class='ui-state-default friend_list_entry'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span><img align='absmiddle' src='".$pics."'/> ".$name."</li>";	
						}
					?>
				</ul>
			</div>
		</div>
		<div id="friends_groups"><a href="">groups</a></div>
	</div>
</body>