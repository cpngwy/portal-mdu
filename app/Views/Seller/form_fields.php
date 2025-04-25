<div class="mb-3">
    <label class="small mb-1" for="seller_code">Seller Code</label>
    <input class="form-control" id="seller_code" name="seller_code" type="text" placeholder="Enter yourseller_code" value="<?= $seller['seller_code'] ?? '' ?>" required>
</div>
<div class="mb-3">
    <label class="small mb-1" for="name">Name</label>
    <input type="text" name="name" class="form-control mb-2" placeholder="Name" value="<?= $seller['name'] ?? '' ?>" required>
</div>
<div class="mb-3">
    <label class="small mb-1" for="piva">P.IVA</label>
    <input type="text" name="piva" class="form-control mb-2" placeholder="P.IVA" value="<?= $seller['piva'] ?? '' ?>">
</div>
<div class="mb-3">
    <label class="small mb-1" for="registration_id">Registration Id</label>
    <input type="text" name="registration_id" class="form-control mb-2" placeholder="Registration ID" value="<?= $seller['registration_id'] ?? '' ?>">
</div>
<div class="mb-3">
    <label class="small mb-1" for="api_key">API Key</label>
    <input type="text" name="api_key" class="form-control mb-2" placeholder="API Key" value="<?= $seller['api_key'] ?? '' ?>">
</div>
<div class="mb-3">
    <label class="small mb-1" for="status">Status</label>
    <select name="status" class="form-control mb-3">
    <option value="active" <?= (isset($seller) && $seller['status'] == 'active') ? 'selected' : '' ?>>Active</option>
    <option value="inactive" <?= (isset($seller) && $seller['status'] == 'inactive') ? 'selected' : '' ?>>Inactive</option>
</select>
</div>