<style>

#events ul
{
  list-style-type:none;
  margin:0px;
  padding-left:20px;
  padding-right:20px;
  
  width:auto;
}

#events button.title
{
  width:85%;
  padding:15px;
  text-align:left;
}

#events button.edit
{
  width:10%;
  padding:15px;
}

#events a
{
  text-decoration:none;
}  

</style>

<?php echo $createlink; ?>

<div id="events">
<h1>Events:</h1>  
<?php echo $events; ?>
</div>