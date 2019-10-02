<section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-globe"></i> <?=$title ?>
                            <small class="pull-right">Date: <?= $header->receive_date; ?></small>
                        </h2>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                  <div class="row invoice-info">
                    <div>
                      <br><center><b>Stock Receiving Receipt</b></center><br>
                    </div>
                    <div class="col-sm-3 invoice-col">
                          <strong>Vendor:</strong>
                          <address>
                            <?php if($header->vendor_name == ''){ ?>
                              <?= $header->vendor_name; ?><br>
                              <?= $header->vendor_address; ?><br>
                            <?php } ?> 
                          </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 invoice-col">
                        <strong>Order#:</strong>
                        <address>
                            <?= $header->order_no; ?><br> 
                        </address>
                    </div>
                    <div class="col-sm-3 invoice-col">
                        <strong>Invoice#:</strong>
                        <address>
                            <?= $header->vendor_invoice_no; ?><br> 
                        </address>
                    </div>
                  </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Serial #</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Unit Cost</th>
                                <th>Selling Price</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1;foreach ($details as $item) : ?>
                                <tr>
                                    <td><?=$i;?></td>
                                    <td><?=$item->item_name;?></td>
                                    <td><?=$item->qty;?></td>
                                    <td><?=$item->unit_cost;?></td>
                                    <td><?=$item->selling_price;?></td>
                                    <td><?=$item->amount;?></td>
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
                                    <th>Total:</th>
                                    <td><?= $header->total_amount;?></td>
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
                        <a href="<?=base_url('receivings/sampleLog')?>/<?=$this->uri->segment(3);?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>

                    </div>
                </div>


    </section>




