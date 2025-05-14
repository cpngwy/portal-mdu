<?php if(!empty($factoring['file'])):?>
<div class="col-md-12">
    <label class="small"><?= $factoring['file'] ?? ''?></label>
</div>
<?php else:?>
<div class="col-md-12">
    <label class="small">Invoice file</label>
    <input type="file" name="pdf_file" id="pdf_file" class="form-control" value="">
</div>
<?php endif;?>