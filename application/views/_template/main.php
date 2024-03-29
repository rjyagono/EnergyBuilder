<div class="dashboard">
    <div class="row dashboard-section">
        <div class="col-lg-8 sales-activity">
            <label class="box-title">Sales Activity</label>
            <div>
                <!-- /.col -->
                <div class="col-md-2 so-inner-widget text-center">
                    <a href="#" class="legend text-primary"> <?= $today_invoices->count; ?>  </a>
                    <span class="info-box-text">Today Invoices</span>
                </div>
                <!-- /.col -->
                <div class="col-md-2 so-inner-widget text-center">
                    <a href="#" class="legend text-red"> <?= $thisMonth_invoices->count; ?>  </a>
                    <span class="info-box-text">This Month Invoices</span>
                </div>
                <!-- /.col -->
                <div class="col-md-2 so-inner-widget text-center">
                    <a href="#" class="legend text-green">  0  </a>
                    <span class="info-box-text">Today Transfers</span>
                </div>
                <!-- /.col -->
                <div class="col-md-2 so-inner-widget text-center">
                    <a href="#" class="legend text-orange"> <?php foreach ($today_sales as $today_sale) {
                            echo $today_sale->sales_amount_total;
                        } ?> 0 </a>
                    <span class="info-box-text">Today Sales</span>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 inventory-summary">
            <label class="box-title">Inventory Summary</label> 

            <div class="inv-summary"> 
                <a href="<?=base_url();?>reports/stock_summary"> 
                    <label class="text-uppercase">Quantity in Hand</label> 
                    <label class="cursor-pointer pull-right text-plain"> 
                    <b><?php echo $total_stocks_on_hand ? $total_stocks_on_hand->count : '0'; ?></b> </label>
                </a>
            </div> 
            <div class="inv-summary">
                <a href="<?=base_url();?>reports/stock_level"> 
                    <label class="text-uppercase">Low Stock Items</label> 
                    <label class="cursor-pointer pull-right text-plain"> 
                    <b><?php echo $below_stock_level ? $below_stock_level->count : '0'; ?></b> </label>
                </a>
            </div>
         </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Users List</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>UserName</th>
                                <th>Group</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($users_list)) {
                                foreach ($users_list as $users) : ?>
                                    <tr>
                                        <td><?= $users->USER_NAME; ?></td>
                                        <td><?= $users->GROUP_NAME; ?></td>
                                        <td><?php if ($users->IS_ACTIVE == 1) { ?>
                                                <span class="label label-success">ACTIVE</span>
                                            <?php } else { ?>
                                                <span class="label label-default">INACTIVE</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?= date("d M,Y", strtotime($users->CREATED_DATE)); ?>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            } else {
                                echo "<tr><td>No Records Found</td></tr>";
                            } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-6">
            <div class="box box-danger">
                <div class="box-header">
                    <h4 class="box-title">Employee Searching</h4>
                </div>
                <div class="box-body">
                    <div class="container" style="width:500px;">
                        <h2 align="center">Search Employees</h2>
                        <br/><br/>
                        <div align="center">
                            <input type="text" name="search" id="search" placeholder="Search Employee Details"
                                   class="form-control input-medium"/>
                        </div>
                        <ul class="list-group" id="result"></ul>
                        <br/>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!--work progress start-->
            <div class="box box-success">
                <div class="box-header with-border box-green">
                    <h3 class="box-title">Stock Report</h3>
                </div>
                <div class="box-body">
                    <table class="table table-hover personal-task">
                        <tbody>
                        <tr>
                            <td>Item Qty</td>
                            <td>Name</td>
                            <td>Price</td>
                        </tr>
                        <?php $i = 1;
                        foreach ($daily_st as $daily_st) { ?>
                            <tr>
                                <td><span class="date">
                    <?php $aaa = $daily_st->stock_qty;
                    if ($aaa < 10) {
                        ?>
                        <font style="text-decoration:blink; color:#F00; font-size:18px">
                            <?php
                            echo "<span class='label label-danger'>$daily_st->stock_qty</span>";


                            ?>
                        </font>
                        <?php

                    } else {
                        echo " <span class='label label-success'>$daily_st->stock_qty</span>";
                    }
                    ?>
                    </span> <span class="time">
                    <?php //echo $daily_st->category_name;?>
                    </span></td>
                                <td><a href="#"><?php echo $daily_st->item_name; ?></a></td>
                                <td><span class="price"><?php echo $daily_st->stock_rate; ?></span></td>
                            </tr>
                        <?php } ?>

                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </div>
            <!--work progress end-->
        </div>

        <div class="col-md-8">
            <!-- TABLE: LATEST ORDERS -->
            <div class="box box-warning">
                <div class="box-header with-border box-green">
                    <h3 class="box-title">Latest Purchases</h3>

                </div>
                <div class="box-body">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>Purchase ID</th>
                            <th>Vendor</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Purchase Total</th>
                            <th>View</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($due_amounts as $due_amount) : ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url(); ?>purchase/show_purchase_history/<?= $due_amount->purchase_id ?>"><?= $due_amount->purchase_id; ?></a>
                                </td>
                                <td><?= $due_amount->vendor_name; ?></td>
                                <td><?= date("d-m-Y", strtotime($due_amount->purchase_date)); ?></td>
                                <td>
                                    <?= typeStatus($due_amount->status); ?>
                                </td>
                                <td>₱ <?= $due_amount->grand_total; ?></td>
                                <td>
                                    <a href="<?= base_url(); ?>purchase/show_purchase_history/<?= $due_amount->purchase_id ?>"
                                       class="btn btn-info">View Purchase</a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <!-- /.box-footer -->
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="box"><!-- /primary heading -->
                <div class="box-header">
                    <h4 class="box-title text-dark text-uppercase">
                        Top 5 Selling Product June </h4>
                </div>
                <div id="box2" class="panel-collapse collapse in">
                    <div class="box-body" style="height: 400px">

                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Barcode</th>
                                <th>Product Name</th>
                                <th>Qty</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($topsales)) {
                                $i = 1;
                                foreach ($topsales as $topsale) : ?>

                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $topsale->item_id; ?></td>
                                        <td><?= $topsale->item_name; ?></td>
                                        <td><?= $topsale->sales_qty; ?></td>
                                    </tr>

                                    <?php $i++; endforeach;
                            } else { ?>
                                <tr style="column-span: 4">
                                    <td><strong>No Records Found</strong></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box light bordered"><!-- /primary heading -->
                <div class="box-header">
                    <h4 class="box-title text-dark text-uppercase">
                        Top 5 Selling Product <?=date('Y');?> </h4>
                </div>
                <div id="box2" class="panel-collapse collapse in">
                    <div class="box-body" style="height: 400px">

                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Barcode</th>
                                <th>Product Name</th>
                                <th>Qty</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($topSalesYear)) {
                                $i = 1;
                                foreach ($topSalesYear as $topsale) : ?>

                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $topsale->item_id; ?></td>
                                        <td><?= $topsale->item_name; ?></td>
                                        <td><?= $topsale->sales_qty; ?></td>
                                    </tr>

                                    <?php $i++; endforeach;
                            } else { ?>
                                <tr style="column-span: 4">
                                    <td><strong>No Records Found</strong></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>  

    <footer>
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2019 <a href="#"><?=$title ?></a></strong> All rights
        reserved.
    </footer>
</div>

