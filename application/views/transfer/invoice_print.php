<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transfer Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url();?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url();?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url();?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url();?>assets/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
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

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">

      </div>
      <!-- /.col -->

    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
