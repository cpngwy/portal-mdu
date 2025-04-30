<?php
$country_codes = ['IT', 'DE', 'NL', 'GB'];
$address_types = ['billing', 'shipping'];
$address_status = ['Active', 'Inactive'];
?>
<div class="col-md-4">
    <label class="small mb-1" for="country_code">Address Type</label>
    <select name="country_code" class="form-control">
    <?php foreach($address_types as $type):?>    
    <option value="<?= $type?>"><?= $type?></option>
    <?php endforeach;?>
    </select>
</div>
<div class="col-md-12">
    <label class="small mb-1" for="address_line1">Address line 1</label>
    <input type="text" name="address_line1" class="form-control mb-2" placeholder="Address line1" value="<?= $buyer['address_line1'] ?? '' ?>">
</div>
<div class="col-md-12">
    <label class="small mb-1" for="address_line1">Address line 2</label>
    <input type="text" name="address_line2" class="form-control mb-2" placeholder="Address line1" value="<?= $buyer['address_line2'] ?? '' ?>">
</div>
<div class="col-md-3">
    <label class="small mb-1" for="city">City</label>
    <input type="text" name="city" class="form-control mb-2" placeholder="City" value="<?= $buyer['city'] ?? '' ?>">
</div>
<div class="col-md-3">
    <label class="small mb-1" for="state">State</label>
    <input type="text" name="state" class="form-control mb-2" placeholder="State" value="<?= $buyer['state'] ?? '' ?>">
</div>
<div class="col-md-3">
    <label class="small mb-1" for="zip_code">Zip Code</label>
    <input type="text" name="zip_code" class="form-control mb-2" placeholder="Zip Code" value="<?= $buyer['zip_code'] ?? '' ?>">
</div>
<div class="col-md-3">
    <label class="small mb-1" for="country_code">Country code</label>
    <select name="country_code" class="form-control">
    <?php foreach($country_codes as $country_code):?>    
    <option value="<?= $country_code?>"><?= $country_code?></option>
    <?php endforeach;?>
    </select>
</div>
<div class="col-md-3">
    <label class="small mb-1" for="country_code">Status</label>
    <select name="status" class="form-control">
    <?php foreach($address_status as $address_status):?>    
    <option value="<?= $address_status?>"><?= $address_status?></option>
    <?php endforeach;?>
    </select>
</div>