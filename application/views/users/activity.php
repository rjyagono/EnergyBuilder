<?php if ($this->session->flashdata('message')) {
    echo "<div class='alert alert-success'>" . $this->session->flashdata('message') . "</div>";

} ?>

<!-- page start-->

<section class="panel">
    <div class="box-header with-border">
        <h3 class="box-title">Activity History</h3>

<!--         <div class="box-tools pull-right">
            <a href="<?=base_url(); ?>index.php/receivings/addNew" class="btn btn-primary"><i class="fa fa-plus"></i> New Receiving</a>
        </div> -->
    </div>
<div class="panel-body">
<div class="adv-table editable-table table-responsive">
        <table id="example1" class="table table-striped table-hover table-bordered dataTable"
               aria-describedby="editable-sample_info">
            <thead>
            <tr role="row">
                <th>#</th>
                <th>
                    Activity Date
                </th>
                <th>
                    User
                </th>
                <th>
                    Type
                </th>
                <th>
                    Stock In
                </th>
                <th>
                    Stock Out
                </th>
                <th>
                    Remarks
                </th>
                <th>
                    Transaction
                </th>
                <th>InStock Qty</th>
            </tr>
            </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
            <?php foreach ($logs as $log) {   ?>
                <tr>
                  <td><?php echo $log->id; ?></td>
                  <td><?php echo date('d-M-Y',strtotime($log->transaction_date)); ?></td>
                  <td><?php echo $log->created_by; ?></td>
                  <td><?php echo $log->type; ?></td>
                  <td><?php echo $log->stock_in; ?></td>
                  <td><?php echo $log->stock_out; ?></td>
                  <td><?php echo $log->remarks; ?></td>
                    <?php if($log->type == 'SR' || $log->type == 'SR-ST' || $log->type == 'SR-PO'){ ?>
                         <td><a href="<?=base_url();?>receivings/show/<?= $log->transaction_id ?>"><?php echo $log->transaction_id; ?></a></td>
                    <?php }elseif ($log->type == 'PO') { ?>
                        <td><a href="<?=base_url();?>purchase/show/<?= $log->transaction_id ?>"><?php echo $log->transaction_id; ?></a></td>
                    <?php }elseif ($log->type == 'ST') { ?>
                        <td><a href="<?=base_url();?>transfer/show/<?= $log->transaction_id ?>"><?php echo $log->transaction_id; ?></a></td>
                    <?php } else { ?>
                        <td><a href="#"><?php echo $log->transaction_id; ?></a></td>
                    <?php } ?>
                    <td><?php echo $log->quantity; ?></td>
                  
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</section>