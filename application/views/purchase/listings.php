<?php
foreach ($purchase as $results) {

    $id = $results->purchase_id;
    @$custlistRow .= "<tr>


                <td>" . $results->purchase_id . "
                <td>" . $results->vendor_name . "
                <td>" . date('d-m-Y', strtotime($results->purchase_date)) . "
<td>
<a href='show_purchase_history/" . $results->purchase_id . "' data-toggle='modal' class='btn btn-success'>
<i class='fa fa-pencil-square-o'></i>
                                  View Purchase History
                              </a>
                  </td>
                ";

}
?>
<!-- page start-->
<style>
    .box-header.with-border {
        border-bottom: 1px solid #f4f4f4;
    }
    .box-header-background {
        background-color: #6c7a89;
        color: #fff;
    }
</style>

<section class="panel">
    <header class="panel-heading">
        PURCHASE HISTORY
    </header>
    <div class="panel-body">
        <div class="adv-table editable-table table-responsive">
            <table id="example1" class="table table-striped table-hover table-bordered dataTable"
                       aria-describedby="editable-sample_info">
                    <thead>
                    <tr role="row">
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 123px;" aria-label="Full Name: activate to sort column ascending">
                            Date
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 123px;" aria-label="Full Name: activate to sort column ascending">
                            Purchase Order#
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 269px;" aria-label="Points: activate to sort column ascending">
                            Vendor Name
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 123px;" aria-label="Points: activate to sort column ascending">
                            Status 
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 123px;" aria-label="Points: activate to sort column ascending">
                            Delivery Date
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" style="width: 123px;" aria-label="Points: activate to sort column ascending">
                            Amount 
                        </th>
                    </tr>
                    </thead>


                <tbody  role="alert" aria-live="polite" aria-relevant="all"><!-- / Table body -->

                <?php $i = 1; foreach ($purchase as $result) {
                    $id = $result->purchase_id; ?>
                    <!--get all sub category if not this empty-->
                    <tr  onclick="location.href='show/<?php echo $id; ?>'">
                        <td><?php echo $result->purchase_date; ?></td>
                        <td><?php echo $result->pur_no; ?></td>
                        <td><?php echo $result->vendor_name; ?></td>
                        <td class="highlight-text"><?php echo poStatus($result->status); ?></td>
                        <td><?php echo $result->delivery_date; ?></td>
                        <td><?php echo currency_format($result->grand_total); ?></td>
                    </tr>
                <?php  $i++; } ?>
                </tbody><!-- / Table body -->
            </table>

            <!--<div class="row-fluid">
                <div class="span6">
                    <!--  <div class="dataTables_info" id="hidden-table-info_info">Showing 1 to 10 of 57 entries</div>-->
            <!--</div>
            <div class="span6">
                <div class="dataTables_paginate paging_bootstrap pagination">
                    <ul>
                        <!--<li class="prev disabled"><a href="#">← Previous</a></li>-->
            <!--<li class="active"><a href="#"><?php //echo $this->pagination->create_links(); ?>
                                </a></li>

                        </ul>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
</section>