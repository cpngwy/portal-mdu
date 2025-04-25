<div class="content">
    <div class="container-fluid">
            
        <h4 class="page-header-title">
            <div class="page-header-icon">
                Create <?= ucfirst($active_sidebar)?>
            </div>
        </h4>
        <hr class="mt-0 mb-4">
        <div class="row mt-4">
            <div class="col-xl-8">
                <?php include('form_errors.php');?>
            </div>
            <div class="col-xl-8">
                <div class="card mx-4 mb-4">
                    <div class="card-header"><?= ucfirst($active_sidebar)?> Details</div>
                    <div class="card-body">
                        <form action="<?= base_url('factoring/update/' . $factoring['id']) ?>" method="post" class="row g-3">
                            <?= view('Factoring/form_fields', ['factoring' => $factoring]) ?>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>