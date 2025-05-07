<?php if($views_page == 'new'):?>
<!-- Form Group (email address)-->
<div class="col-md-10">
    <label class="small mb-1" for="email">Email</label>
    <input class="form-control" id="email" name="email" type="text" placeholder="Enter email" value="<?php echo set_value('email');?>" required>
</div>
<!-- Form Group (first name)-->
<div class="col-md-4">
    <label class="small mb-1" for="password">Password</label>
    <input class="form-control" id="password" name="password" type="password" placeholder="Enter Password" value="" required>
</div>
<!-- Form Group (last name)-->
<div class="col-md-4">
    <label class="small mb-1" for="password_confirm">Confirm Password</label>
    <input class="form-control" id="password_confirm" name="password_confirm" type="password" placeholder="Please Confirm Password" value="" required>
</div>
<!-- Form Row-->
<!-- Form Group (first name)-->
<div class="col-md-6">
    <label class="small mb-1" for="first_name">First name</label>
    <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Enter first name" value="<?php echo set_value('first_name');?>" required>
</div>
<!-- Form Group (last name)-->
<div class="col-md-6">
    <label class="small mb-1" for="last_name">Last name</label>
    <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Enter last name" value="<?php echo set_value('last_name');?>" required>
</div>
<!-- Form Group (seller_id)-->
<div class="col-md-6">
    <label class="small mb-1" for="seller_id">Seller</label>
    <select name="seller_id" id="seller_id" class="tom-select-dropdown">
        <option value=""></option>
        <?php foreach($sellers as $seller):?>
        <option value="<?php echo $seller['id'];?>"><?php echo $seller['name'];?></option>
        <?php endforeach;?>
    </select>
</div>
<div class="col-md-6">
    <label class="small mb-1" for="seller_id">Buyer</label>
    <select name="buyer_id" id="buyer_id" class="tom-select-dropdown-a">
        <option value=""></option>
        <?php foreach($buyers as $buyer):?>
        <option value="<?php echo $buyer['id'];?>"><?php echo $buyer['name'];?></option>
        <?php endforeach;?>
    </select>
</div>
<?php else:?>

<!-- Form Group (email address)-->
<div class="col-md-12 mb-2">
    <label class="small mb-1" for="email">Email</label>
    <input class="form-control" id="email" name="email" type="text" placeholder="Enter email" value="<?= $user->email ?? ''?>" readonly required>
</div>

<!-- Form Group (first name)-->
<div class="col-md-6 mb-2">
    <label class="small mb-1" for="first_name">First name</label>
    <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Enter first name" value="<?= $user->first_name ?? ''?>" readonly required>
</div>
<!-- Form Group (last name)-->
<div class="col-md-6">
    <label class="small mb-1" for="last_name">Last name</label>
    <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Enter last name" value="<?= $user->last_name ?? ''?>" readonly required>
</div>
<div class="col-xl-12">
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Reset Password</h6>
        </div>
        <div class="card-body row g-3">
            <!-- Form Group (first name)-->
            <div class="col-md-6">
                <label class="small mb-1" for="password">Password</label>
                <input class="form-control" id="password" name="password" type="password" placeholder="Enter Password" value="" required>
            </div>
            <!-- Form Group (last name)-->
            <div class="col-md-6">
                <label class="small mb-1" for="confirm_password">Confirm Password</label>
                <input class="form-control" id="confirm_password" name="confirm_password" type="password" placeholder="Please Confirm Password" value="" required>
            </div>
            <!-- Form Row-->
        </div>
    </div>
</div>
<?php endif;?>