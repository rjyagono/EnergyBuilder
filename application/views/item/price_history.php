<div class="row form_wrap">
    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header box-header-background with-border">
                <div class="col-md-offset-0">
                    <h3 class="box-title ">Price History</h3>
                </div>
            </div>

            <div class="box-body">

                <div id="printableArea">

                    <div class="row ">
                        <div class="col-md-12">

                            <main class="invoice_report">
                                <div class="table-responsive">
                                    <table width="100%" class="table table-bordered" border="0" cellspacing="0" cellpadding="5">
                                        <tbody>
                                        <tr>
                                            <td class="active" width="12%"><strong>Transaction Date</strong></td>
                                            <td class="active" width="24%"><strong>Supplier</strong></td>
                                            <td class="active" width="12%" align="right"><strong>Purchase Price</strong></td>
                                            <td class="active" width="12%" align="right"><strong>Selling Price</strong></td> 
                                        </tr>
                                        <?php foreach ($items as $item) {  ?>
                                            <tr>
                                                <td><?php echo dateFormat($item->transaction_date); ?></td>
                                                <td><?php echo $item->vendor_name; ?></td>
                                                <td class="text-right"><?php echo $item->unit_cost; ?></td>
                                                <td class="text-right"><?php echo $item->selling_price; ?></td>
                                            </tr>
                                        <?php } ?>
                                         
                                        </tbody>
                                    </table>
                                </div>
                            </main>

 
                        </div>
                    </div>

                </div>


            </div>
            <!-- /.box -->
        </div>
        <!--/.col end -->
    </div>
    <!-- /.row -->
</div>