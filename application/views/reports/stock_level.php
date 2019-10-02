<div class="row form_wrap">
    <div class="col-md-12">

        <div class="box box-primary">
            <div class="box-header box-header-background with-border">
                <div class="col-md-offset-0">
                    <h3 class="box-title ">Low Stock Items</h3>
                </div>
            </div>

            <div class="box-body">
<!-- 
                <div class="row ">
                    <div class="col-md-8 col-md-offset-2">
                        <form method="post" action="http://multi-inventory.codeslab.net/admin/report/pdf_top_selling_product">
                            <div class="btn-group pull-right">
                                <a onclick="print_invoice('printableArea')" class="btn btn-primary">Print</a>

                                <button type="submit" class="btn bg-navy">
                                    PDF                                </button>
                                <input type="hidden" name="start_date" value="2016-10-01">
                                <input type="hidden" name="end_date" value="2016-10-12">

                            </div>
                        </form>

                    </div>
                </div>

                <br>
                <br> -->

                <div id="printableArea">


                    <div class="row ">
                        <div class="col-md-12">

                            <main class="invoice_report">
                                <div class="table-responsive">
                                    <table width="100%" class="table table-bordered" border="0" cellspacing="0" cellpadding="5">
                                        <tbody>
                                        <tr>
                                            <td class="active" width="12%"><strong>ITEM CODE</strong></td>
                                            <td class="active" width="24%"><strong>ITEM NAME</strong></td>
                                            <td class="active" width="12%" align="right"><strong>STOCK ON HAND</strong></td>
                                            <td class="active" width="12%" align="right"><strong>REORDER LEVEL</strong></td> 
                                        </tr>
                                        <?php foreach ($items as $item) {  ?>
                                            <tr>
                                                <td><?php echo $item->item_id; ?></td>
                                                <td><?php echo $item->item_name; ?></td>
                                                <td class="text-right"><?php echo $item->qty; ?></td>
                                                <td class="text-right"><?php echo $item->stock_limit; ?></td>
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