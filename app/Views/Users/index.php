   
<div class="container-fluid">
    
    <?php if(!empty($message)): ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card <?php echo $add_class;?> text-white shadow">
                <div class="card-body">
                    <div class="text-white-50 medium"><?php echo $message;?></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-2 text-gray-800"><?php //echo $title_header;?></h1> -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lists of <?php echo $title_header;?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($users as $user) :?>
                        <tr>
                            <td><?= $user->id ?></td>
                            <td><?= $user->email ?></td>
                            <td><?= implode(', ', $user->getGroups()) ?></td>
                            <td>
                                <a href="<?= site_url('admin/users/assign/'.$user->id.'/admin') ?>" class="btn btn-primary">Make Admin</a>
                                <a href="<?= site_url('admin/users/assign/'.$user->id.'/user') ?>" class="btn btn-secondary">Make User</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

