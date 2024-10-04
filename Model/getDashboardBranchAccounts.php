<?php
                     $RetailSale=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'RetailSale',$current_date);
                     $WholeSale=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'WholeSale',$current_date);
                     $Purchase=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'Purchase',$current_date);
                     
                     $TotalSale=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalSale',$current_date);
                     $TotalCash=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalCash',$current_date);
                     $TotalDue=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalDue',$current_date);
                     $Installment=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'Installment',$current_date);
                     $StockReceived=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'StockReceived',$current_date);
                     $BranchPayment=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'BranchPayment',$current_date);
                     $StockValue=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'StockValue',$current_date);
                      $TotalExpense=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalExpense',$current_date);
                        $TotalCashProfit=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalCashProfit',$current_date);
                        $TotalDueProfit=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalDueProfit',$current_date);
                 ?>

        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success Gradient2">
              <div class="inner">
                <h6 class="Gradient headings">Transactions Today</h6>

                   <?php include "getDashboardBranchAccountsBody.php" ?>
                
              </div>          
            </div>
          </div>
          <!-- ./col -->

               <?php
                     $RetailSale=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'RetailSale',$first_date_of_month);
                     $WholeSale=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'WholeSale',$first_date_of_month);
                     $Purchase=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'Purchase',$first_date_of_month);
                     
                     $TotalSale=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalSale',$first_date_of_month);
                     $TotalCash=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalCash',$first_date_of_month);
                     $TotalDue=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalDue',$first_date_of_month);
                     $Installment=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'Installment',$first_date_of_month);
                      $StockReceived=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'StockReceived',$first_date_of_month);
                      $BranchPayment=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'BranchPayment',$first_date_of_month);
                       $StockValue=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'StockValue',$first_date_of_month);
                       $TotalExpense=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalExpense',$first_date_of_month);
                       $TotalCashProfit=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalCashProfit',$first_date_of_month);
                       $TotalDueProfit=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalDueProfit',$first_date_of_month);
                 ?>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info Gradient2">
              <div class="inner">
                <h6 class="Gradient headings">Transaction This Month</h6>
                
                <?php include "getDashboardBranchAccountsBody.php" ?>
                
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
                     $RetailSale=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'RetailSale',$first_date_of_year);
                     $WholeSale=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'WholeSale',$first_date_of_year);
                     $Purchase=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'Purchase',$first_date_of_year);
                     
                       $TotalSale=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalSale',$first_date_of_year);
                        $TotalCash=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalCash',$first_date_of_year);
                         $TotalDue=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalDue',$first_date_of_year);
                         $Installment=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'Installment',$first_date_of_year);
                          $StockReceived=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'StockReceived',$first_date_of_year);
                          $BranchPayment=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'BranchPayment',$first_date_of_year);
                           $StockValue=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'StockValue',$first_date_of_year);
                           $TotalExpense=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalExpense',$first_date_of_year);
                           $TotalCashProfit=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalCashProfit',$first_date_of_year);
                           $TotalDueProfit=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalDueProfit',$first_date_of_year);
                 ?>

                <?php include "getDashboardBranchAccountsBody.php" ?>
                
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
                     $RetailSale=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'RetailSale',$initial_date);
                     $WholeSale=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'WholeSale',$initial_date);
                     $Purchase=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'Purchase',$initial_date);
                     
                     $TotalSale=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalSale',$initial_date);
                       $TotalCash=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalCash',$initial_date);
                         $TotalDue=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalDue',$initial_date);
                         $Installment=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'Installment',$initial_date);
                          $StockReceived=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'StockReceived',$initial_date);
                          $BranchPayment=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'BranchPayment',$initial_date);
                           $StockValue=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'StockValue',$initial_date);
                           $TotalExpense=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalExpense',$initial_date);
                           $TotalCashProfit=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalCashProfit',$initial_date);
                            $TotalDueProfit=$inventory->getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,'TotalDueProfit',$initial_date);
                 ?>

                <?php include "getDashboardBranchAccountsBody.php" ?>
                
              </div>          
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
