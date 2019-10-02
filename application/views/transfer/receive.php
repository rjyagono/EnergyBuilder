<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                From: <?= $header->site1; ?>
                <small class="pull-right">Date: <?= $header->transfer_date; ?></small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->

    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1;foreach ($details as $item) : ?>
                    <tr>
                        <td><?=$item->article_no;?></td>
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

    <!-- this row will not appear when printing -->
    <?php if($header->transfer_status == 0){ ?>
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="<?=base_url();?>receivings/receive_transfer/<?= $header->stock_transfer_id;?>/ST" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i> Mark Received</a>
            </div>
        </div>
    <?php } ?>
</section>




