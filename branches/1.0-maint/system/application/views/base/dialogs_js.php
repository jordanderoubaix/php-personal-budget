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
			
			Event.observe(window, "load", function() {
				newProjectedIncomeDialog = 
					new YAHOO.widget.Dialog("projectedIncomeDialog", 
						{ 	width: "350px",
						  	fixedcenter: true,
						  	close: true,
						  	draggable: false,
						  	zindex: 400,
						  	modal: true,
						  	visible: false });
						  	
				var projectedIncomeDialogButtons = [	{ text:"Submit", handler:handleProjectedIncome },
														{ text:"Cancel", handler:handleFormCancel }	];
													
				newProjectedIncomeDialog.cfg.queueProperty("buttons", projectedIncomeDialogButtons);
				newProjectedIncomeDialog.cfg.queueProperty("postmethod", "async");
				newProjectedIncomeDialog.callback.success = handleFormSuccess;
						  	
				newProjectedIncomeDialog.render();
			});
			
			function handleProjectedIncome() {
				
				if($('newprojectedincome').value == "") {
					alert ("You must enter a new projected income amount!");
					return false;
				}
				newProjectedIncomeDialog.hide();
				
				var month_id = escape($('projected_income_month_id').value);
				var projected_amount = escape($('newprojectedincome').value);
				var post_body = "month_id=" + month_id + "&projected_amount=" + projected_amount;
				var url = "<?=base_url()?>budget/changeprojectedincome";
				
				new Ajax.Request(url, {
					method: 'post',
					postBody: post_body,
					onSuccess: function(transport) {
						load_categories();
						load_summary();
					}
				});
			}
					
			Event.observe(window, "load", function() {
				addIncomeDialog =
					new YAHOO.widget.Dialog("incomeDialog",
						{	width: "350px",
						  	fixedcenter: true,
						  	close: true,
						  	draggable: false,
						  	zindex: 400,
						  	modal: true,
						  	visible: false });
						  	
				var incomeDialogButtons = [	{ text:"Submit", handler:handleAddIncome },
											{ text:"Cancel", handler:handleFormCancel }	];
						  	
				addIncomeDialog.cfg.queueProperty("buttons", incomeDialogButtons);
				addIncomeDialog.cfg.queueProperty("postmethod", "async");
				addIncomeDialog.callback.success = handleFormSuccess;
						  	
				addIncomeDialog.render();	
			});	  	
			
			function handleAddIncome() {
				addIncomeDialog.hide();
				if ($('add_income_amount').value == "") {
					alert ("You must put an amount into the 'Income Amount'");
				}
				
				var month_id = escape($('add_income_month_id').value);
				var income_amount = escape($('add_income_amount').value);
				var post_body = "month_id=" + month_id + "&income_amount=" + income_amount;
				var url = "<?=base_url()?>budget/monthaddincome";
				
				new Ajax.Request(url, {
					method: 'post',
					postBody: post_body,
					onSuccess: function(transport) {
						load_categories();
						load_summary();
					}
				});
			}
				
			Event.observe(window, "load", function() {
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
						load_summary();
					}
				});
			}

			Event.observe(window, "load", function() {
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
				var expense_amount = escape(document.forms['expense_form'].expense_amount.value);
				var expense_description = escape(document.forms['expense_form'].expense_desc.value);
				var expense_category_id = escape(document.forms['expense_form'].category_id.value);
				
				if (expense_amount == "") {
					alert ("You must enter an amount for the expense!");
					return false;
				}
				
				if (expense_description == "") {
					alert ("You must enter a description for the expense!");
					return false;
				}
				
				post_body = 'expense_amount=' + expense_amount + '&expense_desc=' + expense_description + '&category_id=' + expense_category_id;
				addExpenseDialog.hide();
				var url = "<?=base_url()?>budget/addexpense/<?=$month_id?>";
				new Ajax.Request(url, {
					method: 'post',
					postBody: post_body,
					onSuccess: function(transport) {
						load_categories();
						load_summary();
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
			
			var move_forward = true;
			
			function handleAddCategory() {
				var category_name = escape(document.forms['add_category_form'].newcategory.value);
				var category_budget = escape(document.forms['add_category_form'].newcatbudget.value);
				var post_body = 'newcategory=' + category_name + '&newcatbudget=' + category_budget;
				
				if (category_name == "") {
					alert ("You must enter a category name!");
					return false;
				}
				
				var url = "<?=base_url()?>budget/addcategory/<?=$month_id?>/" + category_name;
				new Ajax.Request(url, {
					method: 'post',
					postBody: post_body,
					onSuccess: function(transport) {
						var json = transport.responseText.evalJSON();
						if (json.code == <?=ADDED_CATEGORY?>) {
							addCategoryDialog.hide();
							load_categories();
						} else if (json.code == <?=DUPLICATE_CATEGORY?>) {
							alert ("There is already a category by that name!");
						}
					},
					onFailure: function(transport) {
						alert ("There was an error when trying to add your category!");
					}
				});

				return false;
			}

			Event.observe(window, "load", function() {
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
				
				var new_name = escape(document.forms['rename_category_form'].new_name.value);
				var category_id = document.forms['rename_category_form'].category_id.value;
				
				if (new_name == "") {
					alert ("You must enter a new name for the category!");
					return false;
				}
				
				renameCategoryDialog.hide();
				
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
			
			Event.observe(window, "load", function() {
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
			
		// ]]> 	
		</script>
