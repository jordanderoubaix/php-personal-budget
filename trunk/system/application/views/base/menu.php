		<script>
			Event.observe(document, "dom:loaded", function(){
			  new Accordion("accordion");
			});
			Event.observe(document, "dom:loaded", function(){
			  new Accordion("month_accordion");
			});
		</script>
		
		
		
		<div id="accordion">
		    <ul>
		        <li>
		            <div class="toggler">Income</div>
		            <ul class="togglee">
		                <li><a href='javascript:void(0)' onclick='enableProjectedIncomeDialog()'>Change Projected Income</a></li>
		                <li><a href='javascript:void(0)' onclick='enableAddIncomeDialog()'>Add a Paycheck</a></li>
		            </ul>
		        </li>
		        <li>
		            <div class="toggler">Expenses</div>
		            <ul class="togglee">
		                <li><a href='javascript:void(0)' onclick='enableAddExpenseDialog()'>Add an Expense</a></li>
		            </ul>
		        </li>
		        <li>
		            <div class="toggler">Categories</div>
		            <ul class="togglee">
		                <li><a href='javascript:void(0)' onclick='enableAddCategoryDialog()'>Add a Category</a></li>
						<li><a href='javascript:void(0)' onclick='enableDeleteCategoryDialog()'>Delete a Category</a></li>
						<li><a href='javascript:void(0)' onclick='enableRenameCategoryDialog()'>Rename a Category</a></li>
		            </ul>
		        </li>
				<li>
		            <div class="toggler">Last 12 Months</div>
		            <ul class="togglee">
		                <?php
						foreach($available_months as $month) {
							print "<li>";
							print "<a href='" . base_url() . "budget/month/$month->month_id'>";
							print $month->pretty_name . " " . $month->year;
							print "</a>";
							print "</li>";
						}
						?>
		            </ul>
		        </li>
		    </ul>
		</div>
		
		
