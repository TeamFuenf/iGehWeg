<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../../css/main_style.css">
		<link rel="stylesheet" type="text/css" href="../../javascript/css/custom-theme/jquery-ui-1.8.16.custom.css">
	<script src="../../javascript/js/jquery.js"></script>
	<script src="../../javascript/js/jquery-ui.js" ></script>
	<script>
				
		$(document).ready(function() {
			
			$(".tooltip_delete").click(function() {
				if($(this).parent().next(".tooltip_hover").is(":hidden")) 
				{
					$(this).parent().next(".tooltip_hover").show();	
					//$(this).html("<");
				} 
				else
				{
					$(this).parent().next(".tooltip_hover").hide();
					//$(this).html(">");
				}
				
			});	
			
			$(".date").datepicker({
					dateFormat: "dd.mm.yy"				
			});
			
			$(".device").click(function() {
				var number = $(this).attr("id");
				console.log(number);
				$("#hidden_geraet").attr("value", number);
				console.log($("#hidden_geraet").attr("value"));
				$("#goal").html(number);
				$("#goal").css("background-color", "#1BA1E2");
				$("#goal").css("border", "1px solid #F0F0F0");
			});
			
			
			var availableTags = ["Anja Labandowsky","Kristin Häfemeier","Krissi Eberle","Saskia Wachter",
			"Benjamin Hartwich","Lisa Kohn","Hanna Hemken to Krax","Martin Gustorf","Johann Angermann",
			"Julia Lehnerer","Laura Ohm","Martin Gahr","Martin Führer","Nora","Peter Penjak","Philipp Fauser",
			"Radu Gota","Sarah Scheck","Sarah Köhler","Theres Denzinger","Ulla","Vera Feix","Valentin Brandes",
			"Klaus Kerschensteiner","Julie Ament","Fritz Marquardt","Gabriela Schanz","Antonia Restemeier",
			"Simon Lorenz","Silja Steinert","Stefan Bobby Josef","Hannes Liedl","Lucas Mußmächer","Martin Hebel",
			"Matthias Bünger","Matthias Eichinger","Thordes Herbst","Julia Witte","Thomas Adamski","Senta Hirscheider",
			"Andreas Brumm","Tobias Schmidt","Vinzenz Greiner","Johanna Mayerhofer","Anna-Lina Linck",
			"Valerie Rhein","Saskia Kanzler","Oliver Moebel","Sarah Tümmler","Franzi Harter","Astrid Ehrenhauser"];
			
			$("#name").autocomplete({
				source: availableTags
			});	
		});
		
	</script>
	</head>
	<body>
		<div id="content">
			
			<!-- DEVICES -->
			
			<div id="devices">
				<?php for($i = 1; $i <= 5; $i++) : ?>
					<div class="device_wrap"><div id="<?php echo $i;?>" class="device"><?php echo $i;?></div></div>
				<?php endfor; ?>
			</div>
			
			<!-- TOOLTIPS -->
			
			<div id="tooltips">
			<?php for($i = 0; $i < 5; $i++) : ?>
				<div id="tooltip0<?php echo $i+1; ?>" class="tooltip">
					<div class="tri"></div>
					<div class="tooltip_wrapper">
						<div class="tooltip_entry">
							zuletzt ausgeliehen von:<br />
							<span class="tooltip_name"><?php echo $latest[$i]->NAME; ?></span><br />
							<?php echo $latest[$i]->VON; ?> - <?php echo $latest[$i]->BIS; ?>
						</div>
						<div class="tooltip_delete">x</div>
					</div>
					<div class="tooltip_hover"><a href="/entry_control/studio/<?php echo $i+1; ?>" class="tooltip_links tooltip_studio">im Studio</a><a href="/entry_control/reset_entry/<?php echo $i+1; ?>" class="tooltip_links tooltip_studio">zurucksetzen</a></div>
				</div>
			<?php endfor; ?>	
			</div>
			
			<!-- FORM -->
			
			<div id="form">
				<div id="goal"></div>
				<ul id="infos">
					<li>Klicke bitte auf das Feld mit dem <br /> ausgeliehenen Geraet!</li>
					<li>Bei Rueckgabe des Geraets auf<br /> "x" -> "im Studio" klicken!</li>
					<li>Bei Falscheingabe auf <br /> "x" -> "zuruecksetzen" klicken!</li>
				</ul>
				<form id="form_field" action="/entry" method="post">
					<input type="hidden" name="geraet" id="hidden_geraet"/>
					Name:<br />
					<input id="name" type="text" name="name" /><br />
					von:<br />
					<input class="date" type="text" name="von" readonly="readonly"/><br />
					bis:<br />
					<input class="date" type="text" name="bis" readonly="readonly"/><br />
					<input type="submit" value="eintragen" id="ok_button"/>
				</form>
			</div>
			
			<!-- HISTORY -->
			
			<div id="history">
				<div id="history_head">HISTORY</div>
				<?php if(isset($entries)) : ?>
					<table id="table">
					<tr>
						<th>Name</th>
						<th>Geraet</th>
						<th>von</th>
						<th>bis</th>
					</tr>
						<?php foreach ($entries as $row) : ?>
							<tr>
								<td><?php echo $row->NAME; ?></td>
								<td><?php echo $row->GERAET; ?></td>
								<td><?php echo $row->VON; ?></td>
								<td><?php echo $row->BIS; ?></td>
							</tr>
						<?php endforeach; ?>							
					</table>
					
				<?php endif; ?>
			</div>
		</div>
	</body>
</html>