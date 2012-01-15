<style>
  
</style>
<script src="../javascript/jquery.js"></script>




<div id="window">
  <ul id="pages">
    <li>
      <div id="locationdetails">
        <h2><?php echo $location->name; ?></h2>
        Straße: <?php echo $location->street; ?><br>
        Stadt: <?php echo $location->city; ?><br>
        Typ: <?php echo $location->type; ?><br>
        Internet: <?php echo $location->internet; ?><br>
        E-Mail: <?php echo $location->email; ?>
      </div>
      
    </li>
  </ul>
</div>