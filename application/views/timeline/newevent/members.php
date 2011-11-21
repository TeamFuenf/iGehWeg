<script src="../../javascript/jquery.js"></script>
<script src="../../javascript/jquery-ui.js"></script>
<script>
$(function() {

  $("html").disableSelection();
  
  $("#friendlist ul").on("click", "li", function(){
    var button = $(this).find("span.button");
    button.removeClass("button-plus").addClass("button-minus").html("-");
    $("#memberlist ul").append(this);
  });
  
  $("#memberlist ul").on("click", "li", function(){
    var button = $(this).find("span.button");
    button.removeClass("button-minus").addClass("button-plus").html("+");
    $("#friendlist ul").append(this);
  });

});

</script>

<style>
  li
  {
    background-color:#ddd;
    -moz-border-radius: 8px;
    margin:2px;
    width:400px;
  }    
  
  .button
  {
    margin-left:100px;
    display:inline-block;
    width:32px;
    height:32px;
    border:3px solid white;
    -moz-border-radius: 20px;
    line-height:32px;
    text-align:center;
    background-color:#ccc;
  }

  .button-plus
  {
    background-color:#669933;
    color:#fff;
    font-weight:bold;
    font-size:32px;
  }
  
  .button-minus
  {
    background-color:#ff0000;
    color:#fff;
    font-weight:bold;
    font-size:32px;
  }
</style>

<h1>neues Event erstellen</h1>
<h2>Freunde einladen</h2>
<span id="eventId" style="display:none;"><?php echo $eventid; ?></span>
<div id="friendlist">
<?php echo $friendlist; ?>  
</div>
<div id="memberlist">
<?php echo $memberlist; ?>
</div>
<div id="">
<a href="3"><button>weiter</button></a>  
</div>
