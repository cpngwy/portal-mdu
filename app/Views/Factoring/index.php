<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lists of <?php echo ucfirst($active_sidebar);?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Supplier</th>
                            <th>Buyer</th>
                            <th>Currency</th>
                            <th>Gross</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($factorings as $factoring): ?>
                            <tr>
                                <td><?= esc($factoring['id']) ?></td>
                                <td><?= esc($factoring['supplier_code']) ?></td>
                                <td><?= esc($factoring['buyer_code']) ?></td>
                                <td><?= esc($factoring['currency']) ?></td>
                                <td><?= esc($factoring['gross_amount_cents']) ?></td>
                                <td><?= esc($factoring['status']) ?></td>
                                <td>
                                    <a href="<?= base_url('factoring/edit/' . $factoring['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
