<section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                             <!-- this row will not appear when printing -->
                                <div class="btn-group">

                                    <?php if($header->transfer_status == STATUS_INTRANSIT){ ?>
                                 
                                            <div class="col-xs-6">
                                                <a href="#myModal1" data-toggle='modal' class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i> Mark Received</a>
                                            </div>
                                      
                                    <?php } ?>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                  <button type="button" class="btn btn-default"><a href="#"><i class="fa fa-pencil-square-o"></i>Edit</a></button>
                                  <button type="button" class="btn btn-default"><a href="<?=base_url('transfer/invoice_print')?>/<?=$this->uri->segment(3);?>" target="_blank" ><i class="fa fa-print"></i> Print</a></button>
                                  <button type="button" class="btn btn-default"><a href="#" ><i class="fa fa-trash"></i>Delete</a></button>
                                </div>
                        </h2>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                  <div class="row invoice-info">
                    <div>
                      <br><center><b>STOCK TRANSFER RECEIPT</b></center><br>
                    </div>
                    <div class="col-sm-3 invoice-col">
                          <strong>From:</strong>
                          <address>
                              <?= $header->site1; ?><br>
                              <?= $header->site1_address; ?><br> 
                          </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 invoice-col">
                        <strong>To:</strong>
                        <address>
                            <?= $header->site2; ?><br>
                            <?= $header->site2_address; ?><br> 
                        </address>
                    </div>
                    <div class="col-sm-3 invoice-col">
                        <strong>Order#:</strong>
                        <address>
                            <?= $header->transfer_order_no; ?><br> 
                        </address>
                    </div>
                    <div class="col-sm-3 invoice-col">
                        <strong>Date:</strong>
                        <address>
                            <?= $header->transfer_date; ?><br> 
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
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1;foreach ($details as $item) : ?>
                                <tr>
                                    <td><?=$i;?></td>
                                    <td><?=$item->item_name;?></td>
                                    <td><?=$item->transfer_qty;?></td>
                                    <td><?=$item->transfer_rate;?></td>
                                    <td><?=$item->transfer_totals;?></td>
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
                                    <td><?= $header->transfer_total_amount;?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

    </section>



<!--------------------------------------barcode---------------------------------->


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal1" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Choose the received date</h4>
            </div>
            <div class="modal-body modal-edit" id="itemBar">
                <?php $attributes = array('class' => 'form-horizontal group-border hover-stripped','method' => 'post');
                    echo form_open('transfer/process_transfer', $attributes); ?>

                    <div class="modal-body"> 
                        <div class="form-group">
                            <label class="control-label col-md-5 required">Receive Date</label> 
                            <div class="col-md-6"> 
                                <input name="receive_date" class="form-control datepicker" type="text" data-dropdown-opened="true"> 
                                <input name="stock_transfer_id" value="<?= $header->stock_transfer_id; ?>" type="hidden"> 
                                <input name="transfer_status" value="<?= STATUS_TRANSFERED ?>" type="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> 
                        <button class="btn btn-primary" type="submit"> Save </button> 
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<!------------------------------------------------------------------------------->
