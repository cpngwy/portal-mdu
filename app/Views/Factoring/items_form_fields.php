<div class="col-md-6">
    <label class="small mb-1" data-toggle="tooltip" data-placement="right" aria-hidden="true" title="Amount of discount to be applied on this.">
        <i class="fas fa-info-circle"></i>&nbsp;Discount
    </label>
    <input type="text" name="discount_cents" class="form-control" value="0.00" required>
</div>
<div class="col-md-6">
    <label class="small mb-1" data-toggle="tooltip" data-placement="right" aria-hidden="true" title="Shipping price to be applied on this.">
        <i class="fas fa-info-circle"></i>&nbsp;Shipping Price
    </label>
    <input type="text" name="shipping_price_cents" class="form-control" value="0.00" required>
</div>
<!-- <div class="col-md-4">
    <label class="small mb-1">Tax Cents</label>
    <input type="text" name="tax_cents" class="form-control" value="0.00" required>
</div> -->
<div class="col-md-12 mt-2 text-center">
    <h4 class="page-header-title">
        <div class="page-header-icon">Line Item/s</div>
    </h4>
</div>
<div class="col-md-4">
    <label class="small mb-1" data-toggle="tooltip" data-placement="right" aria-hidden="true" title="Reference ID of resource in external service e.g.: SKU1001.">
        <i class="fas fa-info-circle"></i>&nbsp;External Reference Id
    </label>
    <input type="text" name="external_reference_id" class="form-control" value="" required>
</div>
<div class="col-md-8">
    <label class="small mb-1" data-toggle="tooltip" data-placement="right" aria-hidden="true" title="Name of the line item (product or service).">
        <i class="fas fa-info-circle"></i>&nbsp;Title
    </label>
    <input type="text" name="title" class="form-control" value="" required>
</div>
<div class="col-md-3">
    <label class="small mb-1" data-toggle="tooltip" data-placement="right" aria-hidden="true" title="Number of items.">
        <i class="fas fa-info-circle"></i>&nbsp;Quantity
    </label>
    <input type="number" name="quantity" id="quantity" onkeyup="compute_items()" onchange="compute_items()" class="form-control" value="1" required>
</div>
<div class="col-md-3">
    <label class="small mb-1" data-toggle="tooltip" data-placement="right" aria-hidden="true" title="The net price of line item without taxes, shipping cost or discounts.">
        <i class="fas fa-info-circle"></i>&nbsp;Net Price per Item
    </label>
    <input type="text" name="net_price_per_item_cents" id="net_price_per_item_cents" onkeyup="compute_items()" class="form-control" value="" required>
</div>
<div class="col-md-3">
    <label class="small mb-1" data-toggle="tooltip" data-placement="right" aria-hidden="true" title="Amount of tax to be applied on this line item.">
        <i class="fas fa-info-circle"></i>&nbsp;Item Tax
    </label>
    <input type="text" name="item_tax_cents" id="item_tax_cents" onkeyup="compute_items()" class="form-control" value="0.00" required>
</div>
<div class="col-md-3">
    <label class="small mb-1">Net Price</label>
    <input type="text" name="net_price_cents" id="net_price_cents" onkeyup="compute_items()" class="form-control" value="" required readonly>
</div>