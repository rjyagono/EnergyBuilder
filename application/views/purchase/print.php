

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-body">
                <div class="invoice">
 
     <table style="width:100%;table-layout: fixed;">
           <tbody>
             <tr>
               <td style="vertical-align: top; width:50%;">
                 <div>
                </div>
                <span class="pcs-orgname"><b><?= $title ?></b></span><br>
                <span class="pcs-label">
                  <span style="white-space: pre-wrap;word-wrap: break-word;" id="tmp_org_address">Philippines</span>
                </span>           </td>
               <td style="vertical-align: top; text-align:right;width:50%;">
                 <span class="pcs-entity-title">PURCHASE ORDER</span><br>
                 <span id="tmp_entity_number" style="font-size: 10pt;" class="pcs-label"><b># <?php echo $amount->pur_no ?></b></span>
                 <div style="clear:both;margin-top:20px;">
                 </div>
              </td>
             </tr>
           </tbody>
          </table>

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
                                foreach ($history as $rows) {
                                    ?>
                                    <tr>
                                        <td><?php echo $n; ?></td>
                                        <td><?php echo $rows->item_name; ?></td>
                                        <td class="hidden-xs"><?php echo $rows->purchase_qty; ?></td>
                                        <td class="">₱ <?php echo $rows->purchase_rate; ?></td>
                                        <td class="hidden-xs">₱ <?php echo $rows->purchase_amount; ?></td>
                                        <td class="hidden-xs">₱ <?php echo $rows->purchase_rate; ?></td>
                                    </tr>
                                    <?php $n++;
                                } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="well">
                                <address>
                                    <strong>Bill To: <br/><?=$company->name;?></strong>
                                    <br/> <?=$company->address;?>
                                    <br/>
                                    <abbr title="Phone">P:</abbr> <?=$company->contact;?>
                                </address>
                                <address>
                                    <strong><?=$company->name;?></strong>
                                    <br/>
                                    <a href="mailto:#"> <?=$company->email;?> </a>
                                </address>
                            </div>
                        </div>
                        <div class="col-xs-8 invoice-block">
                            <ul class="list-unstyled amounts">
                                <li>
                                    <strong>Sub - Total:</strong> ₱ <?= $amount->grand_total ?> </li>
                                <li>
                                    <strong>Discount:</strong> <?= $amount->purchase_discount ?>%
                                </li>
                                <li>
                                    <strong>VAT:</strong> -----
                                </li>
                                <li>
                                    <strong>Grand Total:</strong> ₱ <?= $amount->grand_total ?> </li>
                            </ul>
                            <br/>
                            <a class="btn btn-lg btn-primary hidden-print margin-bottom-5"
                               onclick="javascript:window.print();"> Print
                                <i class="fa fa-print"></i>
                            </a>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>


