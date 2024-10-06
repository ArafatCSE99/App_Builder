
         <div class="row">
           <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-success Gradient2">
               <div class="inner">
                 <h6 class="Gradient headings">Transactions Today</h6>
 
                 <?php 

                 $RetailSale=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'RetailSale',$current_date);
                 $WholeSale=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'WholeSale',$current_date);
                 $RetailSaleWarehouse=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'RetailSaleWarehouse',$current_date);
                 $WholeSaleWarehouse=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'WholeSaleWarehouse',$current_date);
                 $Purchase=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'Purchase',$current_date);
                 $StockTransfer=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'StockTransfer',$current_date);
                 $WarehouseIn=$Purchase;
                 $WarehouseOut=$StockTransfer+$RetailSaleWarehouse+$WholeSaleWarehouse;
                 $WarehouseCurrent=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'StockWarehouse',$current_date);
                 $BranchIn=$StockTransfer;
                 $BranchOut=$RetailSale+$WholeSale;
                 $BranchCurrent=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'StockBranch',$current_date);

                 $WarehouseCurrent=$WarehouseCurrent<0?0:$WarehouseCurrent;
                 
                 $BranchCurrent=$BranchCurrent<0?0:$BranchCurrent;

                 ?>

                 <table class="table table-bordered">
                 <tr>
                 <td>Retail Sale</td><td> <?php echo $RetailSale ?> </td>
                 </tr> 
                 <tr>
                 <td> WholeSale</td><td>  <?php echo $WholeSale ?> </td>
                 </tr>
                 <tr>
                 <td> Purchase </td><td> <?php echo $Purchase ?> </td>
                 </tr> 
                 <tr>
                 <td> Stock Transfer </td><td> <?php echo $StockTransfer ?> </td>
                 </tr>
                 <tr>
                 <td> Warehouse (In) </td><td> <?php echo $WarehouseIn ?> </td>
                 </tr>
                 <tr>
                 <td> Warehouse (Out) </td><td> <?php echo $WarehouseOut ?> </td>
                 </tr>
                 <tr>
                 <td> WareHouse (Current Stock) </td><td> <?php echo $WarehouseCurrent  ?></td>
                 </tr>
                 <tr>
                 <td> Branch (In) </td><td> <?php echo $BranchIn ?> </td>
                 </tr>
                 <tr>
                 <td> Branch (Out) </td><td> <?php echo $BranchOut ?> </td>
                 </tr>
                 <tr>
                 <td> Branch (Current Stock) </td><td> <?php echo $BranchCurrent ?>  </td>
                 </tr>  
 
                 </table>
                 
               </div>          
             </div>
           </div>
           <!-- ./col -->
           <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-info Gradient2">
               <div class="inner">
                 <h6 class="Gradient headings">Transaction This Month</h6>
                
                 <?php 

                 $RetailSale=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'RetailSale',$first_date_of_month);
                 $WholeSale=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'WholeSale',$first_date_of_month);
                 $RetailSaleWarehouse=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'RetailSaleWarehouse',$first_date_of_month);
                 $WholeSaleWarehouse=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'WholeSaleWarehouse',$first_date_of_month);
                 $Purchase=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'Purchase',$first_date_of_month);
                 $StockTransfer=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'StockTransfer',$first_date_of_month);
                 $WarehouseIn=$Purchase;
                 $WarehouseOut=$StockTransfer+$RetailSaleWarehouse+$WholeSaleWarehouse;
                 $WarehouseCurrent=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'StockWarehouse',$current_date);
                 $BranchIn=$StockTransfer;
                 $BranchOut=$RetailSale+$WholeSale;
                 $BranchCurrent=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'StockBranch',$current_date);


                 ?>

                 <table class="table table-bordered">
                 <tr>
                 <td>Retail Sale</td><td> <?php echo $RetailSale ?> </td>
                 </tr> 
                 <tr>
                 <td> WholeSale</td><td>  <?php echo $WholeSale ?> </td>
                 </tr>
                 <tr>
                 <td> Purchase </td><td> <?php echo $Purchase ?> </td>
                 </tr> 
                 <tr>
                 <td> Stock Transfer </td><td> <?php echo $StockTransfer ?> </td>
                 </tr>
                 <tr>
                 <td> Warehouse (In) </td><td> <?php echo $WarehouseIn ?> </td>
                 </tr>
                 <tr>
                 <td> Warehouse (Out) </td><td> <?php echo $WarehouseOut ?> </td>
                 </tr>
                 <tr>
                 <td> WareHouse (Current Stock) </td><td> <?php echo $WarehouseCurrent  ?></td>
                 </tr>
                 <tr>
                 <td> Branch (In) </td><td> <?php echo $BranchIn ?> </td>
                 </tr>
                 <tr>
                 <td> Branch (Out) </td><td> <?php echo $BranchOut ?> </td>
                 </tr>
                 <tr>
                 <td> Branch (Current Stock) </td><td> <?php echo $BranchCurrent ?>  </td>
                 </tr>  
 
                 </table>
                 
               </div>          
             </div>
           </div>
           <!-- ./col -->
           <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-danger Gradient2">
               <div class="inner">
                 <h6 class="Gradient headings">Transaction This Year</h6>
 
                
                 <?php 

                 $RetailSale=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'RetailSale',$first_date_of_year);
                 $WholeSale=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'WholeSale',$first_date_of_year);
                 $RetailSaleWarehouse=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'RetailSaleWarehouse',$first_date_of_year);
                 $WholeSaleWarehouse=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'WholeSaleWarehouse',$first_date_of_year);
                 $Purchase=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'Purchase',$first_date_of_year);
                 $StockTransfer=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'StockTransfer',$first_date_of_year);
                 $WarehouseIn=$Purchase;
                 $WarehouseOut=$StockTransfer+$RetailSaleWarehouse+$WholeSaleWarehouse;
                 $WarehouseCurrent=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'StockWarehouse',$current_date);
                 $BranchIn=$StockTransfer;
                 $BranchOut=$RetailSale+$WholeSale;
                 $BranchCurrent=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'StockBranch',$current_date);


                 ?>

                 <table class="table table-bordered">
                 <tr>
                 <td>Retail Sale</td><td> <?php echo $RetailSale ?> </td>
                 </tr> 
                 <tr>
                 <td> WholeSale</td><td>  <?php echo $WholeSale ?> </td>
                 </tr>
                 <tr>
                 <td> Purchase </td><td> <?php echo $Purchase ?> </td>
                 </tr> 
                 <tr>
                 <td> Stock Transfer </td><td> <?php echo $StockTransfer ?> </td>
                 </tr>
                 <tr>
                 <td> Warehouse (In) </td><td> <?php echo $WarehouseIn ?> </td>
                 </tr>
                 <tr>
                 <td> Warehouse (Out) </td><td> <?php echo $WarehouseOut ?> </td>
                 </tr>
                 <tr>
                 <td> WareHouse (Current Stock) </td><td> <?php echo $WarehouseCurrent  ?></td>
                 </tr>
                 <tr>
                 <td> Branch (In) </td><td> <?php echo $BranchIn ?> </td>
                 </tr>
                 <tr>
                 <td> Branch (Out) </td><td> <?php echo $BranchOut ?> </td>
                 </tr>
                 <tr>
                 <td> Branch (Current Stock) </td><td> <?php echo $BranchCurrent ?>  </td>
                 </tr>  
 
                 </table>
                 
               </div>          
             </div>
           </div>
           <!-- ./col -->
           <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-danger Gradient2">
               <div class="inner">
                 <h6 class="Gradient headings">All Transaction</h6>
 
                
                 <?php 

                 $RetailSale=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'RetailSale',$initial_date);
                 $WholeSale=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'WholeSale',$initial_date);
                 $RetailSaleWarehouse=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'RetailSaleWarehouse',$initial_date);
                 $WholeSaleWarehouse=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'WholeSaleWarehouse',$initial_date);
                 $Purchase=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'Purchase',$initial_date);
                 $StockTransfer=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'StockTransfer',$initial_date);
                 $WarehouseIn=$Purchase;
                 $WarehouseOut=$StockTransfer+$RetailSaleWarehouse+$WholeSaleWarehouse;
                 $WarehouseCurrent=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'StockWarehouse',$current_date);
                 $BranchIn=$StockTransfer;
                 $BranchOut=$RetailSale+$WholeSale;
                 $BranchCurrent=$inventory->getDashboardInfo($userid,$companyid,$branchid,$conn,'StockBranch',$current_date);


                 ?>

                 <table class="table table-bordered">
                 <tr>
                 <td>Retail Sale</td><td> <?php echo $RetailSale ?> </td>
                 </tr> 
                 <tr>
                 <td> WholeSale</td><td>  <?php echo $WholeSale ?> </td>
                 </tr>
                 <tr>
                 <td> Purchase </td><td> <?php echo $Purchase ?> </td>
                 </tr> 
                 <tr>
                 <td> Stock Transfer </td><td> <?php echo $StockTransfer ?> </td>
                 </tr>
                 <tr>
                 <td> Warehouse (In) </td><td> <?php echo $WarehouseIn ?> </td>
                 </tr>
                 <tr>
                 <td> Warehouse (Out) </td><td> <?php echo $WarehouseOut ?> </td>
                 </tr>
                 <tr>
                 <td> WareHouse (Current Stock) </td><td> <?php echo $WarehouseCurrent  ?></td>
                 </tr>
                 <tr>
                 <td> Branch (In) </td><td> <?php echo $BranchIn ?> </td>
                 </tr>
                 <tr>
                 <td> Branch (Out) </td><td> <?php echo $BranchOut ?> </td>
                 </tr>
                 <tr>
                 <td> Branch (Current Stock) </td><td> <?php echo $BranchCurrent ?>  </td>
                 </tr>  
 
                 </table>
                 
               </div>          
             </div>
           </div>
           <!-- ./col -->
         </div>
         <!-- /.row -->