<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

		<title>PHP Budget</title>
		<!-- CSS Includes -->
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.4.1/build/reset-fonts-grids/reset-fonts-grids.css" />
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.4.1/build/assets/skins/sam/skin.css" />
		<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url')?>/resources/css/main.css" />

		<!-- Script Includes -->
		<!--script type="text/javascript" src="<?=$this->config->item('base_url')?>/resources/js/json.js"></script-->
		<script type="text/javascript" src="<?=base_url()?>/resources/js/prototype.js"></script>
		<script type="text/javascript" src="<?=base_url()?>/resources/js/scriptaculous/scriptaculous.js"></script>
		<!-- YAHOO Includes -->
		<script type="text/javascript" src="<?=yui_url()?>/build/yahoo-dom-event/yahoo-dom-event.js"></script>
		<script type="text/javascript" src="<?=yui_url()?>/build/connection/connection-min.js"></script>
		<script type="text/javascript" src="<?=yui_url()?>/build/container/container-min.js"></script>
		<script type="text/javascript" src="<?=yui_url()?>/build/menu/menu-min.js"></script>
		
		<script type="text/javascript">
			transactions_open = Array();

			function toggle_transactions(category) {
				var 
					toggle = "tog_" + category;
				
				if (transactions_open[category]) {
					Effect.Fade(category, {duration:1}); 
					//$(category).hide();
					transactions_open[category] = false;
					$(toggle).update('<a href="javascript:void(0)" onclick="toggle_transactions(\'' + category + '\');"><img src="/resources/images/plus.png" alt="Expand Category" /></a>');
				} else {
					Effect.Appear(category, {duration:1}); 
					//$(category).show();
					transactions_open[category] = true;
					$(toggle).update('<a href="javascript:void(0)" onclick="toggle_transactions(\'' + category + '\');"><img src="/resources/images/minus.png" alt="Collapse Category" /></a>');
				}
			}

			function delete_category(category_id, category_name) {
				var answer; 
				if (category_name == "Unassigned") {
					answer = confirm("Are you sure you want to delete the Unassigned category?\n\nAll transactions will be deleted.");
				} else {
					answer = confirm("Are you sure you want to delete the category named '" + category_name + "'?\n\nAll transactions will be moved to an Unassigned category.");
				}
				if (answer) {
					var url = "<?=base_url()?>budget/deletecategory/<?=$month_id?>/" + category_id;
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
			}

			function load_summary() {
				$('month_summary_content').update('<div style="width: 100%; padding-top: 15px; padding-bottom: 15px; text-align: center"><img src="/resources/images/spinner.gif" alt="Loading..." /></div>');
				var summary_url = "<?=base_url()?>budget/loadsummary/<?=$month_id?>";
				new Ajax.Request(summary_url, {
					method: 'get',
					onSuccess: function(transport) {
						$('month_summary_content').update(transport.responseText);
					},
					onFailure: function(transport) {
						alert ("Failure");
					}
				});
			}

			function load_info() {
				load_summary();
				load_categories();
			}

			Event.observe(window, 'load', load_info);
		</script>
		
		<? $this->load->view('base/dialogs_js.php'); ?>
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

								<div id='month_summary' class='month_summary'>
									<div class='month_summary_header'><?=$month_data['month_pretty_name']?> <?=$month_data['month_year']?></div>
									<div id='month_summary_content' class='month_summary_content'>
										<div style="width: 100%; padding-top: 15px; padding-bottom: 15px; text-align: center">
											<img src="/resources/images/spinner.gif" alt="Loading..." />
										</div>
									</div>
								</div>
								
								<div class='category_summary'>
									<!-- div class='category_summary_header'>Categories <img src="/resources/icons/add.png" onclick="enableAddCategoryDialog()" style="cursor: pointer" title="Add a New Category" alt="Add a New Category" /></div -->
									
									<div id='categories' class='category_summary_content'>
										<div style="width: 100%; padding-top: 50px; padding-bottom: 50px; text-align: center">
											<img src="/resources/images/spinner.gif" alt="Loading..." />
										</div>
									</div>
								</div>
								<?php
									//$this->debug->dumpData($month_data['categories']);
								?>
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
