
<div class="col-md-7">
    <label class="small mb-1">Invoice file</label>
    <input type="file" name="pdf_file" id="pdf_file" class="form-control" value="<?= $factoring['pdf_file'] ?? ''?>">
</div>
<div class="col-md-5">
    <label class="small mb-1">Invoice Issued At</label>
    <input type="datetime-local" name="invoice_issued_at" class="form-control" value="<?= $factoring['invoice_issued_at'] ?? ''?>" required>
</div>
<div class="col-md-12">
    <label class="small mb-1">Invoice Url</label>
    <input type="url" name="invoice_url" class="form-control" value="<?= $factoring['invoice_url'] ?? 'https://example.com/file.pdf'?>" required>
</div>
