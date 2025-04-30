<div class="content">
    <div class="container-fluid">
            
        <h4 class="page-header-title mb-4">
            <div class="page-header-icon">
                Register a <?= ucfirst($active_sidebar)?>
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
                        <form method="post" action="<?= site_url('/seller/update/'.$seller['id']) ?>" class="row g-3">
                            <?= csrf_field() ?>
                            <?php include('form_fields.php') ?>
                            <div class="col-md-12 text-right"><button type="submit" class="btn btn-primary mt-2">Update</button></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Lists of Buyers</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('/sellerbuyer/store/'.$seller['id']) ?>" class="row g-3">
                            <?= csrf_field() ?>
                            <?php include('buyer_form_fields.php') ?>
                            <div class="col-md-12 text-right"><button type="submit" class="btn btn-primary mt-2">Add Buyer</button></div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <table class="table" id="seller_buyers">
                            <thead>
                                <th>Name</th>
                                <th>P.Iva</th>
                                <th>Registration Id</th>
                                <th>Country Code</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                <?php foreach ($seller_buyers as $seller_buyer): ?>
                                    <tr>
                                        <td><?php echo $seller_buyer['name'];?></td>
                                        <td><?php echo $seller_buyer['piva'];?></td>
                                        <td><?php echo $seller_buyer['registration_id'];?></td>
                                        <td><?php echo $seller_buyer['country_code'];?></td>
                                        <td><?php echo $seller_buyer['status'];?></td>
                                    </tr>
                                <?php endforeach; ?> 
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>