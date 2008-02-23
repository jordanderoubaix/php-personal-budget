		<script type="text/javascript">
		//<![CDATA[ 
			var newProjectedIncomeDialog;
			var addIncomeDialog;
			var addExpenseDialog;
			var addCategoryDialog;
			var deleteCategoryDialog;
			var renameCategoryDialog;


			function IsNumeric(sText) {
				var ValidChars = "0123456789.";
				var IsNumber=true;
				var Char;

 				for (i = 0; i < sText.length && IsNumber == true; i++) { 
      				Char = sText.charAt(i); 
      				if (ValidChars.indexOf(Char) == -1) {
						IsNumber = false;
					}
				}
				return IsNumber;
			}
			
			function get_month_info(month_id) {
				$('month_content').setStyle({'padding':'75px 0 0 0'});
				YAHOO.util.Event.onContentReady('month_content', function() {
					$('month_content').update("<center><img src='<?=base_url()?>resources/images/ajax-loader.gif' /></center>");
				})

				info_url = "<?=base_url()?>budget/month/" + month_id;
				
				var requestSuccess = function(o) {
					$('month_content').setStyle({'padding':'0px 0 0 0'});
					//$('month_content').update(o.responseText);
					YAHOO.util.Event.onContentReady('month_content', function() {
						$('month_content').update(o.responseText);
					})
					
				}
				
				var requestFailure = function(o) {
					$('month_content').setStyle({'padding':'0px 0 0 0'});
					YAHOO.util.Event.onContentReady('month_content', function() {
						$('month_content').update("An error has occured");
					})
				}
				
				var callback = {
					success:requestSuccess,
					failure:requestFailure
				};
				
				var request = YAHOO.util.Connect.asyncRequest('GET', info_url, callback);
			}
			
			function enableProjectedIncomeDialog () {
				newProjectedIncomeDialog.show();
				$('main_menu').setStyle({visibility: 'visible'});
			}
			
			function enableAddIncomeDialog () {
				addIncomeDialog.show();
			}
			
			function enableAddExpenseDialog (category_name, category_id) {
				$('expense_cat_name').update(category_name);
				document.forms['expense_form'].action = "<?=base_url()?>budget/submitexpense/" + category_id;
				document.forms['expense_form'].category_id.value = category_id;
				addExpenseDialog.show();
			}

			function enableRenameCategoryDialog (category_id, category_name) {
				document.forms['rename_category_form'].category_id.value = category_id;
				$('rename_category_header').update('Rename category "' + category_name + '"');
				$('rename_category_label').update('New Name for "' + category_name + '":');
				renameCategoryDialog.show();
			}
			
			function enableUpdateCategoryBudgetDialog (category_id, category_name) {
				document.forms['update_category_budget_form'].category_id.value = category_id;
				$('update_category_budget_header').update('New Budget for "' + category_name + '"');
				$('update_category_budget_label').update('New Budget for "' + category_name + '":');
				updateCategoryBudgetDialog.show();
			}

			function enableAddCategoryDialog () {
				addCategoryDialog.show();
			}
			
			function enableDeleteCategoryDialog () {
				deleteCategoryDialog.show();
			}

			var handleFormSubmit = function() {
				alert (document.forms['expense_form'].action);
				this.submit();
			}
			
			var handleFormCancel = function() {
				this.cancel();
			}
			
			var handleFormSuccess = function() {
				window.location.reload();
			}
			
			var formButtons = [ 	{ text:"Submit", handler:handleFormSubmit },
									{ text:"Cancel", handler:handleFormCancel } ];
			
			function formatCurrency(num) {
				num = num.toString().replace(/\$|\,/g,'');
				if(isNaN(num))
					num = "0";
				sign = (num == (num = Math.abs(num)));
				num = Math.floor(num*100+0.50000000001);
				cents = num%100;
				num = Math.floor(num/100).toString();
				if(cents<10)
					cents = "0" + cents;
				for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
					num = num.substring(0,num.length-(4*i+3))+','+
				num.substring(num.length-(4*i+3));
				return (((sign)?'':'-') + '$' + num + '.' + cents);
			}
			
			function hideMessage() {
				var messages_div = document.getElementById("messages");
				messages_div.innerHTML = '';
			}
			
			YAHOO.namespace("example.container");
			
			YAHOO.example.container.wait = 
					new YAHOO.widget.Panel("wait",  
						{ width:"240px", 
						  fixedcenter:true, 
						  close:false, 
						  draggable:false, 
						  zindex:400,
						  modal:true,
						  visible:false
						} 
					);
			
			YAHOO.example.container.wait.setHeader("Loading, please wait...");
			YAHOO.example.container.wait.setBody('<img src="http://us.i1.yimg.com/us.yimg.com/i/us/per/gr/gp/rel_interstitial_loading.gif" />');
			YAHOO.example.container.wait.render(document.body);
			
			
			
			YAHOO.util.Event.onContentReady("projectedIncomeDialog", function() {
				newProjectedIncomeDialog = 
					new YAHOO.widget.Dialog("projectedIncomeDialog", 
						{ 	width: "350px",
						  	fixedcenter: true,
						  	close: true,
						  	draggable: false,
						  	zindex: 400,
						  	modal: true,
						  	visible: false });
						  	
				newProjectedIncomeDialog.render();
			});
					
			YAHOO.util.Event.onContentReady("incomeDialog", function() {
				addIncomeDialog =
					new YAHOO.widget.Dialog("incomeDialog",
						{	width: "350px",
						  	fixedcenter: true,
						  	close: true,
						  	draggable: false,
						  	zindex: 400,
						  	modal: true,
						  	visible: false });
						  	
				addIncomeDialog.cfg.queueProperty("buttons", formButtons);
				addIncomeDialog.cfg.queueProperty("postmethod", "async");
				addIncomeDialog.callback.success = handleFormSuccess;
						  	
				addIncomeDialog.render();	
			});	  	
				
			YAHOO.util.Event.onContentReady("updateCategoryBudgetDialog", function() {
				updateCategoryBudgetDialog =
					new YAHOO.widget.Dialog("updateCategoryBudgetDialog",
						{	//width: "350px",
						  	fixedcenter: true,
						  	close: true,
						  	draggable: false,
						  	zindex: 400,
						  	modal: true,
						  	visible: false });
				 	
				var updateCatBudgetButtons = [	{ text:"Submit", handler:handleUpdateCategoryBudget },
												{ text:"Cancel", handler:handleFormCancel } ];

				updateCategoryBudgetDialog.cfg.queueProperty("buttons", updateCatBudgetButtons);
				updateCategoryBudgetDialog.cfg.queueProperty("postmethod", "async");
				updateCategoryBudgetDialog.callback.success = handleFormSuccess;
				
				updateCategoryBudgetDialog.render();
			});	

			function handleUpdateCategoryBudget() {
				updateCategoryBudgetDialog.hide();
				var category_id = escape(document.forms['update_category_budget_form'].category_id.value);
				var new_budget = escape(document.forms['update_category_budget_form'].new_budget.value);
				post_body = 'new_budget=' + new_budget + '&category_id=' + category_id;

				var url = "<?=base_url()?>budget/updatecategorybudget/<?=$month_id?>";
				new Ajax.Request(url, {
					method: 'post',
					postBody: post_body,
					onSuccess: function(transport) {
						load_categories();
					}
				});
			}

			YAHOO.util.Event.onContentReady("expenseDialog", function() {
				addExpenseDialog =
					new YAHOO.widget.Dialog("expenseDialog",
						{	width: "350px",
						  	fixedcenter: true,
						  	close: true,
						  	draggable: false,
						  	zindex: 400,
						  	modal: true,
						  	visible: false });
				 	
				var addExpenseButtons = [	{ text:"Submit", handler:handleAddExpense },
											{ text:"Cancel", handler:handleFormCancel } ];

				addExpenseDialog.cfg.queueProperty("buttons", addExpenseButtons);
				addExpenseDialog.cfg.queueProperty("postmethod", "async");
				addExpenseDialog.callback.success = handleFormSuccess;
				
				addExpenseDialog.render();
			});	

			function handleAddExpense() {
				addExpenseDialog.hide();
				var expense_amount = escape(document.forms['expense_form'].expense_amount.value);
				var expense_description = escape(document.forms['expense_form'].expense_desc.value);
				var expense_category_id = escape(document.forms['expense_form'].category_id.value);
				post_body = 'expense_amount=' + expense_amount + '&expense_desc=' + expense_description + '&category_id=' + expense_category_id;

				var url = "<?=base_url()?>budget/addexpense/<?=$month_id?>";
				new Ajax.Request(url, {
					method: 'post',
					postBody: post_body,
					onSuccess: function(transport) {
						load_categories();
					}
				});
			}

			var handleAddForm = function () {
				if (document.add_category_form.newcategory.value == "") {
					alert ("You must have a category name");
					return false;
				}
				if (document.add_category_form.newcatbudget.value == "") {
					alert ("You must enter a category budget amount");
					return false;
				}
				if (!IsNumeric(document.add_category_form.newcatbudget.value)) {
					alert ("The budget value must be a number");
					return false;
				}
				this.submit();
			}

			
			var addFormButtons = [  { text:"Submit", handler:handleAddForm },
			                        { text:"Cancel", handler:handleFormCancel } ];
			
			function handleAddCategory() {
				addCategoryDialog.hide();
				var category_name = escape(document.forms['add_category_form'].newcategory.value);
				var category_budget = escape(document.forms['add_category_form'].newcatbudget.value);
				var post_body = 'newcategory=' + category_name + '&newcatbudget=' + category_budget;
				
				var url = "<?=base_url()?>budget/addcategory/<?=$month_id?>";
				new Ajax.Request(url, {
					method: 'post',
					postBody: post_body,
					onSuccess: function(transport) {
						load_categories();
					}
				});
			}

			YAHOO.util.Event.onContentReady("addCategoryDialog", function() {
				addCategoryDialog = 
					new YAHOO.widget.Dialog("addCategoryDialog", 
						{ 	width: "350px",
						  	fixedcenter: true,
						  	close: true,
						  	draggable: false,
						  	zindex: 400,
						  	modal: true,
						  	visible: false });

				var addCatButtons = [	{ text:"Submit", handler:handleAddCategory },
										{ text:"Cancel", handler:handleFormCancel } ];

				addCategoryDialog.cfg.queueProperty("buttons", addCatButtons);
				addCategoryDialog.cfg.queueProperty("postmethod", "async");
				addCategoryDialog.callback.success = handleFormSuccess;
				
				addCategoryDialog.render();
			});

			function handleRenameCategory() {
				renameCategoryDialog.hide();
				var new_name = escape(document.forms['rename_category_form'].new_name.value);
				var category_id = document.forms['rename_category_form'].category_id.value;
				var post_body = 'new_name=' + new_name + '&category_id=' + category_id;

				var url = "<?=base_url()?>budget/renamecategory/<?=$month_id?>/";
				new Ajax.Request(url, {
					method: 'post',
					postBody: post_body,
					onSuccess: function(transport) {
						load_categories();
					}
				});
			}
			
			YAHOO.util.Event.onContentReady("renameCategoryDialog", function() {
				renameCategoryDialog = 
					new YAHOO.widget.Dialog("renameCategoryDialog",
						{	//width: "350px",
							fixedcenter: true,
							close: true,
							draggable: false,
							zindex: 400,
							modal: true,
							visible: false });

				var renameCatButtons = [	{ text:"Submit", handler:handleRenameCategory },
											{ text:"Cancel", handler:handleFormCancel } ];

				renameCategoryDialog.cfg.queueProperty("buttons", renameCatButtons);
				renameCategoryDialog.cfg.queueProperty("postmethod", "async");
				renameCategoryDialog.callback.success = handleFormSuccess;

				renameCategoryDialog.render();
			});
			
			YAHOO.util.Event.onContentReady("deleteCategoryDialog", function() {
				deleteCategoryDialog =
					new YAHOO.widget.Dialog("deleteCategoryDialog",
						{	width: "350px",
							fixedcenter: true,
							close: true,
							draggable: false,
							zindex: 400,
							modal: true,
							visible: false });
				deleteCategoryDialog.cfg.queueProperty("buttons", formButtons);
				deleteCategoryDialog.cfg.queueProperty("postmethod", "async");
				deleteCategoryDialog.callback.success = handleFormSuccess;

				deleteCategoryDialog.render();
			});	


			//function enableProjectedIncomeDialog {
			//	newProjectedIncomeDialog.show();
			//}
		// ]]> 	
		</script>
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
								<select>
									<option>January</option>
									<option>February</option>
									<option>March</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align='right'>New Projected Income:</td>
							<td>
								<input type='text' name='newprojincome' />
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
								<select name='month_id'>
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
								<input type='text' name='income_amount' />
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
