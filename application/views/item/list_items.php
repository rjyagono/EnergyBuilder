    <div class="row">
        <div class="col-xs-12">
            <div class="box box-default">
                <div class="page-header">
                    <h3> List of Items 
                        <div class="pull-right">
                          <a href="#myModal-1" data-toggle='modal' class='btn btn-alert'><i class="glyphicon glyphicon-plus"></i> Add New </a>
                        </div>
                    </h3>
                </div>
                <div class="box-body">

                    <table class="table table-striped table-hover table-bordered dataTable" id="example1"
                           aria-describedby="editable-sample_info">
                        <thead>
                        <tr role="row">
                    <!--   <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                BAR CODE
                            </th> -->
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                CODE
                            </th>
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                ITEM NAME
                            </th>

                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                CATEGORY
                            </th>
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Unit
                            </th>
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                STOCK ON HAND
                            </th>
                            <th class="sorting_disabled" role="columnheader" tabindex="0"
                                aria-controls="editable-sample"
                                rowspan="1"
                                colspan="1" aria-label="Delete: activate to sort column ascending">
                                Action
                            </th>
                        </tr>
                        </thead>

                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                        <?php foreach ($items as $item) { ?>
                        <tr class='odd'>
                            <td><?php echo $item->article_no?></td>
                            <td><?php echo $item->item_name?></td>
                            <td><?php echo $item->category_name?></td>
                            <td><?php echo $item->unit?></td>
                            <td><?php if($item->stock_qty > $item->stock_limit){ 
                                    echo '<span class="label label-success">'.$item->stock_qty.'</span>';}
                                else{
                                    echo '<span class="label label-danger">'.$item->stock_qty.'</span>';
                                }?>
                            </td> 
                            <td>
                            <div class="btn-group">
                                <a href='#myModal<?php echo $item->item_id?>' <?php echo $My_Controller->editPermission;?>
                                   data-toggle='modal' class='btn btn-xs btn-default'><i class='fa fa-pencil'></i>
                                </a>
                                <a href='<?php echo base_url(). "item/price_history/$item->item_id"; ?>' class="btn btn-xs bg-olive"><i class="glyphicon glyphicon-usd"></i></a>
                                 <!--  <a href="#" class="btn btn-xs btn-danger"  onclick="return confirm('Are you sure want to delete this record ?');"><i class="glyphicon glyphicon-trash"></i></a> -->
                            </div>
                            </td>

                        <?php } ?>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

</section>


<script>
    function get_items(id) {
        var csrf_test_name = $("input[name=csrf_test_name]").val();
        $.ajax({
            url: '<?=base_url();?>index.php/item/get_items/',
            type: 'POST',
            data: {'id': id, 'csrf_test_name': csrf_test_name},
            dataType: 'html',
            success: function (response) {
                //console.log(response.category_id);

                $('#itemBar').html(response);
                //$('#purchase_entry_holder').html(response);
                $("#barcode").val('');
                $("#barcode").focus();


            }
        });
    }
</script>
<!-- page start-->

<!--Modal for Edit -->
<?php foreach ($items as $rows): ?>
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1"
         id="myModal<?php echo $rows->item_id; ?>"
         class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Edit Item</h4>
                </div>

                <?= form_open_multipart(base_url() . 'item/update_item', array('method' => 'POST', 'class' => 'form-horizontal', 'id' => 'myform')) ?>
                <div class="modal-body modal-edit">

                    <div class='form-group'>
                        <label for='inputEmail1' class='col-lg-3 col-sm-3 control-label required'>Item Name*</label>

                        <div class='col-lg-9'>
                            <input type='hidden' name="cid" class='form-control'
                                   value='<?php echo $rows->item_id; ?>'>
                            <input type='text' name="item_name" class='form-control' id='c_name'
                                   value='<?php echo $rows->item_name; ?>'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label required'>Item Code*</label>

                        <div class='col-lg-9'>
                            <input type='text' name="article_no" class='form-control'
                                   value="<?php echo $rows->article_no; ?>" id='c_cell'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Description</label>

                        <div class='col-lg-9'>
                            <input type='text' name="description" class='form-control'
                                   value="<?php echo $rows->description; ?>" id='c_cell'>
                        </div>
                    </div>
<!--                     <div class='form-group'>
                        <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Size</label>

                        <div class='col-lg-9'>
                            <input type='text' name="size" class='form-control'
                                   value="<?php echo $rows->size; ?>" id='c_cell'>
                        </div>
                    </div> -->
<!--                     <div class='form-group'>
                        <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>COLOR</label>

                        <div class='col-lg-9'>
                            <input type='text' name="color" class='form-control'
                                   value="<?php echo $rows->color; ?>" id='c_cell'>
                        </div>
                    </div> -->
<!--                     <div class='form-group'>
                        <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>FLAG</label>

                        <div class='col-lg-9'>
                            <input type='text' name="fax_no" class='form-control'
                                   value="<?php echo $rows->flag; ?>" id='c_address'
                                   placeholder=''>
                        </div>
                    </div> -->

                    <div class='form-group'>
                        <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Purchase Price(PHP)</label>

                        <div class='col-lg-9'>
                            <input type='text' name="purchase_rate" class='form-control'
                                   value="<?php echo $rows->purchase_rate; ?>" id='c_address'
                                   placeholder=''>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Selling Price(PHP)</label>

                        <div class='col-lg-9'>
                            <input type='text' name="stock_rate" class='form-control'
                                   value="<?php echo $rows->stock_rate; ?>" id='c_address'
                                   placeholder=''>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label class='col-lg-3 col-sm-3 control-label required'>Category*</label>

                        <div class='col-lg-9'>
                            <select required="required" name="category_id" class="form-control">
                                <option value="<?= $rows->category_id; ?>"><?= $rows->category_name; ?></option>
                                <?php foreach ($category as $item) { ?>
                                    <option value="<?= $item->category_id; ?>"><?= $item->category_name; ?></option>
                                <?php } ?>
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cname" class="control-label col-lg-3 required">Unit of Measure* </label>

                        <div class="col-lg-6">
                            <select required="required" class="form-control" name="unit" id="">
                                <option value="0">Select Unit</option>
                                <?php foreach ($units as $unit ): ?>
                                    <option
                                        value="<?php echo $unit; ?>" <?php echo ($rows->unit == $unit) ? ' selected="selected"' : ''; ?> ><?php echo $unit ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Reorder Level</label>

                        <div class='col-lg-9'>
                            <input type='text' name="stock_limit" class='form-control'
                                   value="" id=''
                                   placeholder=''>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type='submit' class='btn btn-primary'>Update</button>
                    <button type="button" class="btn dark btn-default" data-dismiss="modal">Cancel</button>
                </div>
                <?= form_close(); ?>


            </div>
        </div>
    </div>
<?php endforeach; ?>

<!--------------------------------------barcode---------------------------------->


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal1" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">PRINT BARCODE</h4>
            </div>
            <div class="modal-body modal-edit" id="itemBar">


            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>


<!------------------------------------------------------------------------------->

<!--Modal for ADD -->


<div class="modal fade" id="myModal-1" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">New Item</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/item/insert_item', array('method' => 'POST', 'class' => 'form-horizontal')) ?>

            <div class="modal-body">

                <div class='form-group'>
                    <label for='inputEmail1' class='col-lg-3 col-sm-3 control-label required'>Item Name*</label>
                    <div class='col-lg-9'>
                        <input type='hidden' name="cid" class='form-control' id='c_' value=''>
                        <input type='text' name="item_name" class='form-control' id='c_name'
                               value=''>
                    </div>
                </div>

                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label required'>Item Code*</label>

                    <div class='col-lg-9'>
                        <input type='text' name="article_no" class='form-control'
                               value="" id=''>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Description</label>

                    <div class='col-lg-9'>
                        <input type='text' name="description" class='form-control'
                               value="" id=''>
                    </div>
                </div>
<!--                 <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>SIZE</label>

                    <div class='col-lg-9'>
                        <input type='text' name="size" class='form-control'
                               value="" id='c_cell'>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>COLOR</label>

                    <div class='col-lg-9'>
                        <input type='text' name="color" class='form-control'
                               value="" id=''
                               placeholder=''>
                    </div>
                </div> -->
<!-- 
                <div class='form-group' style="display:none">
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>QR CODE</label>

                    <div class='col-lg-9'>
                        <input type='text' name="qrCode" class='form-control'
                               value="" id=''
                               placeholder=''>
                    </div>
                </div>  -->

                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Purchase Price(PHP)</label>

                    <div class='col-lg-9'>
                        <input type='text' name="purchase_rate" class='form-control'
                               value="" id=''
                               placeholder=''>
                    </div>
                </div>


                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Selling Price(PHP)</label>

                    <div class='col-lg-9'>
                        <input type='text' name="stock_rate" class='form-control'
                               value="" id=''
                               placeholder=''>
                    </div>
                </div>

                <div class="form-group">
                    <label for="cname" class="control-label col-lg-3 required">Category* </label>

                    <div class="col-lg-6">
                        <select required="required" class="form-control" name="category_id" id="">
                            <option value="0">Select Category</option>
                            <?php foreach ($category as $rows): ?>
                                <option
                                    value="<?php echo $rows->category_id; ?>"><?php echo $rows->category_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cname" class="control-label col-lg-3 required">Unit of Measure* </label>

                    <div class="col-lg-6">
                        <select required="required" class="form-control" name="unit" id="">
                            <option value="0">Select Unit</option>
                            <?php foreach ($units as $unit ): ?>
                                <option
                                    value="<?php echo $unit; ?>"><?php echo $unit ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Opening Stock</label>

                    <div class='col-lg-9'>
                        <input type='text' name="stock_qty" class='form-control'
                               value="" id=''
                               placeholder=''>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Reorder Level</label>

                    <div class='col-lg-9'>
                        <input type='text' name="stock_limit" class='form-control'
                               value="" id=''
                               placeholder=''>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
