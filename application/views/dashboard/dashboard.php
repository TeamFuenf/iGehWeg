<div id="window">
  <ul id="pages">
    <li>
        <div class="userprofile">
        <img src="<? echo $user->picture; ?>"/>
        Hallo, <?php echo $user->name; ?>
        </div>
        
        <?php echo $logoutlink; ?>
		
        <div class="contentbox">
        	<ul>
			        <?php
			          //echo "<ul>";
			          // foreach ($knearestfriends as $friend)
			          // {
			            // if ($friend->distance < 5000)
			            // {
			              // echo "<li id='friend_info'>".img($friend->picture)." ".$friend->name." (ca. ".$friend->distance."m)</li>";              
			            // }
			          // }
			          //echo "<ul>";
			        ?>
			   <li id="friend_info">
			   		
			   		<canvas id="myDrawing" width="300" height="303" style="margin-left: 170px">
						<p>Your browser doesn't support canvas.</p>
					</canvas>
			   		
			   		<script>
			   			var drawingCanvas = document.getElementById('myDrawing');
						// Check the element is in the DOM and the browser supports canvas
						if(drawingCanvas.getContext) {
							// Initaliase a 2-dimensional drawing context
							var context = drawingCanvas.getContext('2d');
							// Create the yellow face
							context.strokeStyle = "#FFFFFF";
							//context.fillStyle = "#FFFF00";
							context.beginPath();
							context.arc(150,150,145,0,Math.PI*2,true);
							context.closePath();
							context.stroke();
							//context.fill();
							
							var context1 = drawingCanvas.getContext('2d');
							// Create the yellow face
							context1.strokeStyle = "#FFFFFF";
							context1.fillStyle = "#FFFFFF";
							context1.beginPath();
							context1.arc(150,150,2,0,Math.PI*2,true);
							context1.closePath();
							context1.stroke();
							context1.fill();
							
							var context2 = drawingCanvas.getContext('2d');
							// Create the yellow face
							context2.strokeStyle = "#FFFFFF";
							context2.fillStyle = "red";
							context2.beginPath();
							context.arc(200,180,10,0,Math.PI*2,true);
							context2.closePath();
							context2.stroke();
							context2.fill();
							
							var context3 = drawingCanvas.getContext('2d');
							// Create the yellow face
							context3.strokeStyle = "#FFFFFF";
							context3.fillStyle = "green";
							context3.beginPath();
							context.arc(220,190,10,0,Math.PI*2,true);
							context3.closePath();
							context3.stroke();
							context3.fill();
						}
			   		</script>
			   </li>
        		<li>
			      	<?php
			        	if (empty($newmessages) || count($newmessages) < 1)
			            {
			              echo anchor("mail/inbox", "<img src='../../images/message.png' /><div id='button_header'>Nachrichten<br><span class='additional_text'>Du hast keine neuen Nachrichten</span></div>", 'class="button_long"');
			            }
			            else
			            {
			              // echo anchor("mail/inbox", "<img src='../../images/new_message.png' /><span id='new_messages'>&nbsp;".count($newmessages)."</span><div id='button_header'>Nachrichten<br><span class='additional_text'>Du hast ".count($newmessages)." neue Nachricht(en)</span></div>", 'class="button_long"');
						  echo anchor("mail/inbox", "<img src='../../images/new_message.png' /><div id='button_header'>Nachrichten<br><span class='additional_text'>Du hast ".count($newmessages)." neue Nachricht(en)</span></div>", 'class="button_long"');
			            }
					?>		
				</li>
				<li><?php echo $eventlink; ?></li>
				<li><?php echo $locationlink; ?></li>
			</ul>                
        </div>
    </li>
  </ul>
</div>
