<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <div class="box light bordered">
            <div class="box-header with-border">
                <div class="page-header">
                    <h3> List of Sites 
                        <div class="pull-right">
                            <a href="#myModal-1" data-toggle='modal' class='btn btn-info'><i class="glyphicon glyphicon-plus"></i> Add New </a>
                        </div>
                    </h3>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped table-hover table-bordered dataTable" id="example1"
                       aria-describedby="editable-sample_info">
                    <thead>
                    <tr role="row">
                        <th>
                            NAME
                        </th>
                        <th>
                            ADDRESS
                        </th>
                        <th>
                            PHONE NO
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>

                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    <?php $i=1;
                    foreach ($warehouses as $warehouse) {

                        $id = $warehouse->warehouse_id;
                        ?>
                        <tr class='odd'>

                            <td><?php echo $warehouse->warehouse_name ?></td>
                            <td><?php echo $warehouse->address ?></td>
                            <td><?php echo $warehouse->phone_no ?></td>
                            <td>
                                <a href='#myModal<?= $warehouse->warehouse_id; ?>' data-toggle='modal'
                                   class='btn btn-warning' <?php echo $My_Controller->editPermission;?>
                                ><i class='fa fa-pencil-square-o'></i>
                                </a>
                            </td>
                        </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!--Modal for Edit -->


<?php foreach ($warehouses as $rows): ?>

    <div class="modal fade" id="myModal<?php echo $rows->warehouse_id; ?>" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">UPDATE WAREHOUSE</h4>
                </div>
                    <?php $attributes = array('class' => 'form-horizontal group-border hover-stripped', 'id' => 'commentForm', 'method' => 'post');
                    echo form_open('warehouses/update_warehouse', $attributes); ?>
                    <div class="modal-body">

                        <div class='form-group'>
                            <label for='inputEmail1' class='col-lg-3 col-sm-3 control-label'>WAREHOUSE
                                NAME</label>
                            <div class='col-lg-9'>
                                <input class="form-control" type="hidden" name="wid"
                                       value="<?= $rows->warehouse_id; ?>">

                                <input class="form-control" type="text" name="warehouse_name" value="<?= $rows->warehouse_name; ?>">
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Address</label>

                            <div class='col-lg-9'>
                                <input type='text' name="address" class='form-control'
                                       value="<?= $rows->address?>" id='c_address'
                                       placeholder=''>
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>PHONE NO</label>

                            <div class='col-lg-9'>
                                <input class="form-control" type="text" name="phone_no" value="<?= $rows->phone_no; ?>">

                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                        <?php echo $My_Controller->savePermission;?>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<?php endforeach; ?>

<!--Modal for Edit ends-->


<!--Modal for ADD -->
<div class="row">
    <div class="col-lg-6">

        <section class="panel">
            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
                 id="myModal-1"
                 class="modal fade" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title">ADD WAREHOUSE</h4>
                        </div>
                            <?php $attributes = array('class' => 'form-horizontal group-border hover-stripped', 'id' => 'commentForm', 'method' => 'post');
                            echo form_open('warehouses/insert_warehouse', $attributes); ?>
                        <div class="modal-body modal-edit">

                                <div class='form-group'>
                                    <label for='inputEmail1' class='col-lg-3 col-sm-3 control-label'>WAREHOUSE NAME</label>
                                    <div class='col-lg-9'>
                                        <input type='hidden' name="cid" class='form-control' id='c_' value=''>
                                        <input type='text' name="warehouse_name" class='form-control' id='c_name'
                                               value=''>
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Address</label>

                                    <div class='col-lg-9'>
                                        <input type='text' name="address" class='form-control'
                                               value="" id='address'
                                               placeholder=''>
                                    </div>
                                </div>
                                <div class='form-group'>
                                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>PHONE NO</label>

                                    <div class='col-lg-9'>
                                        <input type='text' name="phone_no" class='form-control'
                                               value="" id='c_cell'>
                                    </div>
                                </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                            <?php echo $My_Controller->savePermission;?>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
<!--Modal for ADD ends-->


<!-- page end-->

