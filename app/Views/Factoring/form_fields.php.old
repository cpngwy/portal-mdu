<?php
function oldValue($key, $factoring = [])
{
    return old($key, $factoring[$key] ?? '');
}
?>

<div class="col-md-6">
    <label class="small mb-1">Supplier Code</label>
    <input type="text" name="supplier_code" class="form-control" value="<?= oldValue('supplier_code', $factoring ?? []) ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1">Buyer Code</label>
    <input type="text" name="buyer_code" class="form-control" value="<?= oldValue('buyer_code', $factoring ?? []) ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1">Invoice Reference</label>
    <input type="text" name="invoice_external_reference_id" class="form-control" value="<?= oldValue('invoice_external_reference_id', $factoring ?? []) ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1">Currency</label>
    <input type="text" name="currency" class="form-control" value="<?= oldValue('currency', $factoring ?? []) ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1">Net Term</label>
    <input type="number" name="net_term" class="form-control" value="<?= oldValue('net_term', $factoring ?? []) ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1">Total Discount (Cents)</label>
    <input type="number" name="total_discount_cents" class="form-control" value="<?= oldValue('total_discount_cents', $factoring ?? []) ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1">Invoice Issued At</label>
    <input type="datetime-local" name="invoice_issued_at" class="form-control" value="<?= oldValue('invoice_issued_at', $factoring ?? []) ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1">Gross Amount (Cents)</label>
    <input type="number" name="gross_amount_cents" class="form-control" value="<?= oldValue('gross_amount_cents', $factoring ?? []) ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1">Language</label>
    <input type="text" name="language" class="form-control" value="<?= oldValue('language', $factoring ?? []) ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1">Invoice URL</label>
    <input type="url" name="invoice_url" class="form-control" value="<?= oldValue('invoice_url', $factoring ?? []) ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1">File</label>
    <input type="text" name="file" class="form-control" value="<?= oldValue('file', $factoring ?? []) ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1">Owner First Name</label>
    <input type="text" name="owner_first_name" class="form-control" value="<?= oldValue('owner_first_name', $factoring ?? []) ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1">Owner Last Name</label>
    <input type="text" name="owner_last_name" class="form-control" value="<?= oldValue('owner_last_name', $factoring ?? []) ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1">Status</label>
    <select name="status" class="form-control">
        <option value="pending" <?= oldValue('status', $factoring ?? []) == 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="approved" <?= oldValue('status', $factoring ?? []) == 'approved' ? 'selected' : '' ?>>Approved</option>
        <option value="rejected" <?= oldValue('status', $factoring ?? []) == 'rejected' ? 'selected' : '' ?>>Rejected</option>
    </select>
</div>
<div class="col-md-6">
    <div class="form-check mt-4">
        <input type="checkbox" name="owner_is_authorized" class="form-check-input" <?= (old('owner_is_authorized', $factoring['owner_is_authorized'] ?? false)) ? 'checked' : '' ?>>
        <label class="form-check-label">Is Owner Authorized?</label>
    </div>
</div>