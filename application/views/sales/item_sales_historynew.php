
</script>


    <section class="invoice">


                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-globe"></i> <?= $title; ?>
                            <small class="pull-right">Date: 2/10/2014</small>
                        </h2>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong><?=$amount->company_name;?></strong><br>
                            <?=$amount->address;?><br>
                            Phone: <?=$amount->phone_no;?><br>
                            Email: <?=$amount->email;?>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                            <strong><?=$amount->customer_name;?></strong><br>
                            <?=$amount->address;?><br>
                            Phone: <?=$amount->phone_no;?><br>
                            Email: <?=$amount->email;?>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <b>Invoice #<?=$amount->invoice_no;?></b><br>
                        <br>
                        <b>Order ID:</b> 4F3S8J<br>
                        <b>Payment Due:</b> 2/22/2014<br>
                        <b>Account:</b> 968-34567
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Serial #</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1;foreach ($salesHist as $item) : ?>
                                <tr>
                                    <td><?=$i;?></td>
                                    <td><?=$item->item_name;?></td>
                                    <td><?=$item->sales_qty;?></td>
                                    <td><?=$item->sales_rate;?></td>
                                    <td><?=$item->sales_amount;?></td>
                                </tr>
                                <?php $i++; endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-xs-6">
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Subtotal:</th>
                                    <td><?=$amount->sales_amount_total?></td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td><?=$amount->grand_total;?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-xs-12">
                        <a href="<?=base_url('sales/invoice_print')?>/<?=$this->uri->segment(3);?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>

                    </div>
                </div>


    </section>




