<?php
    $status = ['Active', 'Inactive'];
    $type = ['owner', 'authorized_person'];
?>
<div class="col-md-3">
    <label class="small mb-1" for="first_name">First Name</label>
    <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Enter First Name" value="" required>
</div>
<div class="col-md-3">
    <label class="small mb-1" for="last_name">Last Name</label>
    <input type="text" name="last_name" class="form-control mb-2" placeholder="Enter Last Name" value="" required>
</div>
<div class="col-md-6">
    <label class="small mb-1" for="email">Email</label>
    <input type="text" name="email" class="form-control mb-2" placeholder="Enter Email" value="" required>
</div>

<div class="col-md-4">
    <label class="small mb-1" for="birth_date">Date of Birth</label>
    <input type="date" name="birth_date" class="form-control mb-2" placeholder="Birth Date" value="">
</div>
<div class="col-md-4">
    <label class="small mb-1" for="type">Type</label>
    <select name="type" id="type" class="form-control">
        <?php foreach($type as $type):?>
            <option value="<?= $type?>"><?= $type?></option>
        <?php endforeach;?>
    </select>
</div>
<div class="col-md-4">
    <label class="small mb-1" for="status">Status</label>
    <select name="status" id="status" class="form-control">
        <?php foreach($status as $status):?>
            <option value="<?= $status?>"><?= $status?></option>
        <?php endforeach;?>
    </select>
</div>