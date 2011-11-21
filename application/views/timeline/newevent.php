<script src="/../../javascript/jquery.js"></script>
<script>

  var boxWidth = 320;

$(document).ready(function() {

  $("#gotostep1").on("click", function() {
    updateMembers();
    
    $("ul.steps").animate({left : "0px"}, 1000);
  });

  $("#gotostep2").on("click", function() {
    updateLocation();

    $("ul.steps").animate({left : "-320px"}, 1000);
  });

  $("#gotostep3").on("click", function() {
    updateLocation();
    updateMembers();

    $("ul.steps").animate({left : "-640px"}, 1000);
  });

// ----------------------------------------------------------------------------

  $("ul.friends li").on("click", function() {
    var attr = $(this).attr("selected");
    if (typeof attr !== 'undefined' && attr !== false)
    {
      $(this).removeAttr("selected");  
      $(this).css("background-color","#dddddd");
    }
    else
    {
      $(this).attr("selected",true);
      $(this).css("background-color","#669933");
    }
  });
  
// ----------------------------------------------------------------------------
  
  //TODO Kommentar abschicken
  
});

// ----------------------------------------------------------------------------

function updateLocation()
{
  var eventTitle = $("input[name=title]").val();
  var eventLocation = $("input[name=location]").val();
  
  if (eventTitle != "" && eventLocation != "")
  {
    $.post("updateLocation", {
      title: eventTitle,
      location: eventLocation,
      from_hour: $("select[name=from_hours]").val(),
      from_minute: $("select[name=from_minutes]").val(),
      to_hour: $("select[name=to_hours]").val(),
      to_minute: $("select[name=to_minutes]").val()
     });
  }
}

function updateMembers()
{
  var memberArray = new Array();
  $("ul.friends li[selected]").each(function (){
    memberArray.push($(this).attr("id"));
  });

  $.post("updateMembers", {
    "members[]": memberArray 
  });
}

</script>

<style>

body
{
  overflow:hidden;
}

ul.steps > li
{
  background-color:#eee;
  list-style:none;
  width:320px;
  height:440px;
  float:left;
}

ul.steps > li > div
{
  padding:15px;
}

ul.steps
{
  position:absolute;
  left:0px;
  top:0px;
  width:300%;
  height:100%;
  margin:0px;
  padding:0px;
}

div.window
{
  position:absolute;
  left:100px;
  top:100px;
  overflow: hidden;
  width:320px;
  height:480px;
  border:1px solid red;
}

div.controls
{
  position:absolute;
  left:0px;
  bottom:0px;
  width:320px;
  height:40px;
  background-color:#999;
  text-align:center;
}

ul.friends
{
  margin:0px;
  padding:0px;
  list-style-type:none;
}

ul.friends li
{
  margin-bottom:5px;
  background:#ddd;
  width:100%;
  line-height:44px;
  height:44px;
}

</style>

<div class="window">  

  <ul class="steps">
    <li id="step1">
      <div>
        <h1>neues Event erstellen</h1>
        <h2>Location festlegen</h2>
        <div id="newEventForm">
        <?php echo $step1form; ?>  
        </div>
      </div>
    </li>
    
    <li id="step2">
      <div>
        <h1>neues Event erstellen</h1>
        <h2>Freunde einladen</h2>
        <div id="newMemberForm">
        <?php echo $step2form; ?>  
        </div>      
      </div>
    </li>
    
    <li id="step3">
      <div>
        <h1>neues Event erstellen</h1>
        <h2>Kommentar abgeben</h2>
        <div id="comments"></div>
        <div id="newCommentForm">
        <?php echo $step3form; ?>  
        </div>
      </div>
      <?php echo $backlink; ?>
    </li>  
  </ul>

  <div class="controls">
    <button id="gotostep1"><b>1</b></button>
    <button id="gotostep2">2</button>
    <button id="gotostep3">3</button>    
  </div>

</div>
