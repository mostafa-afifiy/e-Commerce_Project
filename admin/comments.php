<?php
session_start();
$title = "Comments";  
include 'init.php';    

if(isset($_SESSION['admin'])) {

?>

			<h1 class="text-center">Manage Comments</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>ID</td>
							<td>Comment</td>
							<td>Item Name</td>
							<td>User Name</td>
							<td>Added Date</td>
							<td>Control</td>
						</tr>
								  <tr>   
									  <td></td>   
									  <td></td>   
									  <td></td>   
									  <td></td>   
									  <td></td>   
									  <td>
										<a href='' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href='' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>   
											  <a href='' 
													class='btn btn-info activate'>
													<i class='fa fa-check'></i> Approve</a>   
										}
									  </td>   
								  </tr>   
						<tr>
					</table>
				</div>
			</div>

				    <div class="container">     
					    <div class="nice-message">There\'s No Comments To Show</div>     
				    </div>     


				<h1 class="text-center">Edit Comment</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="comid" value" />
						<!-- Start Comment Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Comment</label>
							<div class="col-sm-10 col-md-6">
								<textarea class="form-control" name="comment"></textarea>
							</div>
						</div>
						<!-- End Comment Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-sm" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>

			

				  <div class='container'>   

				<div class="alert alert-danger">Theres No Such ID</div>     


				  </div>   

			}


			  <h1 class='text-center'>Update Comment</h1>   
			  <div class='container'>   


				<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>     

				<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>     

			  </div>   


			  <h1 class='text-center'>Delete Comment</h1>   

			  <div class='container'>   

			    </div>     


			  <h1 class='text-center'>Approve Comment</h1>   
			  <div class='container'>   
			    </div>     


		<?php include $tpl . 'footer.php'; ?>

<?php 
} else {
	header("location: index.php");
	exit();
}