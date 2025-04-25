<div class="content">
    <div class="container-fluid">
            
        <h4 class="page-header-title mx-4 mb-4">
            <div class="page-header-icon">
                Register a <?= ucfirst($active_sidebar)?>
            </div>
        </h4>
        <hr class="mt-0 mb-4">
        <div class="row mt-4 mb-4">
            <div class="col-xl-8">
                <?php include('form_errors.php');?>
            </div>
            <div class="col-xl-8">
                <div class="card mx-4 mb-4">
                    <div class="card-header"><?= ucfirst($active_sidebar)?> Details</div>
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