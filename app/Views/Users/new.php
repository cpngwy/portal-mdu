<div class="content">
<div class="container-fluid">
        
        <h4 class="page-header-title">
            <div class="page-header-icon">
                Register a new user
            </div>
        </h4>
        <hr class="mt-0 mb-4">
        
        <div class="row mt-4">
            <div class="col-xl-8">
                <?php if($errors || $error):?>
                <div class="row">
                    <?php if(is_array($errors)):?>
                        <?php foreach($errors as $error):?>
                        <div class="card mx-4 mb-4 bg-warning text-white shadow">
                            <div class="card-body">
                                Warning
                                <div class="text-white-50 medium"><?php echo $error;?></div>
                            </div>
                        </div>
                        <?php endforeach?>
                        <?php else: ?>
                        <div class="card mx-4 mb-4 bg-warning text-white shadow">
                            <div class="card-body">
                                Warning
                                <div class="text-white-50 medium"><?php echo $error;?></div>
                            </div>
                        </div>
                        <?php endif;?>
                    <?php elseif($message):?>
                    <div class="card mx-4 mb-4 bg-success text-white shadow">
                        <div class="card-body">
                            Success
                            <div class="text-white-50 medium"><?php echo $message;?></div>
                        </div>
                    </div>
                </div>
                <?php endif;?>
            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mx-4 mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/users/register') ?>" method="post">
                        <?= csrf_field() ?>
                            <!-- Form Group (email address)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="email">Email address</label>
                                <input class="form-control" id="email" name="email" type="email" placeholder="Enter your email address" value="<?php echo set_value('email');?>" required>
                            </div>
                            <!-- Form Group (username)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="username">Username</label>
                                <input class="form-control" id="username" name="username" type="text" placeholder="Enter your username" value="<?php echo set_value('username');?>" required>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="password">Password</label>
                                    <input class="form-control" id="password" name="password" type="password" placeholder="Enter your Password" value="" required>
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="password_confirm">Confirm Password</label>
                                    <input class="form-control" id="password_confirm" name="password_confirm" type="password" placeholder="Please your Confirm Password" value="" required>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="first_name">First name</label>
                                    <input class="form-control" id="first_name" name="first_name" type="text" placeholder="Enter your first name" value="<?php echo set_value('first_name');?>" required>
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="last_name">Last name</label>
                                    <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Enter your last name" value="<?php echo set_value('last_name');?>" required>
                                </div>
                            </div>
                            <!-- Form Group (seller_code)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="seller_code">Seller Code</label>
                                <input class="form-control" id="seller_code" name="seller_code" type="text" placeholder="Enter Seller Code for this user" value="">
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="submit">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</div>   
<script>
    $('#myTab a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>