<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

		<title>PHP Budget</title>
		<!-- CSS Includes -->
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.4.1/build/reset-fonts-grids/reset-fonts-grids.css" />
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.4.1/build/assets/skins/sam/skin.css" />
		<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url')?>resources/css/main.css" />

		<!-- Script Includes -->
		<!--script type="text/javascript" src="<?=$this->config->item('base_url')?>resources/js/json.js"></script-->
		<script type="text/javascript" src="<?=base_url()?>resources/js/prototype.js"></script>
		<script type="text/javascript" src="<?=base_url()?>resources/js/scriptaculous/scriptaculous.js"></script>
		<!-- YAHOO Includes -->
		<script type="text/javascript" src="http://yui.yahooapis.com/2.4.1/build/yahoo-dom-event/yahoo-dom-event.js"></script>
		<script type="text/javascript" src="http://yui.yahooapis.com/2.4.1/build/connection/connection-min.js"></script>
		<script type="text/javascript" src="http://yui.yahooapis.com/2.4.1/build/container/container-min.js"></script>
		<script type="text/javascript" src="http://yui.yahooapis.com/2.4.1/build/menu/menu-min.js"></script>
		
		<script type="text/javascript">
			transactions_open = Array();

			function toggle_transactions(category) {
				var 
					toggle = "tog_" + category;
				
				if (transactions_open[category]) {
					Effect.Fade(category, {duration:1}); 
					transactions_open[category] = false;
					$(toggle).update('<a href="javascript:void(0)" onclick="toggle_transactions(\'' + category + '\');"><img src="/resources/images/plus.png" alt="Expand Category" /></a>');
				} else {
					Effect.Appear(category, {duration:1}); 
					transactions_open[category] = true;
					$(toggle).update('<a href="javascript:void(0)" onclick="toggle_transactions(\'' + category + '\');"><img src="/resources/images/minus.png" alt="Collapse Category" /></a>');
				}
			}

			function delete_category(category_id, category_name) {
				var answer = confirm("Are you sure you want to delete the category named '" + category_name + "'?\n\nThis will delete all transactions/expenses within " + category_name + ".");
				if (answer) {
					var url = "<?=base_url()?>budget/deletecategory/" + category_id;
					new Ajax.Request(url, {
						method: 'get',
						onSuccess: function(transport) {
							load_categories();
						}
					});
				}
			}

			function load_categories() {
				$('categories').update('<div style="width: 100%; padding-top: 50px; padding-bottom: 50px; text-align: center"><img src="/resources/images/spinner.gif" alt="Loading..." /></div>');
				var url = "<?=base_url()?>budget/monthcategories/<?=$month_id?>";
				new Ajax.Request(url, {
					method: 'get',
					onSuccess: function(transport) {
						$('categories').update(transport.responseText);
					}
				});
				/*var request = YAHOO.util.Connect.asyncRequest('GET', url, {
					success: function(transport) {
						//alert(transport.responseText);
						//var temp = document.getElementById('category_summary_content');
						//temp.innerHTML = transport.responseText;
						//$('categories').update(transport.responseText);
					}
				});*/
			}
			Event.observe(window, 'load', load_categories);
		</script>
	</head>

	<body class="yui-skin-sam" style="text-align: left; margin-top: 10px;">
<?php
	//$this->load->view('base/header.php');

	$this->load->view('base/dialogs.php');
?>

		<div id="doc3" class="yui-t2"> 
			<div id="hd"><a href="<?=base_url()?>" style='color: #fff; font-size: 160%'>PHP Personal Budget</a></div> 
			<div id="bd"> 
				<div id="yui-main"> 
					<div class="yui-b">
						<div class="yui-g"> 
							<div id='month_content'>
								<!--h1><?=$month_data['month_pretty_name']?> <?=$month_data['month_year']?></h1><br /-->

								<div class='month_summary'>
									<div class='month_summary_header'><?=$month_data['month_pretty_name']?> <?=$month_data['month_year']?></div>
									<div class='month_summary_content'>
										<table width="100%">
											<tr style='cursor: default;' onmouseout="style.background='#FFF';" onmouseover="style.background='#DCDCFF';">
												<td width="200px" style='padding-left: 10px;'>Income:</td>
												<td  align="right" style='padding-right: 10px;'>$<?=number_format($month_data['actual_income'], 2)?></td>
											</tr>
											<tr style='cursor: default;' onmouseout="style.background='#FFF';" onmouseover="style.background='#DCDCFF';">
												<td style='padding-left: 10px;'>Total Spent:</td>
												<td align="right" style='padding-right: 10px;'>$<?=number_format($month_data['total_spent'], 2)?></td>
											</tr>
											<tr style='cursor: default;' onmouseout="style.background='#FFF';" onmouseover="style.background='#DCDCFF';">
												<td style='padding-right: 10px; padding-left: 10px;'>Amount Remaining:</td>
												<?php
												if ($month_data['amount_remaining'] > 0) {
													echo "<td style='color: green; text-align: right; padding-right: 10px;'>";
												} else if ($month_data['amount_remaining'] < 0) {
													echo "<td style='color: red; text-align: right; padding-right: 10px;'>";
												} else {
													echo "<td style='text-align: right; padding-right: 10px;'>";
												}
												?>
													$<?=number_format(abs($month_data['actual_income'] - $month_data['total_spent']), 2)?>
												</td>
											</tr>
										</table>
									</div>
								</div>
								
								<div class='category_summary'>
									<div class='category_summary_header'>Categories <img src="/resources/icons/add.png" onclick="enableAddCategoryDialog()" style="cursor: pointer" title="Add a New Category" alt="Add a New Category" /></div>
									
									<div id='categories' class='category_summary_content'>
										<div style="width: 100%; padding-top: 50px; padding-bottom: 50px; text-align: center">
											<img src="/resources/images/spinner.gif" alt="Loading..." />
										</div>
									</div>
								</div>
								<?php
									//$this->debug->dumpData($month_data['categories']);
								?>
								<!--div id='month_accordion'>
									<ul>
										<?php
											foreach($month_data['categories'] as $id => $category) {
												echo "<li>";
												echo "<table class='toggler_table' width='500'><tr><td width='100%'><div id='edit_" . $id . "' class='toggler'>" . $category['category_pretty_name'] . "</div></td><td width='50' style='padding-right: 10px'>\$" . number_format($category['budget_amount'], 2) . "</td></tr></table>";
												//echo "<div class='toggler'>" . $category['category_pretty_name'] . "</div>";
												
												echo "<ul class='togglee'>";
												if (isset($category['transactions'])) {
													echo "<li class='trans_li'>";
													$category_html = "";
													$category_html .= "<table>";
													$category_html .= "<tr>";
													if (count($category['transactions']) == 0) {
														$category_html .= "<td colspan=2>No Transactions</td>";
														$category_html .= "</tr>";
													} else {
														$category_html .= "<th class='desc_th trans_description'>Description</th>";
														$category_html .= "<th class='amt_th trans_amount'>Amount</th>";
														$category_html .= "</tr>";
														
														
														foreach($category['transactions'] as $transaction) {
															$category_html .= "<tr>";
															$category_html .= "<td class='trans_description'>";
															$category_html .= $transaction['description'];
															$category_html .= "</td>";
															$category_html .= "<td align='right' class='trans_amount'>";
															$category_html .= "\$" . number_format($transaction['amount'],2);
															$category_html .= "</td>";
															$category_html .= "</tr>";
														}
													}
													$category_html .= "</table>";
													echo $category_html;
													echo "</li>";
												} else {
													echo "<li>";
													echo "<table><tr><td>No Transactions for this Category</td></tr></table>";
													echo "</li>";
												}
												echo "</ul>";
												echo "</li>";
											}
										?>
									</ul>
								</div-->

							</div>
							<!-- YOUR DATA GOES HERE --> 
						</div> 
					</div> 
				</div> 
				<div class="yui-b">
					<?php $this->load->view('base/month_menu.php'); ?>
					
					<!-- YOUR NAVIGATION GOES HERE -->
				</div> 
			</div> 
			<div id="ft" style='border-top: 1px solid #999; color: #999; text-align: right;'>
				&copy; 2008, <a href="http://skaxo.com">Skaxo Interactive</a>
			</div>
		</div>

		<!--div id="myDialog">
			<div class="hd">Please enter information</div>
			<div class="bd">
			</div>
		</div-->
		<script type="text/javascript">
			/*function test(url) {
				alert(url);
				new Ajax.Request(url, {
					method: 'get',
					onSuccess: function(transport) {
						alert("TEST");
						//$('content_summary_content').update(transport.responseText);
					},
					onComplete: function(transport) {
						alert ("COMPLETE");
					},
					onFailure: function(transport) {
						alert ("FAIL");
					}
				});
			}*/

/*			function load_categories() {
				var url = "budget/month/<?=$month_id?>";
				var request = YAHOO.util.Connect.asyncRequest('GET', url, {
					success: function(transport) {
						//alert(transport.responseText);
						//var temp = document.getElementById('category_summary_content');
						//temp.innerHTML = transport.responseText;
						//$('categories').update(transport.responseText);
					}
				});
			}
			Event.observe(window, 'load', load_categories);*/
		</script>

	</body>
</html>



<!-- script type="text/javascript">
 	new Ajax.InPlaceEditor('budget_amount_4', '/demoajaxreturn.html');
</script -->


<?php
	//echo '<pre>' . print_r($month_data,1) . '</pre>';
?>
