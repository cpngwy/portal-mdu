<div class="content">
    <div class="container-fluid">
            
        <h4 class="page-header-title">
            <div class="page-header-icon">
                Create <?= ucfirst($active_sidebar)?>
            </div>
        </h4>
        <div class="row mt-4">
            <div class="col-xl-7">
                <?php include('form_errors.php');?>
            </div>
            <div class="col-xl-7">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($active_sidebar)?> Details</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('factoring/update/' . $factoring['id']) ?>" method="post" class="row g-3">
                            <?= view('Factoring/form_fields', ['factoring' => $factoring, 'factoring_items_count' => $factoring_items_count]) ?>
                            <?php if($factoring_items_count > 0):?>
                            <div class="col-12 text-right mt-2">
                                <button type="submit" class="btn btn-primary">Continue</button>
                            </div>
                            <?php endif;?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Factoring Item/s</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('factoringitem/store/' . $factoring['id']) ?>" method="post" class="row g-3">
                            <?= view('Factoring/items_form_fields', ['factoring' => $factoring]) ?>
                            <div class="col-12 text-right mt-2">
                                <button type="submit" class="btn btn-danger">Add Item/s</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <table class="table" id="factoring_items">
                            <thead>
                                <th>External Reference Id</th>
                                <th>Title</th>
                                <th>Quantity</th>
                                <th>Net Price per Item</th>
                                <th>Net Price</th>
                            </thead>
                            <tbody>
                                <?php foreach ($factoring_items as $item): ?>
                                    <tr>
                                        <td><?php echo $item['external_reference_id'];?></td>
                                        <td><?php echo $item['title'];?></td>
                                        <td><?php echo $item['quantity'];?></td>
                                        <td><?php echo $item['net_price_per_item_cents'];?></td>
                                        <td><?php echo $item['net_price_cents'];?></td>
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