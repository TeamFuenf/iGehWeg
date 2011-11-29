<script>
$(document).ready(function()
{
  $("ul.friends li").on("click", function()
  {
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

  $("#scroll a").on("click", function()
  {
  //TODO vorher auf Änderungen prüfen
    updateLocation();
    updateMembers();
  });
    
});

// ----------------------------------------------------------------------------
//TODO Kommentar abschicken
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


</style>

<div id="window">
  <ul id="pages">
    <li>
      <div>
        <h1>neues Event erstellen</h1>
        <h2>Location festlegen</h2>
        <div id="newEventForm">
        <?php echo $step1form; ?>  
        </div>
      </div>
    </li>
    
    <li>
      <div>
        <h1>neues Event erstellen</h1>
        <h2>Freunde einladen</h2>
        <div id="newMemberForm">
        <?php echo $step2form; ?>  
        </div>      
      </div>
    </li>
    
    <li>
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
</div>
