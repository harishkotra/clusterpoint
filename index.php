<?php

    require_once('phpapi/cps_simple.php');
    error_reporting();
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

	$documents = $cpsSimple->search('*');
	//$documentsA = xml2array($documents);
	$myassocarray = xml2array($documents);

	function xml2array ( $xmlObject, $out = array () )
	{
	    foreach ( (array) $xmlObject as $index => $node )
	        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

	    return $out;
	}


?>


<html>
<head>
	<title>Submitting to the Database using PHP</title>
	<!-- bootstrap stylesheet CDN -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">

	<style>
	#insertreturnsuccess{display: none;}
	#insertreturnfailure{display: none;}
	</style>
</head>
<body>

	

	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center" style="margin:0px auto 40px;display:block;text-align:center;">
				<a class="navbar-brand" href="#">
		        	<img alt="Brand" src="http://i.imgur.com/O6PfVGc.png">
		      	</a>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-8" style="margin:20px auto;">
				<h3 style="margin-top:20px;">Catalog</h3>
				<table class="table table-hover">
					<thead>
					  <tr>
					    <th>ID</th>
					    <th>Title</th>
					    <th>Author</th>
					    <th>Genre</th>
					    <th>Price</th>
					    <th>Published On</th>
					  </tr>
					</thead>
					<tbody>
					<?php
						foreach($myassocarray as $singleobj) {
					?>
					  <tr>
					    <td><?php echo $singleobj['id']; ?></td>
					    <td><?php echo $singleobj['title']; ?></td>
					    <td><?php echo $singleobj['author']; ?></td>
					    <td><?php echo $singleobj['genre']; ?></td>
					    <td><?php echo $singleobj['price']; ?></td>
					    <td><?php echo $singleobj['publish_date']; ?></td>
					  </tr>
					<?php } ?>
					</tbody>
				</table>

			</div>
			<div class="col-sm-4" style="margin:20px auto;">
			<div class="panel-group" id="accordion">
		        <div class="panel panel-default">
		            <div class="panel-heading">
		                <h4 class="panel-title">
		                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Add New Data</a>
		                </h4>
		            </div>
		            <div id="collapseOne" class="panel-collapse collapse in">
		                <div class="panel-body">
		                	<form id="insertform" method="POST" action="">
								<div class="form-group">
									<label for="id">ID</label>
									<input class="form-control" type="text" name="id" />
								</div>
								<div class="form-group">
									<label for="id">Author</label>
									<input class="form-control" type="text" name="author" />
								</div>
								<div class="form-group">
									<label for="id">Title</label>
									<input class="form-control" type="text" name="title" />
								</div>
								<div class="form-group">
									<label for="id">Genre</label>
									<input class="form-control" type="text" name="genre" />
								</div>
								<div class="form-group">
									<label for="id">Price</label>
									<input class="form-control" type="text" name="price" />
								</div>
								<div class="form-group">
									<label for="id">Publish Date</label>
									<input class="form-control" type="text" name="publish_date" />
								</div>
								<div class="form-group">
									<label for="id">Description</label>
									<textarea class="form-control" name="description"></textarea>
								</div>
								<div class="form-group">
									<input type="submit" name="submit" class="btn btn-default"></input>
								</div>
								<div class="alert alert-success" id="insertreturnsuccess" role="alert"></div>
								<div class="alert alert-error" id="insertreturnfailure" role="alert"></div>
							</form>
		                </div>
		            </div>
		        </div>
		        <div class="panel panel-default">
		            <div class="panel-heading">
		                <h4 class="panel-title">
		                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Check Stats</a>
		                </h4>
		            </div>
		            <div id="collapseTwo" class="panel-collapse collapse">
		                <div class="panel-body">
		                    Dummy data here.
		                </div>
		            </div>
		        </div>
		    </div>
				
			</div>

		</div>
	</div>
	
	<!-- jquery cdn -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<!-- bootstrap js CDN -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<!-- form submit code -->

	<script>
	    (function($){
	        function processForm( e ){
	            $.ajax({
	                url: 'insertValues.php',
	                dataType: 'text',
	                type: 'post',
	                contentType: 'application/x-www-form-urlencoded',
	                data: $(this).serialize(),
	                success: function( data, textStatus, jQxhr ){
	                    //$('#response pre').html( data );
	                   	if(data == 'Success') {
	                   		//alert('Voila! It worked.');
	                   		$('#insertreturnsuccess').show();
	                   		$('#insertreturnsuccess').text("Your data has been inserted.");
	                   		location.reload();
	                   	}
	                   	else {
	                   		//alert('Something went wrong. Check what you entered.');
	                   		$('#insertreturnfailure').show();
	                   		$('#insertreturnfailure').text("Something went wrong, try again in some time.");

	                   	}
	                },
	                error: function( jqXhr, textStatus, errorThrown ){
	                    console.log( errorThrown );
	                }
	            });

	            e.preventDefault();
	        }

	        $('#insertform').submit( processForm );
	    })(jQuery);
	</script>

</body>
</html>