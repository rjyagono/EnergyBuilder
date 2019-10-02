

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-body">
                <div class="invoice">


                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                             <!-- this row will not appear when printing -->
                                <div class="btn-group">

                                    <?php if($amount->status == STATUS_DRAFT){ ?>
                                 
                                    <button type="button" class="btn btn-default">
                                        <a href="<?= base_url(); ?>index.php/receivings/receive_po/<?=$this->uri->segment(3);?>/PO" ><i class="fa fa-arrow-circle-o-right"></i> Receive All</a>
                                    </button>
                                    <button type="button" class="btn btn-default">
                                          <a href="<?= base_url(); ?>index.php/receivings/receive_partial/<?=$this->uri->segment(3);?>" ><i class="fa fa-arrow-circle-o-right"></i> Partial Receive </a>
                                    </button>
                                      
                                    <?php } ?>
                                </div>


                                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                                  <button type="button" class="btn btn-default"><a href="#"><i class="fa fa-pencil-square-o"></i>Edit</a></button>
                                  <button type="button" class="btn btn-default"><a href="<?=base_url('purchase/invoice_print')?>/<?=$this->uri->segment(3);?>" ><i class="fa fa-print"></i> Print</a></button>
                                  <button type="button" class="btn btn-default"><a href="#" ><i class="fa fa-trash"></i>Delete</a></button>
                                </div>
                        </h2>
                    </div>
                    <!-- /.col -->
                </div>       
 
     <table style="width:100%;table-layout: fixed;">

         <table style="width:100%;margin-top:30px;table-layout:fixed;">
            <tbody><tr>
            <td style="width:55%;vertical-align:bottom;word-wrap: break-word;">
              <div><label style="font-size: 10pt;" id="tmp_billing_address_label" class="pcs-label">Supplier Address:</label>
                <br>
                <span style="white-space: pre-wrap;" id="tmp_billing_address"><strong><span class="pcs-customer-name" id="zb-pdf-customer-detail"><a href="#"><?= $amount->vendor_name ?> 
                </a></span></strong></span>
              </div>           
              <div style="clear:both;width:50%;">
                 <label style="font-size: 10pt;" id="tmp_shipping_address_label" class="pcs-label">Deliver To:</label>
                <br>
                <span style="white-space: pre-wrap;" id="tmp_billing_address"><strong><span class="pcs-customer-name" id="zb-pdf-customer-detail"><a href="#"><?= $amount->warehouse_name ?> 
                </span></strong></span>
              </div>

            </td>
            <td align="right" style="vertical-align:bottom;width: 45%;">
                <table style="float:right;width: 100%;table-layout: fixed;word-wrap: break-word;" border="0" cellspacing="0" cellpadding="0">
                     <tbody>
                         <tr>
                             <td style="text-align:right;padding:5px 10px 5px 0px;font-size:10pt;width:60%;">
                                <label style="font-size: 10pt;" id="tmp_billing_address_label" class="pcs-label">Date :</label>
                            </td>
                            <td style="text-align:right;width:40%;">
                                <span id="tmp_entity_date"><?php echo $amount->purchase_date; ?></span>
                            </td>
                        </tr>

                        <tr>
                             <td style="text-align:right;padding:5px 10px 5px 0px;font-size: 10pt;width:60%;">
                                <label style="font-size: 10pt;" id="tmp_billing_address_label" class="pcs-label">Delivery Date :</label>
                            </td>
                            <td style="text-align:right;width:40%;">
                                <span id="tmp_due_date"><?php echo $amount->delivery_date; ?></span>
                            </td>
                        </tr>

                     </tbody>
                  </table>
            </td>
            </tr>
         </tbody>
    </table>
 
                    <hr/>

                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th> #</th>
                                    <th> Item</th>
                                    <th class="hidden-xs"> Quantity</th>
                                    <th class="hidden-xs"> Unit Cost</th>
                                    <th class="hidden-xs"> Price</th>
                                    <th> Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $n = 1;
                                foreach ($history as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo $n; ?></td>
                                        <td><?php echo $row->item_name; ?></td>
                                        <td class="hidden-xs"><?php echo $row->purchase_qty; ?></td>
                                        <td class=""> <?php echo currency_format($row->purchase_rate); ?></td>
                                        <td class="hidden-xs"> <?php echo currency_format($row->purchase_amount); ?></td>
                                        <td class="hidden-xs"> <?php echo currency_format($row->purchase_rate); ?></td>
                                    </tr>
                                    <?php $n++;
                                } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>


              <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-xs-6">
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6">
                        <div class="table-responsive">
                            <table class="table">
                               <tbody><tr>
                                    <th>Total:</th>
                                    <td><?php echo currency_format($amount->grand_total); ?></td>
                                </tr>
                            </tbody></table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>

                </div>

            </div>
        </div>
    </div>
</div>


