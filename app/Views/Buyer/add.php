<div class="content">
    <div class="container-fluid">
            
        <h4 class="page-header-title mb-4">
            <div class="page-header-icon">
                Register a <?= ucfirst($active_sidebar)?>
            </div>
        </h4>
        <div class="row mt-4 mb-4">
            <div class="col-xl-8">
                <?php include('form_errors.php');?>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($active_sidebar)?> Details</h6>
                        
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('/buyer/store') ?>" class="row g-3">
                            <?= csrf_field() ?>
                            <?php include('form_fields.php') ?>
                            <div class="col-md-12 text-right"><button type="submit" class="btn btn-primary mt-2">Register</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>