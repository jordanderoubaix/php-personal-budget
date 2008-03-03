<?php

class BudgetModel extends Model {

	function BudgetModel() {
		parent::Model();
	}
	
	function get_budget_data($num_months = 12) {
		$this->load->database();
		
		
		$query = $this->db->query('SELECT * FROM Months ORDER BY month_id LIMIT ' . $num_months);
		
		// Grab all the information for the last 12 months.
		$results = array();
		foreach($query->result() as $row){
			$results[$row->month_id] = array('month_id' => $row->month_id, 'month_pretty_name' => $row->pretty_name, 'year' => $row->year);
			
			// We now need the categories that will go into each month and each 
			// will contain a budgeted index and a spent index where the proper
			// information will be placed.
			$categories = $this->get_categories($row->month_id);
			foreach($categories as $category) {
                $results[$row->month_id]['categories'][$category['category_id']]['category_pretty_name'] = $category['pretty_name'];
			}
			//$results[$row->month_id]['categories'] = $categories;
			
			// We now have the month information. Now we need that budget information for that month.
			// We need the actual data for the budgeted amounts as well as the actual spent amount.
			$budget_items = $this->get_month_budget_items($row->month_id);
			//$results[$row->month_id]['budget'] = array();
			foreach($budget_items as $budget_item) {
				$results[$row->month_id]['categories'][$budget_item['category_id']]['budget_amount'] = $budget_item['budget_amount'];
			}
			
			$transaction_items = $this->get_month_transaction_items($row->month_id);
			//echo "<pre>" . print_r($transaction_items, 1) . "</pre>";
			foreach($transaction_items as $item) {
				$results[$row->month_id]['categories'][$item['category_id']]['transactions'][$item['transaction_id']]['amount'] = $item['transaction_amount'];
				$results[$row->month_id]['categories'][$item['category_id']]['transactions'][$item['transaction_id']]['description'] = $item['description'];
			}
			
			// Get the total amount spent for each category in a given month.
			if (isset($results[$row->month_id]['categories'])) {
				foreach($results[$row->month_id]['categories'] as $category_id=>$category) {
					$results[$row->month_id]['categories'][$category_id]['total_spent'] = 0;
					if(isset($category['transactions']) && is_array($category['transactions'])) {
						foreach($category['transactions'] as $transaction) {
							$results[$row->month_id]['categories'][$category_id]['total_spent'] += $transaction['amount'];
						}
					}
				}
			}
			
		}
		
		// Grab the data for each month
		/*$curr_pos = 0;
		foreach($results as $month) {
			//echo "<pre>" . print_r($month, 1) . "</pre>";
			
			$query = $this->db->query('SELECT * FROM Transactions WHERE month_id = ' . $month['month_id'] . ' ORDER BY month_id LIMIT 12');
			
			$results[$curr_pos]['data'] = array();
			foreach($query->result() as $row) {
				$results[$curr_pos]['data'][] = array('amount' => $row->amount, 'description' => $row->description, 'category_id' => $row->category_id);
			}

			
			$curr_pos++;
		}*/
		
		//echo "<pre>" . print_r($results, 1) . "</pre>";
		return $results;
	}
	
	function get_month_data($month_id) {
		$this->load->database();
		
		$categories = $this->get_categories($month_id);
		//echo '<pre>' . print_r($categories,1) . '</pre>';
		$budget_items = $this->get_month_budget_items($month_id);
		$transaction_items = $this->get_month_transaction_items($month_id);
		$actual_income = $this->get_actual_income($month_id);
		$total_spent = $this->get_month_total_spent($month_id);
		
		$data_array = $this->build_data_array($month_id, $categories, $budget_items, $transaction_items, $actual_income, $total_spent);
		//$data_json = $this->build_json_data($month_id, $data_array);
		return $data_array;
		//$results = '{"Restults":[';
	}
	
	function build_json_data($month_id, $data_array) {
		$results = '{"Results":[';
		
		foreach ($data_array['categories'] as $cat_id=>$cat_array) {
			//echo "<pre>" . print_r($cat_array, 1) . "</pre>";
			$results .= '{';
			$results .= '"Category":"' . $cat_array['category_pretty_name'] . '",';
			$results .= '"Budgeted' . $month_id . '":"' . $cat_array['budget_amount'] . '",';
			$results .= '"Spent":"' . $cat_array['total_spent'] . '",';
			$results .= '"Remaining":"' . ($cat_array['budget_amount'] - $cat_array['total_spent']) . '"';
			$results .= '},';
		}
		
		$results = substr($results, 0, -1);
		
		$results .= ']}';
		
		return $results;
	}
	
	function build_data_array($month_id, $categories, $budget_items, $transaction_items, $actual_income, $total_spent) {
		$results = array();
		
		$this->load->database();
		
		$result = $this->db->query('SELECT * FROM Months WHERE month_id='.$month_id);
		$result = $result->result();
		$result = $result[0];
		
		$results['month_pretty_name'] = $result->pretty_name;
		$results['month_year'] = $result->year;
		$results['actual_income'] = $actual_income;
		$results['total_spent'] = $total_spent;
		$results['amount_remaining'] = $actual_income - $total_spent;

		foreach($categories as $category) {
			$results['categories'][$category['category_id']]['category_pretty_name'] = $category['pretty_name'];
		}
		
		foreach($budget_items as $budget_item) {
			if(isset($results['categories'][$budget_item['category_id']])) {
				$results['categories'][$budget_item['category_id']]['budget_amount'] = $budget_item['budget_amount'];
			}
		}
		
		foreach($transaction_items as $item) {
			if(isset($results['categories'][$item['category_id']])) {
				$results['categories'][$item['category_id']]['transactions'][$item['transaction_id']]['amount'] = $item['transaction_amount'];
				$results['categories'][$item['category_id']]['transactions'][$item['transaction_id']]['description'] = $item['description'];
			}
		}
		
		// Get the total amount spent for each category in a given month.
		if (isset($results['categories'])) {
			foreach($results['categories'] as $category_id=>$category) {
				$results['categories'][$category_id]['total_spent'] = 0;
				if(isset($category['transactions']) && is_array($category['transactions'])) {
					foreach($category['transactions'] as $transaction) {
						$results['categories'][$category_id]['total_spent'] += $transaction['amount'];
					}
				}
			}
		}
		
		return $results;
	}
	
	function get_categories($month_id) {
		$this->load->database();
		
		$query = $this->db->query('SELECT * FROM Categories WHERE month_id='.$month_id.' ORDER BY pretty_name');
		
		$results = array();
		foreach($query->result() as $row) {
			$results[] = array('category_id' => $row->category_id, 'pretty_name' => $row->pretty_name);
		}
		
		return $results;
	}
	
	function get_month_budget_items($month_id) {
		$this->load->database();
        $budget_query = ($this->db->query('SELECT * FROM BudgetEntries WHERE month_id = ' . $month_id));
        
        $results = array();
        
        foreach($budget_query->result() as $budget_row) {
            $results[] = array('category_id' => $budget_row->category_id, 'budget_amount' => $budget_row->budget_amount, 'budget_entry_id' => $budget_row->budget_entry_id);
        }
        
        return $results;
	}
	
	function get_month_transaction_items($month_id) {
		$transaction_query = ($this->db->query('SELECT * FROM Transactions WHERE month_id = ' . $month_id));
		
		$trans_results = array();
		
		foreach($transaction_query->result() as $transaction_row) {
			$trans_results[] = array('category_id' => $transaction_row->category_id, 'transaction_id' => $transaction_row->transaction_id, 'month_id' => $transaction_row->month_id, 'transaction_amount' => $transaction_row->amount, 'description' => $transaction_row->description);
		}
		return $trans_results;
	}
	
	function get_projected_income($month_id) {
		$this->load->database();
		$projected_income_query = ($this->db->query('SELECT projected_income FROM Months WHERE month_id = ' . $month_id));
		
		$result = $projected_income_query->result();
		return $result[0]->projected_income;
	}
	
	function get_month_budgeted_amount($month_id) {
		$this->load->database();
		$budget_amount_query = ($this->db->query('SELECT SUM(budget_amount) AS budget_amount FROM BudgetEntries WHERE month_id = ' . $month_id));
		
		$result = $budget_amount_query->result();
		return $result[0]->budget_amount;
	}
	
	function get_actual_income($month_id) {
		$this->load->database();
		$actual_income_query = ($this->db->query('SELECT SUM(income_amount) AS income_amount FROM Income WHERE month_id=' . $month_id));
		
		$result = $actual_income_query->result();
		return $result[0]->income_amount;
	}
	
	function update_budget_item($month_id, $category, $value) {
		$this->load->database();
		
		$this->db->where('pretty_name', $category);
		$this->db->select('category_id');
		$query = $this->db->get('Categories')->result();
		
		$category_id = $query[0]->category_id;
		
		$this->db->where('category_id', $category_id);
		$this->db->where('month_id', $month_id);
		$existing_entry = $this->db->get('BudgetEntries')->result();
		
		if (count($existing_entry) > 0) {
		
			$this->db->where('month_id', $month_id);
			$this->db->where('category_id', $category_id);
			$update_data = array(
							'budget_amount' => $value
						   );
			$update_happened = $this->db->update('BudgetEntries', $update_data);
		} else {
			$insert_data = array(
							'month_id' => $month_id,
							'category_id' => $category_id,
							'budget_amount' => $value
						   );
						   
			$update_happened = $this->db->insert('BudgetEntries', $insert_data);
		}
		
		$this->db->where('month_id', $month_id);
		$this->db->select('pretty_name, year');

		$month_info = $this->db->get('Months')->result_array();
		$month_info = $month_info[0];
		//echo "<pre>" . print_r($this->db, 1) . "</pre>";
		
		if ($update_happened) {
			return "<span class='success-message'><a href='javascript:void(0)' style='cursor: hand;'><img src='<?=$this->config->item('base_url')?>resources/images/green_close.GIF' onclick='hideMessage()' /></a> The budgeted amount for " . $month_info['pretty_name'] . " " . $month_info['year'] . " to $" . $value . " was successful for the " . $category . " category. (<a href=''>Refresh Data</a>)";
		} else {
			return "<span class='error-message'>The budgeted amount for " . $month_info['pretty_name'] . " " . $month_info['year'] . " to $" . $value . " was unsuccessful for the " . $category . " category.";
		}
		
	}
	
	function get_month_total_spent($month_id) {
		$this->load->database();
		
		$this->db->where('month_id', $month_id);
		$this->db->select('SUM(amount) AS sum_amount');
		$trans_sum = $this->db->get('Transactions')->result();
		//$trans_sum = $trans_sum[0]->sum_amount;
		//echo '<pre>' . print_r($trans_sum, 1) . '</pre>';
		if (!isset($trans_sum[0]->sum_amount)) {
			$trans_sum = 0;
		} else {
			$trans_sum = $trans_sum[0]->sum_amount;
		}
		return $trans_sum;
	}
	
	function get_month_projected_remaining($month_id) {
		$proj_income = $this->get_projected_income($month_id);
		$spent = $this->get_month_total_spent($month_id);
		//$proj_income . " - " . $spent;
		
		$proj_remain = $proj_income - $spent;
		return $proj_remain;
	}
	
	function get_month_actual_remaining($month_id) {
		$actual_income = $this->get_actual_income($month_id);
		$spent = $this->get_month_total_spent($month_id);
		
		$actual_remain = $actual_income - $spent;
		return $actual_remain;
	}
	
	function get_available_months() {
		$this->load->database();
		$this->db->select('month_id, pretty_name, year');
		$this->db->orderby('month_id', 'desc');
		$months = $this->db->get('Months')->result();
		
		//echo '<pre>' . print_r($months, 1) . '</pre>';
		return $months;
	}
	
	function submit_expense($month_id) {
		$this->load->database();
		
		$data = array(
					'month_id' => $month_id, //$_POST['month_id'],
					'category_id' => $_POST['category_id'],
					'amount' => $_POST['expense_amount'],
					'description' => $_POST['expense_desc'],
					'date_entered' => date('Y-m-d')
					);
		$this->db->insert('Transactions', $data);
	}
	
	function create_category($month_id, $category_name) {
		$this->load->database();
		
		$check_result = $this->db->get_where('Categories', array('month_id' => $month_id, 'pretty_name' => $category_name));
		$check_result = $check_result->result();
		
		if (count($check_result) != 0) {
			echo "{ code: " . DUPLICATE_CATEGORY . ", errMessage: 'You have entered a duplicate category' }";
			return;
		} 
		
		$data = array('pretty_name' => $_POST['newcategory'],'month_id' => $month_id);
		$this->db->insert('Categories', $data);

		// Need to get the new Category id created for the above category.
		$this->db->select('category_id');
		$query = $this->db->getwhere('Categories', array('pretty_name' => $_POST['newcategory'], 'month_id' => $month_id));

		$query_result = $query->result();
		$query_result = $query_result[0];
		
		$data = array('budget_amount' => $_POST['newcatbudget'], 'month_id' => $month_id, 'category_id' => $query_result->category_id);
		$this->db->insert('BudgetEntries', $data);
		
		echo "{ code: " . ADDED_CATEGORY . " }";
		
	}

	function delete_category($month_id, $category_id) {
		$this->load->database();

		$unassigned_cat = $this->db->get_where('Categories', array('pretty_name' => 'Unassigned', 'month_id' => $month_id));
		$unassigned_cat_result = $unassigned_cat->result();

		if ($unassigned_cat_result[0]->category_id != $category_id) {

			if (count($unassigned_cat_result) == 0) {
				$this->db->insert('Categories', array('month_id' => $month_id, 'pretty_name' => 'Unassigned'));
			}
	
			$get_unassigned = $this->db->get_where('Categories', array('pretty_name' => 'Unassigned', 'month_id' => $month_id));
			$get_unassigned_result = $get_unassigned->result();
	
			echo "<pre>" . print_r($get_unassigned_result, 1) . "</pre>";
	
			$unassigned_id = $get_unassigned_result[0]->category_id;
	
			$existing_trans = $this->db->get_where('Transactions', array('category_id' => $category_id, 'month_id' => $month_id));
			$existing_trans_result = $existing_trans->result();
	
			foreach($existing_trans_result as $result) {
				$trans_data = array(
					'month_id'		=> $month_id,
					'category_id'	=> $unassigned_id,
					'amount'		=> $result->amount,
					'description'	=> $result->description,
					'date_entered'	=> $result->date_entered
				);
				
				$this->db->insert('Transactions', $trans_data);
			}
		}
		
		$data = array('category_id' => $category_id);
		$this->db->delete('Categories', $data);
		$this->db->delete('Transactions', $data);
		$this->db->delete('BudgetEntries', $data);
	}

	function rename_categories() {
		$category_array = array();
		foreach ($_POST as $cat_id => $cat_name) {
			$this->db->where('category_id', $cat_id);
			$this->db->update('Categories', array('pretty_name' => $cat_name));
		}
	}

	function rename_category($month_id) {
		$this->db->where('category_id', $_POST['category_id']);
		$this->db->update('Categories', array('pretty_name' => $_POST['new_name']));
	}

	function update_category_budget($month_id) {
		$this->db->where('category_id', $_POST['category_id']);
		$this->db->where('month_id', $month_id);
		$this->db->update('BudgetEntries', array('budget_amount' => $_POST['new_budget']));
	}
	
	function add_income() {
		$this->load->database();
		
		$data = array(
					'month_id' => $_POST['month_id'],
					'income_amount' => $_POST['income_amount']
					);
		$this->db->insert('Income', $data);
	}
	
	function get_available_months_json() {
		$result = $this->get_available_months();
		print json_encode($result);
	}

	function get_month_pretty_name($month_id) {
		$this->db->where('month_id', $month_id);
		$query = $this->db->getwhere('Months', array('month_id' => $month_id));
		print "<pre>" . print_r($query, 1) . "</pre>";
	}

	function add_this_month() {
		$month_id = date('Ym');
		$month_pretty_name = date('F');
		$month_short_name = date('M');
		$year = date('Y');

		$check_result = $this->db->get_where('Months', array('month_id' =>  $month_id));
		$check_result = $check_result->result();

		if (count($check_result) == 0) {
			$data = array(
				'month_id' => $month_id,
				'pretty_name' => $month_pretty_name,
				'short_name' => $month_short_name,
				'year' => $year,
				'projected_income' => 0
			);

			$this->db->insert('Months', $data);

			// Code 200 says the month was created successfully.
			echo "{ code : " . MONTH_CREATED . " }";
		} else {
			echo "{ code : " . MONTH_EXISTS . " }";
		}
	}
}

?>
