<script>
$(document).ready(function()
{
  $("button.invite").on("click", function()
  {
    var button = $(this);
    var memberid = $(this).attr("id");
    var status = $(this).attr("status");
    
    if (status == undefined || status == "null")
    {
      status = "invited";
    }
    else if (status == "invited")
    {
      status = "null";
    }
    
    $.post("<?php echo $memberUrl; ?>", 
    { 
      eventid: $("input[name=eventid]").val(),
      memberid: memberid,
      status: status
    },
    function()
    {
      if (status == "invited")
      {
        button.html("Einladung gesendet");
      }
      else
      {
        button.html("Einladen");
      }
        button.attr("status", status);
    });
  });

  $("button[name=basedata_next]").on("click", function()
  {
    updateBasedata();
    pageNext();
  });

  $("button[name=members_next]").on("click", function()
  {
    pageNext();
  });

  $("button[name=members_prev]").on("click", function()
  {
    pagePrev();
  });

  $("button[name=comments_prev]").on("click", function()
  {
    pagePrev();
  });

  $("button[name=post_comment]").on("click", function()
  {
    var comment = $("textarea[name=comment]").val();
    if (comment != "")
    {
      $.post("<?php echo $commentUrl; ?>", {
        eventid: $("input[name=eventid]").val(),
        comment: comment
      }, 
      function(data) 
      {
        $("div#event_comments").html(data);
        $("textarea").val("");
      });
    }    
  });

});

function updateBasedata()
{
  var eventTitle = $("input[name=title]").val();
  var eventLocation = $("input[name=location]").val();
  var eventId = $("input[name=eventid]").val();
  
  if (eventTitle != "" && eventLocation != "")
  {
    $.post("<?php echo $basedataUrl; ?>", {
      eventid: eventId,
      title: eventTitle,
      location: eventLocation,
      from_day: $("select[name=from_day]").val(),
      from_month: $("select[name=from_month]").val(),
      from_year: $("select[name=from_year]").val(),
      from_hour: $("select[name=from_hour]").val(),
      from_minute: $("select[name=from_minute]").val(),
      to_day: $("select[name=to_day]").val(),
      to_month: $("select[name=to_month]").val(),
      to_year: $("select[name=to_year]").val(),
      to_hour: $("select[name=to_hour]").val(),
      to_minute: $("select[name=to_minute]").val()
     });
  }
}

</script>

<div id="window">
  <ul id="pages">
    <li>
      <div>
        <h1><?php echo $title; ?></h1>
        <h2>Location festlegen</h2>
        <div id="event_basedata">
        <?php echo $basedataForm; ?>  
        </div>
      </div>
    </li>
    
    <li>
      <div>
        <h1><?php echo $title; ?></h1>
        <h2>Freunde einladen</h2>
        <div id="event_members">
        <?php echo $memberForm; ?>  
        </div>      
      </div>
    </li>
    
    <li>
      <div>
        <h1><?php echo $title; ?></h1>
        <h2>Kommentar abgeben</h2>
        <div id="event_comments">          
        <?php echo $comments; ?>  
        </div>
        <div id="event_commentform">
        <?php echo $commentForm; ?>  
        </div>
      </div>
    </li>     
    
  </ul>
</div>
