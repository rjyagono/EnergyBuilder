<?php if ($this->session->flashdata('message')) {
    echo "<div class='alert alert-success'>" . $this->session->flashdata('message') . "</div>";

} ?>

<!-- page start-->

<section class="panel">
    <header class="panel-heading">
        TRANSFER ORDERS
    </header>
    <div class="panel-body">
        <div class="adv-table editable-table table-responsive">
                <table id="example1" class="table table-striped table-hover table-bordered dataTable"
                       aria-describedby="editable-sample_info">
                    <thead>
                    <tr role="row">
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 123px;" aria-label="Points: activate to sort column ascending">
                            Date
                        </th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 184px;"
                            aria-label="Username">Transfer Order#
                        </th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 184px;"
                            aria-label="Username">Reason
                        </th>
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 184px;"
                            aria-label="Username">Status
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 269px;" aria-label="Full Name: activate to sort column ascending">
                            Source Warehouse
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 269px;" aria-label="Full Name: activate to sort column ascending">
                            Destination Warehouse
                        </th>

                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 123px;" aria-label="Points: activate to sort column ascending">
                            Total
                        </th>

                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    <?php  
                        foreach ($transfers as $result) {
                            $id = $result->stock_transfer_id;  ?>
                        <tr onclick="location.href='show/<?php echo $result->stock_transfer_id; ?>'">
                          <td><?php echo date('d-M-Y',strtotime($result->transfer_date)); ?></td>
                          <td><a href="receive/<?php echo $result->stock_transfer_id; ?>">
                              <?php echo $result->transfer_order_no; ?></a></td>
                          <td>
                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="<?php echo $result->reason; ?>">
                              <i class='fa fa-pencil-square-o'></i>
                            </span>
                          </td>
                          <td class="highlight-text"><?php echo poStatus($result->transfer_status); ?></td>
                          <td><?php echo $result->site1; ?></td>
                          <td><?php echo $result->site2; ?></td>
                          <td><?php echo $result->transfer_total_amount; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

</section>