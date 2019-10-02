<div class="row">
    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header box-header-background with-border">
                <h3 class="box-title center">Inventory Valuation Summary</h3>
            </div>




            <div class="box-body">

                <div id="printableArea">
                    <div class="row ">
                        <div class="col-md-12 ">

                            <main class="invoice_report">
                                <div class="table-responsive">
                                    <table class="table table-bordered" cellspacing="0" cellpadding="5">
                                        <tbody><tr>
                                            <td class="active" valign="middle"><strong>ITEM CODE</strong></td>
                                            <td class="active" valign="middle"><strong>ITEM NAME</strong></td>
                                            <td class="active"><strong>STOCK ON HAND</strong></td>
                                            <td class="active" align="right"><strong>STOCK ASSET VALUE</strong></td>
                                        </tr>
                                        <?php 
                                            $grand_total = 0;
                                            foreach ($items as $item) { 
                                                $grand_total += $item->total;
                                            ?>
                                            <tr>
                                                <td><?php echo $item->item_id; ?></td>
                                                <td><?php echo $item->item_name; ?></td>
                                                <td><?php echo $item->qty; ?></td>
                                                <td class="text-right"><?php echo currency_format($item->total); ?></td>
                                            </tr>
                                        <?php } ?>
 
                                        <tr>
                                            <td colspan="3"><strong>Total</strong></td>
                                            <td class="text-right"><strong><?php echo currency_format($grand_total); ?></strong></td>
                                        </tr>

                                        </tbody></table>
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