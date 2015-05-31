<?php


require_once('phpapi/cps_simple.php');
	
	try {

	  	// Connection hubs
		$connectionStrings = array(
			'tcp://cloud-eu-0.clusterpoint.com:9007',
			'tcp://cloud-eu-1.clusterpoint.com:9007',
			'tcp://cloud-eu-2.clusterpoint.com:9007',
			'tcp://cloud-eu-3.clusterpoint.com:9007'
		);
	
		// Creating a CPS_Connection instance
		$cpsConn = new CPS_Connection(
			new CPS_LoadBalancer($connectionStrings), 'Catalog', 'harish@angelhack.com', 'Hackstrong14', 'document', '//document/id', array('account' => 751));

		$cpsSimple = new CPS_Simple($cpsConn);
		extract($_POST);
		$document = array(
		    'id'=>$id,
		  	'author'=>$author,
		    'title'=>$title,
		    'genre'=>$genre,
		    'price'=>$price,
		    'publish_date'=>$publish_date,
		    'description'=>$description
		);

		$insertReturn = $cpsSimple->insertSingle($id, $document);
		echo 'Success';
	}
	catch (CPS_Exception $e) {
	 	echo 'fail';
	  	//var_dump($e->errors());
	  	exit;
	}

?>