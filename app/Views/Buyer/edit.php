<div class="content">
    <div class="container-fluid">
        <h4 class="page-header-title mb-2">
            <div class="page-header-icon">
                Register a <?php echo ucfirst($active_sidebar);?>
            </div>
        </h4>
        <div class="row">
            <div class="col-xl-12">
                <?php include('form_errors.php');?>
            </div>
            <div class="col-xl-12 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($active_sidebar)?> Details</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('/buyer/update/'.$buyer['id']) ?>" class="row g-3">
                            <?= csrf_field() ?>
                            <?php include('form_fields.php') ?>
                            <div class="col-md-12 text-right"><button type="submit" class="btn btn-primary mt-2">Update</button></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Authorize Representatives</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('/buyerrepresentative/store/'.$buyer['id']) ?>" class="row g-3">
                            <?= csrf_field() ?>
                            <?php include('representative_form_fields.php') ?>
                            <div class="col-md-12 text-right"><button type="submit" class="btn btn-primary mt-2">Add Representative</button></div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <table class="table" id="buyer_representatives">
                            <thead>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                <?php foreach ($buyer_representatives as $representative): ?>
                                    <tr>
                                        <td><?php echo $representative['first_name'];?> <?php echo $representative['last_name'];?></td>
                                        <td><?php echo $representative['type'];?></td>
                                        <td><?php echo $representative['status'];?></td>
                                    </tr>
                                <?php endforeach; ?> 
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Billing and Shipping Addresses</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('/buyeraddress/store/'.$buyer['id']) ?>" class="row g-3">
                            <?= csrf_field() ?>
                            <?php include('address_form_fields.php') ?>
                            <div class="col-md-12 text-right"><button type="submit" class="btn btn-primary mt-2">Add Shipping Address</button></div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <table class="table" id="factoring_items">
                            <thead>
                                <th>Country Code</th>
                                <th>Address</th>
                                <th>Type</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                <?php foreach ($buyer_addresses as $address): ?>
                                    <tr>
                                        <td><?php echo $address['country_code'];?></td>
                                        <td><?php echo $address['address_line1'];?> <?php echo $address['address_line2'];?> <?php echo $address['city'];?> <?php echo $address['state'];?> <?php echo $address['zip_code'];?></td>
                                        <td><?php echo $address['type'];?></td>
                                        <td><?php echo $address['status'];?></td>
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