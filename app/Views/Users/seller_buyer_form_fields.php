<div class="col-md-6">
    <label class="small mb-1" for="seller_id">Seller</label>
    <select name="seller_id" id="seller_id" class="tom-select-dropdown">
        <option value=""></option>
        <?php foreach($sellers as $seller):?>
        <option value="<?php echo $seller['id'];?>" <?php echo ($seller['id'] == $user->seller_id) ? 'selected' : '';?>><?php echo $seller['name'];?></option>
        <?php endforeach;?>
    </select>
</div>
<div class="col-md-6">
    <label class="small mb-1" for="seller_id">Buyer</label>
    <select name="buyer_id" id="buyer_id" class="tom-select-dropdown-a">
        <option value=""></option>
        <?php foreach($buyers as $buyer):?>
        <option value="<?php echo $buyer['id'];?>" <?php echo ($buyer['id'] == $user->buyer_id) ? 'selected' : '';?>><?php echo $buyer['name'];?></option>
        <?php endforeach;?>
    </select>
</div>