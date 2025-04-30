<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lists of <?php echo ucfirst($active_sidebar);?>s</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Seller Code</th>
                            <th>Name</th>
                            <th>P.IVA</th>
                            <th>Registration ID</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sellers as $seller): ?>
                            <tr>
                                <td><?= $seller['seller_code'] ?></td>
                                <td><?= $seller['name'] ?></td>
                                <td><?= $seller['piva'] ?></td>
                                <td><?= $seller['registration_id'] ?></td>
                                <td><?= $seller['status'] ?></td>
                                <td>
                                    <a href="/seller/edit/<?= $seller['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                                    <!-- <a href="/seller/delete/<?= $seller['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a> -->
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>