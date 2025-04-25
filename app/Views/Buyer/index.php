<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lists of <?php echo ucfirst($active_sidebar);?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Buyer Code</th>
                            <th>Name</th>
                            <th>P.IVA</th>
                            <th>Registration ID</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($buyers as $buyer): ?>
                            <tr>
                                <td><?= $buyer['buyer_code'] ?></td>
                                <td><?= $buyer['name'] ?></td>
                                <td><?= $buyer['piva'] ?></td>
                                <td><?= $buyer['registration_id'] ?></td>
                                <td><?= $buyer['status'] ?></td>
                                <td>
                                    <a href="/buyer/edit/<?= $buyer['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                                    <!-- <a href="/buyer/delete/<?= $buyer['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a> -->
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>