<?php
    $country_codes = ['IT', 'DE', 'NL', 'GB'];
?>
<div class="col-md-6">
    <label class="small mb-1" for="seller_code">Seller Code</label>
    <input class="form-control" id="seller_code" name="seller_code" type="text" placeholder="Enter your seller_code" value="<?= $seller['seller_code'] ?? 'SC'.$set_seller_code ?>" required readonly>
</div>
<div class="col-md-12">
    <label class="small mb-1" for="name">Name</label>
    <input type="text" name="name" class="form-control" placeholder="Name" value="<?= $seller['name'] ?? '' ?>" required>
</div>
<div class="col-md-3">
    <label class="small mb-1" for="piva">P.IVA</label>
    <input type="text" name="piva" class="form-control" placeholder="P.IVA" value="<?= $seller['piva'] ?? '' ?>">
</div>
<div class="col-md-3">
    <label class="small mb-1" for="registration_id">Registration Id</label>
    <input type="text" name="registration_id" class="form-control" placeholder="Registration ID" value="<?= $seller['registration_id'] ?? '' ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1" for="api_key">API Key</label>
    <input type="text" name="api_key" class="form-control" placeholder="API Key" value="<?= $seller['api_key'] ?? '' ?>">
</div>
<div class="col-md-3">
    <label class="small mb-1" for="country_code">Country code</label>
    <select name="country_code" class="form-control">
    <?php foreach($country_codes as $country_code):?>    
    <option value="<?= $country_code?>" <?= (isset($seller) && $seller['country_code'] == $country_code) ? 'selected' : '' ?>><?= $country_code?></option>
    <?php endforeach;?>
    </select>
</div>
<div class="col-md-3">
    <label class="small mb-1" for="city">City</label>
    <input type="text" name="city" class="form-control" placeholder="City" value="<?= $seller['city'] ?? '' ?>">
</div>
<div class="col-md-3">
    <label class="small mb-1" for="state">State</label>
    <input type="text" name="state" class="form-control" placeholder="State" value="<?= $seller['state'] ?? '' ?>">
</div>
<div class="col-md-3">
    <label class="small mb-1" for="zip_code">Zip Code</label>
    <input type="text" name="zip_code" class="form-control" placeholder="Zip Code" value="<?= $seller['zip_code'] ?? '' ?>">
</div>
<div class="col-md-12">
    <label class="small mb-1" for="address_line1">Address line1</label>
    <input type="text" name="address_line1" class="form-control" placeholder="Address line1" value="<?= $seller['address_line1'] ?? '' ?>">
</div>
<div class="col-md-6">
    <label class="small mb-1" for="status">Status</label>
    <select name="status" class="form-control">
        <option value="active" <?= (isset($seller) && $seller['status'] == 'active') ? 'selected' : '' ?>>Active</option>
        <option value="inactive" <?= (isset($seller) && $seller['status'] == 'inactive') ? 'selected' : '' ?>>Inactive</option>
    </select>
</div>