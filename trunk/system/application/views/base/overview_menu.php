<div id="main_menu" class="yuimenu" style="text-align: left;">
	<div class="bd">
		<h6 class="first-of-type">Months</h6>
		<ul class="first-of-type">
			<?php
			foreach($available_months as $month) {
			?>
			<li class="yuimenuitem">
				<a class="yuimenuitemlabel" href="budget/month/<?=$month->month_id?>">
					<?=$month->pretty_name . " " . $month->year;?>
				</a>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>

<script type="text/javascript">
	//var mainMenu = new YAHOO.widget.Menu("main_menu", {visible:true, clicktohide:false});
	//mainMenu.render();
</script>
