<table width="100%">
	<tr class='category_summary_header'>
		<td colspan="7" style="padding-left: 10px">
			Categories <img src="/resources/icons/add.png" onclick="enableAddCategoryDialog()" style="cursor: pointer" title="Add a New Category" alt="Add a New Category" />
		</td>
		<td style="text-align: right; padding-right: 10px;">
			Remaining
		</td>
		<td style="text-align: right;">
			Budgeted
		</td>
		<td></td>
	</tr>
<?php
	$first = TRUE;
	$budget_total = 0;
	//$trans_total = 0;
	if (isset($month_data['categories'])) {
		foreach ($month_data['categories'] as $id => $category) {
			if (isset($category['budget_amount'])) {
				$budget_total += $category['budget_amount'];
			}
			if ($first) {
?>
    
			<tr class='category_item first_category_item'>
<?php
			$first = FALSE;
        } else {
?>
            <tr class='category_item'>
<?php } ?>

				<td width="25px"><img src="/resources/icons/cross.png" style="cursor: pointer" onclick="delete_category(<?=$id?>, '<?=addslashes($category["category_pretty_name"])?>');" title="Delete <?=$category["category_pretty_name"]?>" /></td>
<?php		
			if ($category["category_pretty_name"] == "Unassigned") {
?>
				<td width="25px"><img src="/resources/icons/folder_edit_disabled.png" /></td>
<?php
			} else {
				$trans_total = 0;
				if (isset($category['transactions'])) {
					foreach($category['transactions'] as $trans) {
						$trans_total += $trans['amount'];
					}
				}
?>
				<td width="25px"><img src="/resources/icons/folder_edit.png" style="cursor: pointer" onclick="enableRenameCategoryDialog(<?=$id?>, '<?=addslashes($category["category_pretty_name"])?>');" title="Rename <?=addslashes($category["category_pretty_name"])?>" /></td>
<?php } ?>
				<td><div style="width: 1px; height: 12px; background: #999"></div></td>
                <td width="25px"><img src="/resources/icons/money.png" style="cursor: pointer" onclick="enableAddExpenseDialog('<?=addslashes($category["category_pretty_name"])?>', <?=$id?>)" title="Add an Expense to <?=$category["category_pretty_name"]?>" /></td>
				<td><div style="width: 1px; height: 12px; background: #999"></div></td>
				<td id="tog_trans_<?=$id?>"><a href="javascript:void(0)" onclick="toggle_transactions('trans_<?=$id?>');"><img src="/resources/images/plus.png" /></a></td>
				<td width="100%"><a href="javascript:void(0)" onclick="toggle_transactions('trans_<?=$id?>');"><?=$category['category_pretty_name']?></a></td>
                <td width="300px" style='text-align: right'>
                	<p id="cat_<?=$id?>" style="text-align: right; padding-right: 10px;">
                		<?php
							if (isset($category['budget_amount'])) {
								if (($category['budget_amount'] - $trans_total) < 0) {
						?>
									<span style='color: red'>$<?=number_format($category['budget_amount'] - $trans_total, 2)?></span>
						<?php
								} else if (($category['budget_amount'] - $trans_total) > 0){
						?>
									<span style='color: green'>$<?=number_format($category['budget_amount'] - $trans_total, 2)?></span>
						<?php
								} else {
									echo "$" . number_format($category['budget_amount'] - $trans_total, 2);
								}
							}
                		?>
						
                	</p>
                </td>
                <td width="300px" style='text-align: right'>
                	<p id="cat_<?=$id?>" style="text-align: right;">
                		<?php
							if (isset($category['budget_amount'])) {
						?>
						<span style="color: green; font-weight: bold">$<?=number_format($category['budget_amount'], 2) ?></span>
						<?php
							}
                		?>
						
                	</p>
                </td>
				<td width="25px" style="padding-right: 5px;"><img src="/resources/icons/table_edit.png" onclick="enableUpdateCategoryBudgetDialog(<?=$id?>, '<?=addslashes($category["category_pretty_name"])?>');" style="cursor: pointer" title="Change budget for <?=$category["category_pretty_name"]?>" /></td>
			</tr>
			<tr>
				<td colspan="10"><div class="cat_sep" width="100%"></div></td>
			</tr>
			<tr id='trans_<?=$id?>' style="display: none; padding-bottom: 10px;">
				<td colspan="1"></td>
				<td colspan="9" style="padding: 5px 0 10px 0px;">
				<div id='div_trans_<?=$id?>' <?php if (!isset($category['transactions'])) { echo 'class=\"transactions\"';}?>class='transactions' style="padding-top: 5px; padding-left: 10px; padding-bottom: 5px; border-left: 1px solid #3366cc; border-bottom: 1px solid #3366cc">
					<?php
						if (isset($category['transactions'])) {
							//$this->debug->dumpData($category['transactions']);
					?>

						<table>
						<?php
							$first_trans = TRUE;
							$trans_total = 0;
							foreach($category['transactions'] as $trans) {
								$trans_total += $trans['amount'];
								if ($first_trans) {
						?>
									<tr class="row_sep">
										<td colspan="2"></td>
									</tr>
						<?php
									$first_trans = FALSE;
								}
						?>
								<tr class="trans_item" onmouseover="style.background='#c9d7f1';" onmouseout="style.background='transparent';">
									<td width="100%" class="trans_description"><?=$trans['description']?></td>
									<td style="padding-right: 10px; text-align: right;">$<?=number_format($trans['amount'], 2)?></td>
								</tr>
								<tr>
									<td colspan="2"><div class="row_sep" width="100%"></div></td>
								</tr>
						<?php
							}
						?>
							<tr class="trans_item">
								<td style="font-weight: bold">Total Spent</td>
								<td style="padding-right: 10px; text-align: right; font-weight: bold;">$<?=number_format($trans_total, 2)?></td>
							</tr>
						</table>
					<?php
						} else {
					?>
						No transactions have been added for this category.
					<?php
						}
					?>
					</div>
				</td>
			</tr>

			<script>
			</script>
<?php
		}
    }
?>
	<tr class="category_item budget_total">
		<td colspan="8" style="font-weight: bold; padding-bottom: 0px; padding-top: 0px;">Budget Total</td>
		<td style="text-align: right; font-weight: bold; padding-bottom: 0px; padding-top: 0px;">$<?=number_format($budget_total, 2)?></td>
		<td></td>
	</tr>

</table>
