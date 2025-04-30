<div class="content">
    <div class="container-fluid">
            
        <h4 class="page-header-title">
            <div class="page-header-icon">
                Create factoring
            </div>
        </h4>
        <div class="row mt-4">
            <div class="col-xl-8">
                <?php include('form_errors.php');?>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($active_sidebar)?> Details</h6>
                    </div>
                        <div class="card-body">
                            <form action="<?= base_url('factoring/store') ?>" method="post" class="row g-3">
                                <?= view('Factoring/form_fields') ?>
                                <div class="col-12 text-right mt-2">
                                    <button type="submit" class="btn btn-primary">Confirm and Proceed</button>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
        
    </div>
</div>