<script type="text/javascript">
	function add_this_month() {
		var url = "<?=base_url()?>budget/addthismonth";
		new Ajax.Request(url, {
			method: 'get',
			onSuccess: function(transport) {
				var json = transport.responseText.evalJSON();
				if (json.code == <?=MONTH_CREATED?>) {
					window.location.reload();
				} else if (json.code == <?=MONTH_EXISTS?>) {
					alert ("The current month already exists");
				}
			},
			onFailure: function(transport) {
				alert(transport.responseText);
			}
		});
	}
</script>

<div id="main_menu" class="yuimenu" style="text-align: left;">
	<div class="bd">
		<h6 class="first-of-type">Income</h6>
		<ul>
			<li class="yuimenuitem">
				<a class="yuimenuitemlabel" href="#changeprojectedincome" onclick="enableProjectedIncomeDialog()">Change Projected Income</a>
			</li>
			<li class="yuimenuitem">
				<a class="yuimenuitemlabel" href="#addpaycheck" onclick="enableAddIncomeDialog()">Add a Paycheck</a>
			</li>
		</ul>
		<h6>Expenses</h6>
		<ul>
			<li class="yuimenuitem">
				<a class="yuimenuitemlabel" href="#addexpense" onclick="enableAddExpenseDialog()">Add an Expense</a>
			</li>
		</ul>
		<h6>Categories</h6>
		<ul>
			<li class="yuimenuitem">
				<a class="yuimenuitemlabel" href="#addcategory" onclick="enableAddCategoryDialog()">Add a Category</a>
			</li>
			<li class="yuimenuitem">
				<a class="yuimenuitemlabel" href="#deletecategory" onclick="enableDeleteCategoryDialog()">Delete a Category</a>
			</li>
			<!--li class="yuimenuitem">
				<a class="yuimenuitemlabel" href="#renamecategory" onclick="enableRenameCategoryDialog()">Rename a Category</a>
			</li-->
		</ul>
		<h6>Months <img src="<?=base_url()?>resources/icons/add14x14.png" alt="Add the Current Month" title="Add the Current Month" style="cursor: pointer" onclick="add_this_month();"/></h6>
		<ul class="first-of-type">
			<?php
			foreach($available_months as $month) {
			?>
			<li class="yuimenuitem">
				<a class="yuimenuitemlabel" href="<?=$month->month_id?>">
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
