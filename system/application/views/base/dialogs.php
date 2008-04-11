		<!--
			This is the change projected income dialog. 
		 -->
		<div id='projectedIncomeDialog' style="visibility: hidden;">
			<div class='hd'>
				New Projected Income
			</div>
			<div class='bd'>
				<form name='projected_income_form' method='post' action='<?=$this->config->item('base_url')?>budget/monthprojectedincome'>
					<table class='dialogtable'>
						<tr>
							<td align='right'>Select a Month:</td>
							<td>
								<select name='month_id' id='projected_income_month_id'>
									<?php
										foreach($available_months as $month) {
											print '<option value="' . $month->month_id . '">';
											print $month->pretty_name . ' ' . $month->year;
											print '</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td align='right'>New Projected Income:</td>
							<td>
								<input type='text' name='newprojincome' id='newprojectedincome' />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		
		<!--
			This is the add income dialog. 
		 -->
		<div id='incomeDialog' style="visibility: hidden;">
			<div class='hd'>
				Add Income Source
			</div>
			<div class='bd'>
				<form name='projected_income_form' method='post' action='<?=$this->config->item('base_url')?>budget/monthaddincome'>
					<table class='dialogtable'>
						<tr>
							<td align='right'>Select a Month:</td>
							<td>
								<select name='month_id' id='add_income_month_id'>
									<?php
										foreach($available_months as $month) {
											print '<option value="' . $month->month_id . '">';
											print $month->pretty_name . ' ' . $month->year;
											print '</option>';
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Income Amount:</td>
							<td>
								<input type='text' name='income_amount' id='add_income_amount' />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		
		<!--
			This is the add expense dialog. 
		 -->
		<div id='expenseDialog' style="visibility: hidden;">
			<div class='hd'>
				Add New Expense for <?= $month_data['month_pretty_name'] ?> <?= $month_data['month_year']?>
			</div>
			<div class='bd'>
				<form name='expense_form' method='post' action='<?=$this->config->item('base_url')?>budget/submitexpense'>
					<input type="hidden" name="category_id" value="" />
					<table class='dialogtable'>
						<tr>
							<td class='dialog_label' align='right'>Category:</td>
							<td id="expense_cat_name"></td>
							<!--td class='dialog_input' align='left'>
								<select name='category_id'>
									<?php
										foreach($categories as $category) {
											print '<option value="' . $category['category_id'] . '">';
											print $category['pretty_name'];
											print '</option>';
										}
									?>
								</select>
							</td-->
						</tr>
						<tr>
							<td class='dialog_label' align='right'>Expense Amount:</td>
							<td class='dialog_input'>
								<input type='text' name='expense_amount' class='textbox' />
							</td>
						</tr>
						<tr>
							<td class='dialog_label' align='right'>Expense Description:</td>
							<td class='dialog_input'>
								<input type='text' name='expense_desc' class='textbox' />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		
		<!--
			This is the change projected income dialog. 
		 -->
		<div id='addCategoryDialog' style="visibility: hidden;">
			<div class='hd'>
				Add a New Category for <?= $month_data['month_pretty_name'] ?> <?= $month_data['month_year']?>
			</div>
			<div class='bd'>
				<form name='add_category_form' method='post' action='<?=$this->config->item('base_url')?>budget/addcategory/<?=$month_id?>'>
					<table class='dialogtable'>
						<tr>
							<td class='dialog_label' width='50%' align='right'>Category Name:</td>
							<td class='dialog_input' width='50%'>
								<input type='text' name='newcategory' />
							</td>
						</tr>
						<tr>
							<td class='dialog_label' align='right'>Category Budget:</td>
							<td class='dialog_input'>
								<input type='text' name='newcatbudget' value='0' />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>

		<div id='deleteCategoryDialog' style="visibility: hidden;">
			<div class='hd'>
				Delete a Category for <?= $month_data['month_pretty_name'] ?> <?= $month_data['month_year']?>
			</div>
			<div class='bd'>
				<form name='delete_category_form' method='post' action='<?=$this->config->item('base_url')?>budget/deletecategory'>
					<table class='dialogtable'>
                    	<tr>
                        	<td class='dialog_label' align='right' width="50%">Category:</td>
                        	<td class='dialog_input' align='left' width="50%">
                            	<select name='category_id'>
                                	<?php
                                    	foreach($categories as $category) {
                                        	print '<option value="' . $category['category_id'] . '">';
                                        	print $category['pretty_name'];
                                        	print '</option>';
                                    	}
                                	?>
                            	</select>
                        	</td>
                    	</tr>
					</table>
				</form>
			</div>	
		</div>

		<div id='renameCategoryDialog' style="visibility: hidden;">
			<div id='rename_category_header' class='hd'>
				Rename a Category
			</div>
			<div class='bd'>
				<form name='rename_category_form' method='post' action='<?=base_url()?>budget/renamecategory'>
					<input type="hidden" name="category_id" value="" />
					<table class='dialogtable'>
						<tr>
							<td id='rename_category_label' class='dialog_label'>New Name:</td>
							<td class='dialog_input' align='left'>
								<input type='text' name='new_name' value='' />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>

		
		<div id='updateCategoryBudgetDialog' style="visibility: hidden;">
			<div id='update_category_budget_header' class='hd'>
				Update Category Budget
			</div>
			<div class='bd'>
				<form name='update_category_budget_form' method='post' action='<?=base_url()?>budget/updatecategorybudget'>
					<input type="hidden" name="category_id" value="" />
					<table class='dialogtable'>
						<tr>
							<td id="update_category_budget_label" class='dialog_label' align='right'></td>
							<td class='dialog_input' align='left'>
								<input type='text' name='new_budget' value='' />
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
