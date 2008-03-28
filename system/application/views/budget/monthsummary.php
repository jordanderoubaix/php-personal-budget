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
												?>
													<td style='color: green; text-align: right; padding-right: 10px;'>
												<?php
												} else if ($month_data['amount_remaining'] < 0) {
												?>
													<td style='color: red; text-align: right; padding-right: 10px;'>
												<?php
												} else {
												?>
													<td style='text-align: right; padding-right: 10px;'>
												<?php
												}
												?>
													$<?=number_format(abs($month_data['actual_income'] - $month_data['total_spent']), 2)?>
												</td>
											</tr>
										</table>
