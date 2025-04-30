<?php
    $status = ['Active', 'Inactive'];
?>
<div class="col-md-6">
    <label class="small mb-1" for="type">Buyer</label>
    <select name="buyer_id" id="buyer_id" class="form-control">
        <?php foreach($buyers as $buyer):?>
            <option value="<?= $buyer['id']?>"><?= $buyer['name']?></option>
        <?php endforeach;?>
    </select>
</div>
<div class="col-md-6">
    <label class="small mb-1" for="status">Status</label>
    <select name="status" id="status" class="form-control">
        <?php foreach($status as $status):?>
            <option value="<?= $status?>"><?= $status?></option>
        <?php endforeach;?>
    </select>
</div>