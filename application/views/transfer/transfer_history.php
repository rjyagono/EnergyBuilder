<?php if ($this->session->flashdata('message'))
    echo $this->session->flashdata('message');
?>
<?php
foreach ($transfer as $results) {

    $id = $results->stock_transfer_id;
    @$custlistRow .= "<tr>
                <td>" . $results->transfer_order_no . "
                <td>" . $results->warehouse_name . "
                <td>" . date('d-M-Y',strtotime($results->transfer_date)) . "
                <td>
                <a href='show_transfer_history/" . $results->stock_transfer_id . "' data-toggle='modal' class='btn btn-success'>
                <i class='fa fa-pencil-square-o'></i>
                                                  Stock Transfer History
                                              </a> </td>
                ";
}
?>
<!-- page start-->

<section class="panel">
    <header class="panel-heading">
        STOCK TRANSFER HISTORY
    </header>
    <div class="panel-body">
        <div class="adv-table editable-table table-responsive">
                <table id="example1" class="table table-striped table-hover table-bordered dataTable"
                       aria-describedby="editable-sample_info">
                    <thead>
                    <tr role="row">
                        <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 184px;"
                            aria-label="Username">Transfer Code
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 269px;" aria-label="Full Name: activate to sort column ascending">
                            Destination
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 123px;" aria-label="Points: activate to sort column ascending">
                            Date
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 127px;" aria-label="Delete: activate to sort column ascending">
                            Details
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    <?php if(!empty($custlistRow)){
                        echo $custlistRow;
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>

</section>