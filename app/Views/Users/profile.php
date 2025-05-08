<div class="content">
    <div class="container-fluid">
        <h4 class="page-header-title mb-2">
            <div class="page-header-icon">&nbsp;</div>
        </h4>
        <div class="row mb-2">
            <div class="col-xl-12">
                <?php include('form_errors.php');?>
            </div>
            <div class="col-xl-7">
                <div class="card mb-2">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('/user/updateprofilepassword') ?>" class="row g-3">
                            <?= csrf_field() ?>
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
                                        <div class="col-md-4">
                                            <label class="small mb-1" for="current_password">Current Password</label>
                                            <input type="password" name="current_password" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="small mb-1" for="password">New Password</label>
                                            <input class="form-control" id="password" name="new_password" type="password" placeholder="Enter Password" value="" required>
                                        </div>
                                        <!-- Form Group (last name)-->
                                        <div class="col-md-4">
                                            <label class="small mb-1" for="confirm_password">Confirm Password</label>
                                            <input class="form-control" id="confirm_password" name="confirm_password" type="password" placeholder="Please Confirm Password" value="" required>
                                        </div>
                                        <!-- Form Row-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-right"><button type="submit" class="btn btn-primary mt-2">Update</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>