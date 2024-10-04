
    <!-- Main content -->
<section class="content" id="add">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Customer</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

<div class="row">
    
    <div class="col-sm-8">

              <div class="form-group">
                <label for="category">Customer Name</label>
                <input type="text" id="name" style="width:50%" class="form-control" placeholder="Customer Name">
              </div>
              
               <div class="form-group">
                <label for="proprietor">Proprietor Name</label>
                <input type="text" id="proprietor" style="width:50%" class="form-control" placeholder="Proprietor Name">
              </div>
 
              <div class="form-group">
                <label for="category">Mobile No</label>
                <input type="text" id="mobileno" style="width:50%" class="form-control"  placeholder="Mobile No">
              </div>

              <div class="form-group">
                <label for="category">Address</label>
                <input type="text" id="address" style="width:50%" class="form-control"  placeholder="Address">
              </div>
              
              <div class="form-group" >
                <label for="category">Reference</label>
                <input type="text" id="reference" style="width:50%" class="form-control"  placeholder="Reference">
              </div>

              <div class="form-group" style='display:none;'>
                <label for="category">Opening Balance</label>
                <input type="number" id="opening_due" style="width:50%" class="form-control"  placeholder="Balance">
              </div>
              
              <div class="form-group" style='display:none;'>
                <label for="category">Month</label>
                <input type="number" id="month" style="width:50%" class="form-control"  placeholder="Month">
              </div>

 

              <input type="button" onclick="saveCustomerdata()"  value="Save" class="btn btn-success float-left">
              
              </div>
              
               <div class="col-sm-4">
                   
                   <form method="post" id="image-form" enctype="multipart/form-data" onSubmit="return false;">
				<div class="form-group">
					<input type="file" name="file" class="file">
					<div class="input-group my-3" style="width:350px;">
						<input type="text" style="width:20px; display:none;" class="form-control" disabled placeholder="Upload Product Image" id="file">
						<div class="input-group-append">
							<button type="button" style="display:none;" class="browse btn btn-primary">Browse...</button>
						</div>
					</div>
				</div>

      <div class="form-group">
       
					<img src="dist/img/global_logo.png" height="400px;" width="150px;" id="preview" class="img-thumbnail">
			
      </div>

				<div class="form-group">
					<input type="submit" name="submit" value="Upload" style="display:none;" class="btn btn-danger">
				</div>
    </form>

                   
                </div>
              
              </div>
              
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
     
    </section>
    <!-- /.content -->