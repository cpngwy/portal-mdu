<div class="content">
    <div class="container-fluid">
            
        <h4 class="page-header-title mb-2">
            <div class="page-header-icon">
                Register a <?= ucfirst($active_sidebar)?>
            </div>
        </h4>
        <div class="row mb-2">
            <div class="col-xl-12">
                <?php include('form_errors.php');?>
            </div>
            <div class="col-xl-7">
                <div class="card mb-2">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($active_sidebar)?> Details</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('/user/update/'.$user->id) ?>" class="row g-3">
                            <?= csrf_field() ?>
                            <?= view('Users/form_fields', ['view_page' => $views_page, 'user' => $user, 'sellers' => $sellers, 'buyers' => $buyers]) ?>
                            <div class="col-md-12 text-right"><button type="submit" class="btn btn-primary mt-2">Update</button></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="col-xl-12">
                    <div class="card mb-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Seller and Buyer Details</h6>
                        </div>
                        <div class="card-body">
                            <form method="post" action="<?= site_url('/user/update_seller_buyer/'.$user->id) ?>" class="row g-3">
                                <?= csrf_field() ?>
                                <?= view('Users/seller_buyer_form_fields', ['view_page' => $views_page, 'user' => $user, 'sellers' => $sellers, 'buyers' => $buyers]) ?>
                                <div class="col-md-12 text-right"><button type="submit" class="btn btn-primary mt-2">Update</button></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card mb-2">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($active_sidebar)?> Role</h6>
                        </div>
                        <div class="card-body row g-3">
                            <div class="col-md-6 text-right">
                                <a href="<?= site_url('user/assign/'.$user->id.'/admin') ?>" class="btn btn-md btn-success">Admin</a>
                            </div>
                            <div class="col-md-6 text-left">
                                <a href="<?= site_url('user/assign/'.$user->id.'/user') ?>" class="btn btn-md btn-info">User</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>