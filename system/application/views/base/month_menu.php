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
		<h6>Months</h6>
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
