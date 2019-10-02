 <!-- page start-->
<section class="panel">
    <header class="panel-heading">
        STOCK LIST
    </header>
    <?php if ($this->session->flashdata('msg'))
        echo $this->session->flashdata('msg');
    ?>
    <div class="panel-body">

        <div class="adv-table editable-table table-responsive">
            <div class="space15"></div>
            <div id="editable-sample_wrapper" class="dataTables_wrapper form-inline" role="grid">

               <table class="table table-striped table-hover table-bordered dataTable">
                 <tr>
                   <td>
                    <select id='searchByWarehouse' name="warehouse_id" class="form-control">
                        <option value=''>Select Warehouse</option>
                        <?php foreach ($warehouses as $rows): ?>
                            <option
                                value="<?php echo $rows->warehouse_id; ?>"><?php echo $rows->warehouse_name ?></option>
                        <?php endforeach; ?>

                    </select>
                   </td>
                 </tr>
               </table>

                <table class="table table-striped table-hover table-bordered dataTable" id="dataTable1"
                       aria-describedby="editable-sample_info">
                    <thead>
                    <tr role="row">
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" aria-label="Full Name: activate to sort column ascending">
                            ITEM CODE
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" aria-label="Full Name: activate to sort column ascending">
                            ITEM
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" aria-label="Full Name: activate to sort column ascending">
                            CATEGORY
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" aria-label="Full Name: activate to sort column ascending">
                            QUANTITY
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" aria-label="Full Name: activate to sort column ascending">
                            UNIT COST
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" aria-label="Full Name: activate to sort column ascending">
                            STOCK RATE
                        </th>
                <!--    <th class="sorting" role="columnheader" tabindex="0" aria-controls="editable-sample" rowspan="1"
                            colspan="1" aria-label="Delete: activate to sort column ascending">
                            ACTION
                        </th> -->
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</section>
 

 