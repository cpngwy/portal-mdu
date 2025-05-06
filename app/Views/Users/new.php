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
                <?php include('form_errors.php');?>
            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form action="<?= base_url('users/register') ?>" method="post" class="row g-3">
                        <?= csrf_field() ?>
                        <?php include('form_fields.php');?>
                        <!-- Save changes button-->
                        <div class="col-md-12 text-right"><button type="submit" class="btn btn-primary mt-2">Register</button></div
                        </form>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</div>  
