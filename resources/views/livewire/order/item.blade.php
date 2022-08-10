<div class="row">
    <div class="col-md-6 mb-3" wire:ignore>
        <label for="gender">Product Name</label>
        <select wire:model="stock_id" id="product_id-{{ $itemIndex }}" class="form-select form-control mb-0"
            aria-label="Product name">
        </select>
        @error('stock_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <script>
        function formatStockProduct(stockProduct) {
            if (!stockProduct.id) {
                return stockProduct.text;
            }
            var $product = $(
                `<div class="d-flex">
                    <div class="flex-grow-1">
                        <div style="font-size: 14px">${stockProduct.product.name}</div>
                        <div class="text-black-50 font-weight-bold" style="font-size: 11px">${stockProduct.batch_number}</div>
                    </div>
                    <div class="align-self-center font-weight-bold">${stockProduct.selling_price}</div>
                </div>`
            );
            return $product;
        };

        function formatStockProductSelection(stockProduct) {
            if (!stockProduct.id) {
                return stockProduct.text;
            }
            // console.log({stockProducti: stockProduct})
            var $product = $(
                `<div>${stockProduct.product.name} - <span style="color: gray;">${stockProduct.batch_number}</span></div>`
            );
            return $product;
        };

        $(document).ready(function() {
            $('#product_id-' + <?php echo $itemIndex; ?>).select2({
                theme: 'bootstrap4',
                templateResult: formatStockProduct,
                templateSelection: formatStockProductSelection,
                placeholder: 'Choose a product',
                ajax: {
                    url: "/api/stocks",
                    cache: false,
                    processResults: function(data) {
                        var results = data.map(function(item) {
                            item.text = item.product.name;
                            return item;
                        });
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results
                        };
                    }
                }
            });
            $('#product_id-' + <?php echo $itemIndex; ?>).on('change', function(e) {
                @this.set('stock_id', e.target.value);
            });
        });
    </script>
    <div class="col-md mb-3">
        <div class="form-group">
            <label for="first_name">P.U</label>
            <input wire:model="unit_price" class="form-control" type="number" placeholder="Unit Price" readonly>
        </div>
    </div>
    <div class="col-md mb-3">
        <div class="form-group">
            <label for="first_name">In Stock</label>
            <input wire:model="available_quantity" class="form-control" type="number" placeholder="Available Quantity"
                readonly>
        </div>
    </div>
    <div class="col-md mb-3">
        <div class="form-group">
            <label for="first_name">Quantity</label>
            <input wire:model="order_quantity" class="form-control" type="number" placeholder="Order Quantity"
                max="{{ $available_quantity }}" min="1" required
                @if ($available_quantity < 1) disabled @endif>
        </div>
        @error('order_quantity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md mb-3">
        <div class="form-group">
            <label for="first_name">Total</label>
            <input wire:model="price" class="form-control" id="first_name" type="number" placeholder="Total" readonly>
        </div>
    </div>
</div>
