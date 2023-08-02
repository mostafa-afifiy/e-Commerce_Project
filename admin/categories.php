<?php
session_start();
$title = "Categories";  
include 'init.php';  

if(isset($_SESSION['admin'])) {

?>

			<h1 class="text-center">Manage Categories</h1>
			<div class="container categories">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-edit"></i> Manage Categories
						<div class="option pull-right">
							<i class="fa fa-sort"></i> Ordering: [
							<a class="" href="?sort=asc">Asc</a> | 
							<a class="" href="?sort=desc">Desc</a> ]
							<i class="fa fa-eye"></i> View: [
							<span class="active" data-view="full">Full</span> |
							<span data-view="classic">Classic</span> ]
						</div>
					</div>
					<div class="panel-body">
						
								<div class='cat'>    
									<div class='hidden-buttons'>
										<a href='' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>
										<a href='' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>
									</div>
									<h3></h3>
									<div class='full-view'>
										<p><p>
										<span class="visibility cat-span"><i class="fa fa-eye"></i> Hidden</span>
										<span class="commenting cat-span"><i class="fa fa-close"></i> Comment Disabled</span>
										<span class="advertises cat-span"><i class="fa fa-close"></i> Ads Disabled</span>
									</div>    

								      	<h4 class='child-head'>Child Categories</h4>
								      	<ul class='list-unstyled child-cats'>
											<li class='child-link'>
												<a href=''></a>
												<a href='' class='show-delete confirm'> Delete</a>
											</li>
										</ul>

								</div>
								<hr>
					</div>
				</div>
				<a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New Category</a>
			</div>

		
<!-- 
				<div class="container">   
					<div class="nice-message">There\'s No Categories To Show</div>   
					<a href="categories.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i> New Category
						</a>   
				</div>    -->



			<h1 class="text-center">Add New Category</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Category" />
						</div>
					</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="description" class="form-control" placeholder="Describe The Category" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Ordering Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Ordering</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories" />
						</div>
					</div>
					<!-- End Ordering Field -->
					<!-- Start Category Type -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Parent?</label>
						<div class="col-sm-10 col-md-6">
							<select name="parent">
								<option value="0">None</option>
										<option value='vv'>oo</option>
							</select>
						</div>
					</div>
					<!-- End Category Type -->
					<!-- Start Visibility Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Visible</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="vis-yes" type="radio" name="visibility" value="0" checked />
								<label for="vis-yes">Yes</label> 
							</div>
							<div>
								<input id="vis-no" type="radio" name="visibility" value="1" />
								<label for="vis-no">No</label> 
							</div>
						</div>
					</div>
					<!-- End Visibility Field -->
					<!-- Start Commenting Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Commenting</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="com-yes" type="radio" name="commenting" value="0" checked />
								<label for="com-yes">Yes</label> 
							</div>
							<div>
								<input id="com-no" type="radio" name="commenting" value="1" />
								<label for="com-no">No</label> 
							</div>
						</div>
					</div>
					<!-- End Commenting Field -->
					<!-- Start Ads Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">Allow Ads</label>
						<div class="col-sm-10 col-md-6">
							<div>
								<input id="ads-yes" type="radio" name="ads" value="0" checked />
								<label for="ads-yes">Yes</label> 
							</div>
							<div>
								<input id="ads-no" type="radio" name="ads" value="1" />
								<label for="ads-no">No</label> 
							</div>
						</div>
					</div>
					<!-- End Ads Field -->
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>

				    <h1 class='text-center'>Insert Category</h1>    
				    <div class='container'>    

					<div class="alert alert-danger">Sorry This Category Is Exist</div>   


				<h1 class="text-center">Edit Category</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="catid" value="" />
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="name" class="form-control" required="required" placeholder="Name Of The Category" value="" />
							</div>
						</div>
						<!-- End Name Field -->
						<!-- Start Description Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="description" class="form-control" placeholder="Describe The Category" value="" />
							</div>
						</div>
						<!-- End Description Field -->
						<!-- Start Ordering Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Ordering</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories" value="" />
							</div>
						</div>
						<!-- End Ordering Field -->
						<!-- Start Category Type -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Parent?</label>
							<div class="col-sm-10 col-md-6">
								<select name="parent">
									<option value="0">None</option>
											    <option value=''    
											    ></option>    
								</select>
							</div>
						</div>
						<!-- End Category Type -->
						<!-- Start Visibility Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Visible</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="vis-yes" type="radio" name="visibility" value="0" />
									<label for="vis-yes">Yes</label> 
								</div>
								<div>
									<input id="vis-no" type="radio" name="visibility" value="1"/>
									<label for="vis-no">No</label> 
								</div>
							</div>
						</div>
						<!-- End Visibility Field -->
						<!-- Start Commenting Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Commenting</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="com-yes" type="radio" name="commenting" value="0" />
									<label for="com-yes">Yes</label> 
								</div>
								<div>
									<input id="com-no" type="radio" name="commenting" value="1" />
									<label for="com-no">No</label> 
								</div>
							</div>
						</div>
						<!-- End Commenting Field -->
						<!-- Start Ads Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Ads</label>
							<div class="col-sm-10 col-md-6">
								<div>
									<input id="ads-yes" type="radio" name="ads" value="0" />
									<label for="ads-yes">Yes</label> 
								</div>
								<div>
									<input id="ads-no" type="radio" name="ads" value="1" />
									<label for="ads-no">No</label> 
								</div>
							</div>
						</div>
						<!-- End Ads Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-lg" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>


				    <div class='container'>    

				<div class="alert alert-danger">Theres No Such ID</div>   

				    </div>    
			    <h1 class='text-center'>Update Category</h1>    
			    <div class='container'>    


			    <h1 class='text-center'>Delete Category</h1>    
			    <div class='container'>    
</div>   

		}

<?php include $tpl . 'footer.php'; ?>

<?php 
} else {
	header("location: index.php");
	exit();
}