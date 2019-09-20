<script type="text/javascript">
    function PrintDivold() {
        var divToPrint = document.getElementById('printableArea');
        var popupWin = window.open('', '_blank', 'width=300,height=300');
        popupWin.document.open();
        popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
    }

    function PrintDivold(printableArea) {


        //$('#dataTables-example').attr('id','none');
        var printContents = document.getElementById('printableArea').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        //$('table').attr('id','dataTables-example');
        location.reload(document.body.innerHTML = originalContents);
        //document.body.innerHTML = originalContents;
    }


    function PrintDiv() {
        var divToPrint = document.getElementById('printableArea');

        var popupWin = window.open('', '_blank', 'width=750,height=600');
        popupWin.document.open();
        popupWin.document.write('<html><head>');
        popupWin.document.write('<html><style type="text/css" media="print">@page { size:4.5in 11in; margin: 2cm; width: 25mm;height: 97mm;  #invoice h1 {font-size: 6.0em; color: red;} }</style><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
        popupWin.document.close();
    }
</script>


    <section class="invoice">


                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-globe"></i> <?=$title ?>
                            <small class="pull-right">Date: <?= $header->transfer_date; ?></small>
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
                        <strong>Customer:</strong>
                        <address>
                            <?= $header->customer_name; ?><br> 
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
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1;foreach ($details as $item) : ?>
                                <tr>
                                    <td><?=$i;?></td>
                                    <td><?=$item->item_name;?></td>
                                    <td><?=$item->transfer_qty;?></td>
                                </tr>
                                <?php $i++; endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-xs-12">
                        <a href="<?=base_url('transfer/invoice_print')?>/<?=$this->uri->segment(3);?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>

                    </div>
                </div>


    </section>




