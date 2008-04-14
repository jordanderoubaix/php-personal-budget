<table class='income'>
	<tr>
		<td align='right'>
			Projected Income:
		</td>
		<td style='padding-right: 25px;' class='green-money'>
			$<?php echo number_format($projected_income, 2); ?>
		</td>
		
		<td align='right'>
			Projected Remaining:
		</td>
		<td  style='padding-right: 25px;'>
			<?php 
				if ($projected_remaining < 0) {
					echo '<span class="debt">$' . number_format(abs($projected_remaining), 2) . '</span>';
				} else if ($projected_remaining > 0) {
					echo '<span class="non_debt">$' . number_format($projected_remaining, 2) . '</span>';
				} else {
					echo '<span class="break_event">$' . number_format($projected_remaining, 2) . '</span>';
				}
			?>
		</td>
		
		<td align='right'>
			Projected - Budgeted:
		</td>
		<td>
			<?php
				$budgeted_diff = $projected_income - $budgeted_amount;
				if ($budgeted_diff < 0) {
					print '<span class="debt">$' . number_format(abs($budgeted_diff), 2) . '</span>';
				} else if ($budgeted_diff > 0) {
					print '<span class="non_debt">$' . number_format($budgeted_diff, 2) . '</span>';
				} else {
					print '<span class="break_event">$' . number_format($budgeted_diff, 2) . '</span>';
				}
			?>
		</td>
	</tr>
	
	<tr>
		<td align='right'>
			Actual Income:
		</td>
		<td class='green-money'>
			$<?php echo number_format($actual_income, 2); ?>
		</td>
		
		<td align='right'>
			Actual Remaining:
		</td>
		<td id='actual_remaining'>
			<?php 
				if ($actual_remaining < 0) {
					echo '<span class="debt">$' . number_format(abs($actual_remaining), 2) . '</span>';
				} else if ($actual_remaining > 0) {
					echo '<span class="non_debt">$' . number_format($actual_remaining, 2) . '</span>';
				} else {
					echo '<span class="break_event">$' . number_format($actual_remaining, 2) . '</span>';
				}
			?>
		</td>
		
		<td align='right'>
			Actual - Budgeted:
		</td>
		<td>
			<?php
				$actual_budgeted_diff = $actual_income - $budgeted_amount;
				if ($actual_budgeted_diff < 0) {
					print '<span class="debt">$' . number_format(abs($actual_budgeted_diff), 2) . '</span>';
				} else if ($actual_budgeted_diff > 0) {
					print '<span class="non_debt">$' . number_format($actual_budgeted_diff, 2) . '</span>';
				} else {
					print '<span class="break_event">$' . number_format($actual_budgeted_diff, 2) . '</span>';
				}
			?>
		</td>
	</tr>
	
	<tr>
		<td align='right'>
			Total Spent:
		</td>
		<td class='red-money'>
			$<?php echo number_format($total_spent, 2); ?>
		</td>
		
		<td align='right'>
			Total Budgeted:
		</td>
		<td>
			<?php
				print '<span class="non_debt">$' . number_format($budgeted_amount, 2) . '</span>';
			?>
		</td>
	</tr>
</table>
