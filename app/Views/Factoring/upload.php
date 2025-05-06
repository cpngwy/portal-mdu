<div class="col-xl-7">
    <?= view('Factoring/form_errors', ['errors' => $errors, 'message' => $message]);?>
</div>
<div class="col-xl-7">
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($active_sidebar)?> Invoice Upload</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('file/upload/' . $factoring['id'] .'/'. $factoring['invoice_external_reference_id'] .'/'. 'Mondu_Factoring_Invoices') ?>" method="post" enctype="multipart/form-data" class="row g-3">
                <?= view('Factoring/invoice_upload_form', ['factoring' => $factoring]) ?>
                <div class="col-12 text-right mt-2">
                    <button type="submit" id="submit-btn" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>