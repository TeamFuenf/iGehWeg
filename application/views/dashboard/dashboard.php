<style>

  div.userprofile
  {
    -moz-border-radius: 0.25em;
    border-radius: 0.25em;
    color:rgba(0,0,0,0.5);
    background-color:rgba(0,0,0,0.1);
    position:relative;
    width:auto;
    height:2em;
    line-height:2em;
    font-size:2em;
    padding-left:2.5em;
    padding-right:0.5em;
  }
  
  div.userprofile img
  {
    border-top-left-radius:0.25em;
    border-bottom-left-radius:0.25em;
    -moz-border-radius-bottomleft:0.25em;
    -moz-border-radius-topleft:0.25em;
    position:absolute;
    top:0px;
    left:0px;
    height:100%;
    max-width:2em;
    max-height:2em;
  }

  div.contentbox
  {
    -moz-border-radius: 0.5em;
    border-radius: 0.5em;
    background-color:rgba(0,0,0,0.1);
    color:#666;
    padding:1em;
    margin-top:0.5em;
    margin-bottom:0.5em;
  }
  
  #pages ul
  {
    margin:0px;
    padding:0px;
    list-style-type:none;
  }

  #pages ul li
  {
    padding-top:1em;
    padding-bottom:1em;
  }

  #pages a
  {
    color:#666;
    text-decoration:none;
  }
    
</style>

<div id="window">
  <ul id="pages">
    <li>
      <div>
        <div class="userprofile">
        <img src="<? echo $user->picture; ?>"/>
        <?php echo $user->name; ?>
        </div>

        <div class="contentbox">
          <?php
            if (empty($newmessages) || count($newmessages) < 1)
            {
              echo anchor("mail/inbox", "Du hast keine neuen Nachrichten");
            }
            else
            {
              echo anchor("mail/inbox", "Neue Nachrichten: ".count($newmessages));
            }
          ?>  
        </div>
        
        <div class="contentbox">
          <ul>
            <li><?php echo $eventlink; ?></li>
            <li><?php echo $friendlink; ?></li>
            <li><?php echo $locationlink; ?></li>
            <li><?php echo $logoutlink; ?></li>
          </ul>                
        </div>
      </div>

        <div class="contentbox">
          <a href="javascript:page(1);">Login / Benutzer wechseln</a>
        </div>

    </li>
    <li>
      <div>
        <h1>Seite 2</h1>
        <?php echo $loginform; ?>        
      </div>
    </li>
    <li>
      <div>
        <h1>Seite 3</h1>
      </div>
    </li>
  </ul>
</div>
