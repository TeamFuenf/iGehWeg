<div id="window">
  <ul id="pages">
    <li>
        <div class="userprofile">
        <img src="<? echo $user->picture; ?>"/>
        <?php echo $user->name; ?>
        </div>

        <div class="contentbox">
        	<ul>
        		<li>
	      	<?php
	        	if (empty($newmessages) || count($newmessages) < 1)
	            {
	              echo anchor("mail/inbox", "<img src='../../images/message.png' /><div id='button_header'>Nachrichten<br><span class='additional_text'>Du hast keine neuen Nachrichten</span></div>", 'class="button_long"');
	            }
	            else
	            {
	              echo anchor("mail/inbox", "<img src='../../images/new_message.png' /><span id='new_messages'>&nbsp;".count($newmessages)."</span><div id='button_header'>Nachrichten<br><span class='additional_text'>Du hast ".count($newmessages)." neue Nachricht(en)</span></div>", 'class="button_long"');
	            }
			?>		
				</li>
				<li><?php echo $eventlink; ?></li>
				<li><?php echo $locationlink; ?></li>
				<li><?php echo $logoutlink; ?></li>	
			</ul>                
        </div>
    </li>
  </ul>
</div>
