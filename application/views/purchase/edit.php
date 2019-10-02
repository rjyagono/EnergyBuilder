<?php echo form_open(base_url() . 'index.php/purchase/save_purchase/'.$header->purchase_id, array('method' => 'post')); ?>
<div class="row">
    <div class="col-md-12">

    <div class="right form-group">
    <?php if($header->status == 0){ ?>
        <a href="<?= base_url(); ?>index.php/receivings/receive_po/<?php echo $header->purchase_id ?>/PO" class="label label-primary" style="margin-right: 5px; font-size: 100%;"><i class="glyphicon glyphicon-download-alt"></i>  Receive All</a>
    <?php } ?>
<!--         <a href="/rmo/stocks_receiving/home/receive_items/86" class="label label-primary" style="margin-right: 5px; font-size: 100%;"><i class="glyphicon glyphicon-download-alt"></i>  Receive Items</a> 
        <a href="/rmo/purchase_order/home/printing/86" class="label label-primary" style="font-size: 100%;"><i class="glyphicon glyphicon-print"></i>  Print</a>
        <a href="/rmo/purchase_order/home/close/86" onclick="return confirm('Are you sure you want to Cancel or Close this Purchase Order?');" class="label label-primary" style="margin-right: 10px; font-size: 100%;"><i class="glyphicon glyphicon-remove"></i>  Cancel</a>  -->
    </div>
        <div class="box box-info">
            <div class="box-body">
                <div class="clearfix">
                    <input type="hidden" name="purchase_id" class="form-control input-medium"
                           value="<?php echo $header->purchase_id; ?>"/>


                    <div class="col-md-3">
                        <label>Supplier Name:</label>
                        <select class="form-control input-medium" name="vendor_id" id="vendor_id" required>
                            <option value="">SELECT SUPPLIER</option>
                            <?php foreach ($vendors as $vendor) : ?>
                                <option value="<?php echo $vendor->vendor_id ?>"
                                <?php if ($vendor->vendor_id == $header->vendor_id) : ?> selected<?php endif; ?>>
                                <?php echo $vendor->vendor_name; ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>

                    <div class="col-md-3">

                        <label>Deliver To:</label>
                        <select class="form-control input-medium" name="warehouse_id" id="warehouse_id" required>
                            <option value="">SELECT WAREHOUSE</option>
                            <?php foreach ($warehouses as $warehouse) : ?>
                                <option value="<?php echo $warehouse->warehouse_id ?>"
                                <?php if ($warehouse->warehouse_id == $header->warehouse_id) : ?> selected<?php endif; ?>>
                                    <?php echo $warehouse->warehouse_name; ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <div class="col-md-3">
                        <label>Purchase Date</label>
                        <input type="text" name="purchase_date"
                               class="form-control input-medium datepicker"
                               required="required" value="<?php echo $header->purchase_date; ?>"/>
                    </div>
                    <div class="col-md-3">
                        <label>Expected Delivery Date</label>
                        <input type="text" name="delivery_date"
                               class="form-control input-medium datepicker"
                               required="required" value="<?php echo $header->delivery_date; ?>"/>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="table-responsive">
                    <div style="" id="">

                        <table id="" class="table table-bordered table-striped table-nowrap dataTable" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th>Select Item</th>
                                <th width="15%">Stock/Qty</th>
                                <th width="15%">Quantity</th>
                                <th width="15%">Rate</th>
                                <th width="15%">Total</th>
                                <th width="1%"></th>
                            </tr>
                            </thead>
                            <tbody id="rows-list">

                        <?php  foreach ($details as $detail) {  ?>

                            <tr>
                                <td class="product-list">        
                                    <input type="hidden" name="detail_ids[]" value="<?= $detail->purchase_detail_id; ?>">
                                    <select class="form-control product input-xlarge" name="item_id[]"
                                            onchange="">
                                        <option value="">Add Product</option>
                                        <?php foreach ($products as $row) :
                                            ?>
                                            <option value="<?= $row->item_id; ?>"<?php if ($row->item_id == $detail->item_id) : ?> selected<?php endif; ?>>
                                            <?= $row->item_name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="number" name="av_qtys[]" class="form-control stock" readonly>
                                    <input type="hidden" name="category_id[]" class="form-control category" readonly>
                                </td>
                                <td><input type="number" name="cartons[]" value="<?= $detail->purchase_qty; ?>" class="form-control carton"></td>
                                <td><input type="number" name="rates[]" value="<?= $detail->purchase_rate; ?>" class="form-control rate"></td>
                                <td><input type="number" name="totals[]" value="<?= $detail->purchase_amount; ?>" class="form-control total" readonly></td>
                                <td align="center">
                                    <a href="#" class="label label-danger delete-row" style="font-size: 100%;">
                                    <i class="fa fa-trash"></i> </a>
                                </td>
                            </tr>

                        <?php  } ?>

                            </tbody>
                            <tfoot> 
                            <tr>
                                <td colspan="4" style="text-align:right;">
                                    <strong style="color: inherit;">Grand Total:</strong>
                                </td>
                                <td class="text-right">
                                    <input type="text" id="grand_total" tabindex="" class="form-control"
                                           name="total_amount" value="<?= $header->grand_total; ?>" readonly="readonly">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">
                                  <a class="" href="#" onclick="addPurchaseInputField('rows-list');" >
                                   <i class="fa fa-plus"></i> Add New Item </a>
                                </td>
                                <td colspan="5" style="text-align:right;">
                                    <input type="submit" id="add-invoice" class="btn btn-primary" name="add-invoice"
                                           value="Update Order">
                                    <!-- <input type="submit" id="add-invoice-receive" class="btn btn-primary" name="add-invoice-receive"
                                           value="Order and Receive"> -->
                                </td>
                            </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- end panel -->
    </div>
</div>

</form>
 
<script type="text/javascript">
    $(document).ready(function () {

        var base_url = "<?=base_url()?>";
        // $(".demo-select2-2").select2({
        //     dir:"ltr"
        // });

        var list = $("#rows-list");
        var row = list.children('tr:first');
        $("#add-item").on('click', function (e) {
            e.preventDefault();
            var newRow = row.clone();
            list.append(newRow);
            // $(".demo-select2-2").select2('refresh');
            do_grand_total();
        });

        $(list).on('click', ".delete-row", function () {
            if (list.children("tr").length > 1) {
                $(this).closest('tr').remove();
                do_grand_total();
            } else {
                alert("This row cannot be deleted");
            }
        });

        $(list).on('change', ".product", function () {
            var id = $(this).val();
            var row = $(this).closest('tr');
            var csrf_test_name = $("input[name=csrf_test_name]").val();
            $.ajax({
                type: 'post',
                url: base_url + 'index.php/sales/imran',
                data: {'id': id, 'csrf_test_name': csrf_test_name}
            }).then(function (res) {
                var res = $.parseJSON(res);
                if (res.stock_qty > 0) {
                    row.find(".stock").val(res.stock_qty);
                    row.find(".items-carton").val(res.cart_qty);
                    row.find(".rate").val(res.stock_rate);
                    row.find(".category").val(res.category_id);
                    row.find(".discount").val(0);
                    row.find(".supplier_rate").val(res.supplier_price);
                    row.find(".carton").removeAttr('readonly', 'readonly');
                    row.find(".carton").val(1);
                    do_total(row);
                    do_grand_total();
                }
                else {
                    toastr.warning('quantity is less');
                    row.find(".stock").val('');
                    row.find(".items-carton").val('');
                    row.find(".carton").attr('readonly', 'readonly');
                    row.find(".rate").val('');
                    row.find(".supplier_rate").val('');

                }
            }, function () {
                alert("Sorry cannot get the product details!");
            });
        });

        $(list).on('input propertychange paste', ".carton, .rate, .discount", function () {
            if ($(this).hasClass("carton")) {
                var stock = Number($(this).closest("tr").find(".stock").val());
                if (Number($(this).val()) < 1 || Number($(this).val()) == 0 || Number($(this).val()) == '') {
                    $(this).css({"border": "1px solid red"});
                    toastr.warning("Please provide quantitiy! ");
                } else {
                    $(this).css({"border": "1px solid green"});
                }
            }
            do_total(this);
            do_grand_total();
        });

        $("#paid_amount").on('input propertychange paste', function () {
            do_paid_total(this);
        });

        function do_total(elem) {
            var row = $(elem).closest('tr');
            var carton = Number(row.find(".carton").val());
            // var items = Number(row.find(".items-carton").val());
            var rate = Number(row.find(".rate").val()); 
            //row.find(".quantity").val((carton * items));
            var row_items = (carton);
            var total = (row_items * rate);
            row.find(".total").val(total);
        }

        function do_grand_total() {
            var total = 0;
            var g_discount = 0;
            $(list).find(".total").each(function (e) {
                total += Number($(this).val());
            });
            $(list).find("tr").each(function (e) {
                var discount = Number($(this).find(".discount").val());
                var quantity = Number($(this).find(".carton").val());
                g_discount += Number(discount * quantity);
            });
            //var vat_percentage = Number($("#total_vat").val());

            //total = total + (total * (vat_percentage / 100));
            $("#total_discount").val(g_discount);
            $("#grand_total").val(total);
            $("#due_amount").val(total - Number($("#paid_amount").val()));
        }

        function do_paid_total(row) {
            var paid_amount = Number($(row).val());
            var grand_total = Number($("#grand_total").val());
            $("#due_amount").val(grand_total - paid_amount);
        }

        $("#btn-full-paid").on("click", function (e) {
            e.preventDefault();
            var amount = $("#grand_total").val();
            $("#paid_amount").val(amount);
            $("#due_amount").val(0);

        });

    });
    // Add input field for new Invoice
    var count = 2;
    var limits = 500;
    function addPurchaseInputField(e) {
        var t = $("tbody#rows-list tr:first-child").html();
        count == limits ? alert("You have reached the limit of adding " + count + " inputs") : $("tbody#rows-list").append("<tr>" + t + "</tr>")
    }
</script>
