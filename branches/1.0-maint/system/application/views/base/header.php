<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<?php $this->load->helper('url'); ?>
	
		<title>Budget Overview</title>
		<script type="text/javascript" src="<?=$this->config->item('base_url')?>resources/js/json.js"></script>
		
		<!-- Dependencies -->
		<!-- core CSS -->
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.3.1/build/reset-fonts-grids/reset-fonts-grids.css">
		<!-- link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.3.1/build/tabview/assets/skins/sam/tabview.css" />
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.3.1/build/datatable/assets/skins/sam/datatable.css" / -->
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.3.1/build/assets/skins/sam/skin.css">
		
		<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/utilities/utilities.js"></script>
		<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/element/element-beta-min.js"></script>
		<!--script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/connection/connection-min.js"></script-->
		<!--script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/datasource/datasource-beta-min.js"></script>
		<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/datatable/datatable-beta-min.js"></script-->
		
		
		<!--script type="text/javascript" src="<?=$this->config->item('base_url')?>resources/yui/2.3.1/build/datasource/datasource-beta-debug.js"></script>
		<script type="text/javascript" src="<?=$this->config->item('base_url')?>resources/yui/2.3.1/build/datatable/datatable-beta-debug.js"></script-->
		<!--script type="text/javascript" src="<?=$this->config->item('base_url')?>resources/yui/2.3.1/build/connection/connection-debug.js"></script-->
		<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/container/container-min.js"></script> 
		<!--script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/menu/menu-min.js"></script-->
		
		<!-- OPTIONAL: Connection (required for dynamic loading of data) -->
		<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/connection/connection-min.js"></script>
		
		<!-- Source file -->
		<script type="text/javascript" src="http://yui.yahooapis.com/2.4.1/build/container/container-min.js"></script>
		<script type="text/javascript" src="http://yui.yahooapis.com/2.4.1/build/menu/menu-min.js"></script>
		<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/treeview/treeview-min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>resources/js/prototype.js"></script>
		<script type="text/javascript" src="<?=base_url()?>resources/js/scriptaculous/scriptaculous.js"></script>
		<script type="text/javascript" src="<?=base_url()?>resources/js/accordion.js"></script>
		
		<!-- Custom CSS -->
		<link rel="stylesheet" type="text/css" href="<?=$this->config->item('base_url')?>resources/css/main.css" />
		
		
		<!--CSS file (default YUI Sam Skin) -->
		<!--link type="text/css" rel="stylesheet" href="<?=$this->config->item('base_url')?>/resources/yui/2.3.1/build/logger/assets/skins/sam/logger.css" /-->
		
		<!-- Dependencies -->
		<!--script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/yahoo-dom-event/yahoo-dom-event.js"></script-->
		
		<!-- OPTIONAL: Drag and Drop (not required if not enabling drag and drop) -->
		<!--script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/dragdrop/dragdrop-min.js"></script-->
		
		<!-- Source file -->
		<!--script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/logger/logger-min.js"></script-->
		
	</head>
	
	<body class="yui-skin-sam">
