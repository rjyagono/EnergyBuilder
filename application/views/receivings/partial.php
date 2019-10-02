<section class="panel">
    <header class="panel-heading">
        New Purchase Receive
    </header>
    <div class="panel-body">
        <div class="adv-table editable-table table-responsive">
        	<?php echo form_open(base_url() . 'index.php/receivings/receive_partial_po', array('method' => 'post')); ?>
        		<input type="hidden" name="id" value="<?= $this->uri->segment(3); ?>">
				<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
					<th width="1%"><nobr>Item Code</nobr></th>
					<th style="text-align:left"><nobr>Description</nobr></th>
					<th width="1%"><nobr>Ordered</nobr></th>
					<th width="1%"><nobr>Received</nobr></th>
					<th width="1%"><nobr>Remaining</nobr></th>
					<th width="1%"><nobr>Unit Cost</nobr></th>
					<th width="1%"><nobr>Qty to Receive</nobr></th>
				</tr></thead>
				<tbody>
				<?php  foreach ($details as $detail) {  ?>
					<tr style="background-color: #fff; color: ">
						<td>
							<input type="hidden" name="item_ids[]" value="<?= $detail->item_id; ?>">
							<input type="hidden" name="detail_ids[]" value="<?= $detail->purchase_detail_id; ?>">
							<nobr> <?= $detail->item_name; ?>	</nobr></td>
						<td><nobr></nobr></td>
						<td align="right"><nobr><?= $detail->purchase_qty; ?></nobr></td>
						<td align="right"><nobr><?= $detail->receive_qty; ?></nobr></td>
						<td align="right"><nobr><?= ($detail->purchase_qty - $detail->receive_qty); ?></nobr></td>
						<td align="right"><nobr>&nbsp; <input name="price[]" type="text" id="price[]" value="<?= $detail->purchase_rate; ?>" class="text3 aright"> </nobr></td>
						<td align="right"><nobr>&nbsp; <input name="qty_received[]" type="text" id="qty_received[]" value="<?= $detail->purchase_qty; ?>" class="text2 aright"> </nobr></td>
					</tr>
				<?php  } ?>
				<tr>
					<td colspan="3" align="left"><label>Notes: (For Internal Use)</label></td>
					<td colspan="3" align="right"><b>Receive Date:</b></td>
					<td><input name="receive_date" type="text" id="receive_date" value="" class="form-control datepicker"></td>
				</tr>

				<tr>
					<td colspan="3" align="left"><textarea name="reason" rows="2" class="form-control"></textarea></td>
					<td colspan="3" align="right"><b>Supplier Invoice Number: (for Reference)</b></td>
					<td><input name="vendor_invoice_no" type="text" id="vendor_invoice_no" value="" class="form-control"></td>
				</tr>
				</tbody>
				</table>

				<div class="btn-toolbar"> 
					<input type="submit" id="add-invoice" class="btn btn-primary" name="add-invoice"
	                                           value="Receive">
					<button class="btn btn-default">Cancel</button>
				</div>
			</form>
        </div>
    </div>
</section>