<?php
    $language = ['en', 'de', 'nl'];
?>
<!-- start of create form -->
<?php if($views_page == 'create'):?>
<div class="col-md-6">
    <label class="small mb-1">Supplier</label>
    <select name="supplier_code" id="supplier_code" class="form-control" required>
        <?php foreach($sellers as $seller):?>
        <option value="<?php echo $seller['seller_code'];?>"><?php echo $seller['name'];?></option>
        <?php endforeach;?>
    </select>
</div>
<div class="col-md-6">
    <label class="small mb-1">Buyer</label>
    <select name="buyer_code" id="buyer_code" class="form-control" required>
        <?php foreach($buyers as $buyer):?>
        <option value="<?php echo $buyer['buyer_code'];?>"><?php echo $buyer['name'];?></option>
        <?php endforeach;?>
    </select>
</div>
<div class="col-md-9">
    <label class="small mb-1">Invoice Reference</label>
    <input type="text" name="invoice_external_reference_id" class="form-control" value="<?= $factoring['invoice_external_reference_id'] ?? $invoice_external_reference_id ?>" readonly required>
</div>
<div class="col-md-3">
    <label class="small mb-1">Language</label>
    <select name="language" id="language" class="form-control" required>
        <?php foreach($language as $lang):?>
            <option value="<?= $lang ?>"><?= $lang ?></option>
        <?php endforeach;?>
    </select>
</div>
<div class="col-md-6">
    <label class="small mb-1">Payment Method</label>
    <select name="payment_method" id="payment_method" class="form-control" required>
        <option value="invoice">Invoice</option>
    </select>
</div>
<div class="col-md-6">
    <label class="small mb-1">Invoice Issued At</label>
    <input type="datetime-local" name="invoice_issued_at" class="form-control" value="<?= $factoring['invoice_issued_at'] ?? ''?>" required>
</div>
<div class="col-md-3">
    <label class="small mb-1">Total Discount (Cents)</label>
    <input type="number" name="total_discount_cents" id="total_discount_cents" class="form-control" value="<?= $factoring['total_discount_cents'] ?? ''?>" required>
</div>
<div class="col-md-3">
    <label class="small mb-1">Gross Amount (Cents)</label>
    <input type="number" name="gross_amount_cents" id="gross_amount_cents" class="form-control" value="<?= $factoring['gross_amount_cents'] ?? ''?>" required>
</div>
<div class="col-md-3">
    <label class="small mb-1">Currency</label>
    <select name="currency" id="currency" class="form-control" required>
        <option value="EUR">EUR</option>
    </select>
</div>
<div class="col-md-3">
    <label class="small mb-1">Net Term</label>
    <input type="number" name="net_term" class="form-control" value="<?= $factoring['net_term'] ?? ''?>" required>
</div>
<?php endif;?>
<!-- end of create form -->
<!-- start of edit form -->
<?php if($views_page == 'edit'):?>
    <div class="col-md-6">
    <label class="small mb-1">Supplier</label>
    <select name="supplier_code" id="supplier_code" class="form-control" required>
        <?php foreach($sellers as $seller):?>
        <option value="<?php echo $seller['seller_code'];?>"><?php echo $seller['name'];?></option>
        <?php endforeach;?>
    </select>
</div>
<div class="col-md-6">
    <label class="small mb-1">Buyer</label>
    <select name="buyer_code" id="buyer_code" class="form-control" required>
        <?php foreach($buyers as $buyer):?>
        <option value="<?php echo $buyer['buyer_code'];?>"><?php echo $buyer['name'];?></option>
        <?php endforeach;?>
    </select>
</div>
<div class="col-md-9">
    <label class="small mb-1">Invoice Reference</label>
    <input type="text" name="invoice_external_reference_id" class="form-control" value="<?= $factoring['invoice_external_reference_id'] ?? $invoice_external_reference_id ?>" readonly required>
</div>
<div class="col-md-3">
    <label class="small mb-1">Language</label>
    <select name="language" id="language" class="form-control" required>
        <?php foreach($language as $lang):?>
            <option value="<?= $lang ?>"><?= $lang ?></option>
        <?php endforeach;?>
    </select>
</div>
<div class="col-md-6">
    <label class="small mb-1">Payment Method</label>
    <select name="payment_method" id="payment_method" class="form-control" required>
        <option value="invoice">Invoice</option>
    </select>
</div>
<div class="col-md-3">
    <label class="small mb-1">Total Discount (Cents)</label>
    <input type="number" name="total_discount_cents" class="form-control" value="<?= $factoring['total_discount_cents'] ?? ''?>" required>
</div>
<div class="col-md-3">
    <label class="small mb-1">Gross Amount (Cents)</label>
    <input type="number" name="gross_amount_cents" class="form-control" value="<?= $factoring['gross_amount_cents'] ?? ''?>" required>
</div>
<div class="col-md-6 mb-2">
    <label class="small mb-1">Currency</label>
    <select name="currency" id="currency" class="form-control" required>
        <option value="EUR">EUR</option>
    </select>
</div>
<div class="col-md-6">
    <label class="small mb-1">Net Term</label>
    <input type="number" name="net_term" class="form-control" value="<?= $factoring['net_term'] ?? ''?>" required>
</div>
<div class="col-md-12 mx-auto mt-2">
    <div class="card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Billing Address</h6>
        </div>
        <div class="card-body row g-3">
            <?php $except_fields = ['id', 'buyer_id', 'type', 'status', 'created_at', 'updated_at'];?>
            <?php foreach($buyer_address_billing[0] as $key => $value):?>
            <?php if(!in_array($key, $except_fields)):?>
            <div class="col-md-4">
                <label class="small mb-1" for="<?php echo $key;?>"><?php echo ucfirst($key);?></label>
                <input type="text" name="<?php echo $key;?>" class="form-control" value="<?php echo $value;?>" required readonly>
            </div>
            <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>
</div>
<div class="col-md-12 mt-2">
    <div class="card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Shipping Address</h6>
        </div>
        <div class="card-body row g-3">
            <?php $except_fields = ['id', 'buyer_id', 'type', 'status', 'created_at', 'updated_at'];?>
            <?php foreach($buyer_address_shipping[0] as $key => $value):?>
            <?php if(!in_array($key, $except_fields)):?>
            <div class="col-md-4">
                <label class="small mb-1" for="<?php echo $key;?>"><?php echo ucfirst($key);?></label>
                <input type="text" name="<?php echo $key;?>" class="form-control" value="<?php echo $value;?>" required readonly>
            </div>
            <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>
</div>
<div class="col-md-12 mt-2">
    <div class="card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Owner Details</h6>
        </div>
        <div class="card-body row g-3">
            <?php $except_fields = ['id', 'buyer_id', 'type', 'birth_date', 'status', 'created_at', 'updated_at'];?>
            <?php 
            $get_field_name = [
                'first_name' => 'owner_first_name',
                'last_name' => 'owner_last_name',
                'email' => 'email',
            ];
            ?>
            <?php foreach($buyer_representative[0] as $key => $value):?>
            <?php if(!in_array($key, $except_fields)):?>
            <div class="col-md-6">
                <label class="small mb-1" for="<?php echo $key;?>"><?php echo ucfirst($key);?></label>
                <input type="text" name="<?php echo $get_field_name[$key];?>" class="form-control" value="<?php echo $value;?>" required readonly>
            </div>
            <?php endif;?>
            <?php endforeach;?>
        </div>
    </div>
</div>
<div class="col-md-12 mt-2">
    <div class="card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Invoice Details</h6>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-7">
                <label class="small mb-1">Invoice file</label>
                <input type="file" name="file" class="form-control" value="<?= $factoring['file'] ?? ''?>" required>
            </div>
            <div class="col-md-5">
                <label class="small mb-1">Invoice Issued At</label>
                <input type="datetime-local" name="invoice_issued_at" class="form-control" value="<?= $factoring['invoice_issued_at'] ?? ''?>" required>
            </div>
            <div class="col-md-12">
                <label class="small mb-1">Invoice Url</label>
                <input type="url" name="invoice_url" class="form-control" value="<?= $factoring['invoice_url'] ?? 'https://example.com/file.pdf'?>" required>
            </div>
            
        </div>
    </div>
</div>

<?php endif;?>
<!-- end of edit form -->