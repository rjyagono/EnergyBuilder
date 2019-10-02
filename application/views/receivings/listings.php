<?php if ($this->session->flashdata('message')) {
    echo "<div class='alert alert-success'>" . $this->session->flashdata('message') . "</div>";

} ?>

<!-- page start-->

<section class="panel">
    <div class="box-header with-border">
        <h3 class="box-title">Stock Receiving</h3>

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
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 269px;" aria-label="Full Name: activate to sort column ascending">
                            Invoice#
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 269px;" aria-label="Full Name: activate to sort column ascending">
                            PO#
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 123px;" aria-label="Points: activate to sort column ascending">
                            Vendor Name
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 123px;" aria-label="Points: activate to sort column ascending">
                            Status 
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 123px;" aria-label="Points: activate to sort column ascending">
                            Date
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 123px;" aria-label="Points: activate to sort column ascending">
                            Total Amount 
                        </th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 184px;"
                            aria-label="Username">
                            Processed By
                        </th>

                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    <?php foreach ($receivings as $result) {
                            $id = $result->id;  ?>
                        <tr onclick="location.href='show/<?php echo $result->id; ?>'">
                          <td><?php echo $result->vendor_invoice_no; ?></td>
                          <td><?php echo $result->order_no; ?></td>
                          <td><?php echo $result->vendor_name; ?></td>
                          <td class="highlight-text"><?php echo poStatus($result->status); ?></td>
                          <td><?php echo date('d-M-Y',strtotime($result->created_at)); ?></td>
                          <td><?php echo currency_format($result->total_amount); ?></td>
                          <td><?php echo $result->created_by; ?></td>
<!--                           <td>
                            <a href="receivings/<?= $result->id ?>" data-toggle='modal' class='btn btn-success'>
                              <i class='fa fa-pencil-square-o'></i> Preview </a> 
                          </td> -->
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

</section>