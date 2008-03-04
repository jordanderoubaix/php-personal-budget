<?php

class Budget extends Controller {
	
	function index()
	{
		$this->overview();
	}
	
	/**
	 *
	 */
	function overview() {
		$this->load->model('BudgetModel', 'budget');
		
		$data['budget_data'] = $this->budget->get_budget_data(12);
		
		//$data['results'] = $this->budget->get_recent_months_data();
		//$data['categories'] = $this->budget->get_categories();
		$data['directory'] = "budgettest";
		$data['available_months'] = $this->budget->get_available_months();
		$this->load->view('budget/overview', $data);
		
		//print '<pre>' . print_r($data['categories'], 1) . '</pre>';
		//$this->output->enable_profiler(TRUE);
	}
	
	/**
	 *
	 */
	function month($month_id) {
		$this->load->model('BudgetModel', 'budget');
		
		$data['month_data'] = $this->budget->get_month_data($month_id);
		$data['available_months'] = $this->budget->get_available_months();
		$data['categories'] = $this->budget->get_categories($month_id);
		$data['month_id'] = $month_id;
		//$data['month_info'] = $this->budget->get_month_info($month_id);
		$this->load->view('budget/month', $data);
	}

	function monthcategories($month_id) {
		//$this->debug->dumpData($month_id);
		$this->load->model('BudgetModel', 'budget');

		$data['month_data'] = $this->budget->get_month_data($month_id);
		$data['categories'] = $this->budget->get_categories($month_id);

		$this->load->view('budget/monthcategories', $data);
	}
	
	/**
	 *
	 */
	function monthprojectedincome($month_id) {
		$this->load->model('BudgetModel', 'budget');
		
		$data['projected_income'] = $this->budget->get_projected_income($month_id);
		
		$this->load->view('budget/monthprojectedincome', $data);
	}
	
	/**
	 *
	 */
	function monthactualincome($month_id) {
		$this->load->model('BudgetModel', 'budget');
		
		$data['actual_income'] = $this->budget->get_actual_income($month_id);
		
		$this->load->view('budget/monthactualincome', $data);
	}
	
	/**
	 *
	 */
	function getmonthamounts($month_id) {
		$this->load->model('BudgetModel', 'budget');
		
		$data['projected_income'] = $this->budget->get_projected_income($month_id);
		$data['actual_income'] = $this->budget->get_actual_income($month_id);
		$data['total_spent'] = $this->budget->get_month_total_spent($month_id);
		$data['projected_remaining'] = $this->budget->get_month_projected_remaining($month_id);
		$data['actual_remaining'] = $this->budget->get_month_actual_remaining($month_id);
		$data['budgeted_amount'] = $this->budget->get_month_budgeted_amount($month_id);
		
		$this->load->view('budget/monthamounts', $data);
	}
	
	/**
	 *
	 */
	function monthtotalbudget($month_id) {
		$this->load->model('BudgetModel', 'budget');
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $month_id
	 * @param unknown_type $category
	 * @param unknown_type $value
	 */
	function updatebudgetitem($month_id, $category, $value) {
		$this->load->model('BudgetModel', 'budget');
		
		$data['update_message'] = $this->budget->update_budget_item($month_id, urldecode($category), $value);
		
		$this->load->view('budget/updatebudgetitem', $data);
	}

	function updatecategorybudget($month_id) {
		$this->load->model('BudgetModel', 'budget');

		$this->budget->update_category_budget($month_id);
	}
	
	function submitexpense($category_id) {
		$this->load->model('BudgetModel', 'budget');
		
		$this->budget->submit_expense();
	}
	
	function addcategory($month_id, $category_name) {
		$this->load->model('BudgetModel', 'budget');
		
		$this->budget->create_category($month_id, $category_name);
	}

	function addexpense($month_id) {
		$this->load->model('BudgetModel', 'budget');

		$this->budget->submit_expense($month_id);
	}

	function deletecategory($month_id, $category_id) {
		$this->load->model('BudgetModel', 'budget');

		$this->budget->delete_category($month_id, $category_id);
	}

	function renamecategories() {
		$this->load->model('BudgetModel', 'budget');

		$this->budget->rename_categories();
	}

	function renamecategory($month_id) {
		$this->load->model('BudgetModel', 'budget');

		$this->budget->rename_category($month_id, $category_id);
	}
	
	function monthaddincome() {
		$this->load->model('BudgetModel', 'budget');
		
		$this->budget->add_income();
	}
	
	function getavailablemonths() {
		$this->load->model('BudgetModel', 'budget');
		
		print $this->budget->get_available_months_json();
	}

	function addthismonth() {
		$this->load->model('BudgetModel', 'budget');

		$this->budget->add_this_month();
	}

	function loadsummary($month_id) {
		$this->load->model('BudgetModel', 'budget');
		
		$data['month_data'] = $this->budget->get_month_data($month_id);
		$data['available_months'] = $this->budget->get_available_months();
		$data['categories'] = $this->budget->get_categories($month_id);
		$data['month_id'] = $month_id;
		//$data['month_info'] = $this->budget->get_month_info($month_id);
		$this->load->view('budget/monthsummary', $data);
	}

}

?>
