<?php
class InstallModel extends Model {

	function InstallModel() {
		parent::Model();
	}
	
	function create_database_tables() {
		//$this->load->dbutil();
		//$this->load->dbforge();
		$month_pretty_name = date("F");
		$month_short_name = date("M");
		$month_year = date("Y");
		$month_number = date("m");
		$month_projected_income = 0;
		
		$check_sql = "SHOW TABLES";
		$query = $this->db->query($check_sql);
		
		$tables = array('BudgetEntries', 'Categories', 'Income', 'Months', 'Transactions');
		$given_tables = array();
		
		foreach($query->result() as $row) {
			$given_tables[] = $row->Tables_in_tester;
		}
		
		
		$int_array = array_diff($tables, $given_tables);
		
		if (count($int_array) == 0) {
			$check_month_sql = "SELECT * FROM Months WHERE month_id = " . $month_year . $month_number;
			$query = $this->db->query($check_month_sql);
			
			if (count($query->result()) == 0) {
				$month_sql = "INSERT INTO Months (month_id, pretty_name, short_name, year, projected_income) 
						VALUES ('" . $month_year . $month_number . "', '" . $month_pretty_name . "', '" . $month_short_name . "', '" . $month_year . "', " . $month_projected_income . ") ";
				$this->db->query($month_sql);
				
				echo "Already Installed. Added " . $month_pretty_name . " " . $month_year . " to the database. Go to the <a href='" . base_url() . "'>PHP Personal Budget Homepage</a>";
			} else {
				echo "Already Installed.  Go to the <a href='" . base_url() . "'>PHP Personal Budget Homepage</a>";
			}
		} else {
		
			$budget_entries_sql = "CREATE TABLE IF NOT EXISTS `BudgetEntries` (
							  `budget_entry_id` int(11) NOT NULL auto_increment,
							  `month_id` bigint(20) NOT NULL,
							  `category_id` int(11) NOT NULL,
							  `budget_amount` double NOT NULL,
							  PRIMARY KEY  (`budget_entry_id`),
							  UNIQUE KEY `month_id` (`month_id`,`category_id`)
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
			
			$categories_sql = "CREATE TABLE IF NOT EXISTS `Categories` (
							  `category_id` bigint(20) NOT NULL auto_increment,
							  `pretty_name` varchar(256) NOT NULL,
							  `month_id` bigint(20) NOT NULL,
							  PRIMARY KEY  (`category_id`)
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
			
			$income_sql = "CREATE TABLE IF NOT EXISTS `Income` (
							  `income_id` bigint(20) NOT NULL auto_increment,
							  `month_id` bigint(20) NOT NULL,
							  `income_amount` decimal(10,2) NOT NULL,
							  PRIMARY KEY  (`income_id`)
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
			
			$months_sql = "CREATE TABLE IF NOT EXISTS `Months` (
							  `month_id` bigint(20) NOT NULL,
							  `pretty_name` varchar(30) NOT NULL,
							  `short_name` varchar(3) NOT NULL,
							  `year` int(4) NOT NULL,
							  `projected_income` float unsigned NOT NULL,
							  PRIMARY KEY  (`month_id`)
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;";
			
			$transactions_sql = "CREATE TABLE IF NOT EXISTS `Transactions` (
							  `transaction_id` bigint(20) NOT NULL auto_increment,
							  `month_id` bigint(20) NOT NULL,
							  `category_id` bigint(20) NOT NULL,
							  `amount` double NOT NULL,
							  `description` varchar(256) default NULL,
							  `date_entered` date NOT NULL,
							  PRIMARY KEY  (`transaction_id`),
							  KEY `month_id` (`month_id`),
							  KEY `category_id` (`category_id`)
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	
			$this->db->query($budget_entries_sql);
			$this->db->query($categories_sql);
			$this->db->query($income_sql);
			$this->db->query($months_sql);
			$this->db->query($transactions_sql);
	
			$check_month_sql = "SELECT * FROM Months WHERE month_id = " . $month_year . $month_number;
			$query = $this->db->query($check_month_sql);
			
			if (count($query->result()) == 0) {
				$month_sql = "INSERT INTO Months (month_id, pretty_name, short_name, year, projected_income) 
						VALUES ('" . $month_year . $month_number . "', '" . $month_pretty_name . "', '" . $month_short_name . "', '" . $month_year . "', " . $month_projected_income . ") ";
				$this->db->query($month_sql);
				
				echo "Already Installed. Added " . $month_pretty_name . " " . $month_year . " to the database.";
			}
			
			echo "Install Complete. Go to the <a href='" . base_url() . "'>PHP Personal Budget Homepage</a>";
		}
	}
}
?>