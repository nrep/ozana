<div>
    <title>Volt Laravel Dashboard - Profile</title>
    <div class="py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                @if ($showSavedAlert)
                    <div class="alert alert-success" role="alert">
                        Saved!
                    </div>
                @endif
                <div class="card card-body border-0 shadow mb-4">
                    <h2 class="h5 mb-4">General information</h2>
                    <form wire:submit.prevent="save" action="#" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3" wire:ignore>
                                <label for="gender">Product Name</label>
                                <select wire:model="product" class="form-select mb-0" id="product-id"
                                    aria-label="Product name">
                                    <option selected>Choose...</option>
                                    @foreach ($products as $productItem)
                                        <option value="{{ $productItem->id }}" {{ $productItem->id == $product ? "selected" : "" }}>{{ $productItem->name }}</option>
                                    @endforeach
                                </select>
                                @error('product')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <script>
                                $('#product-id').select2({
                                    theme: 'bootstrap4',
                                    placeholder: 'Choose a product',
                                    tags: true,
                                });
                                $('#product-id').on('change', function(e) {
                                    @this.set('product', e.target.value);
                                });
                            </script>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="first_name">Supplier</label>
                                    <input wire:model="supplier" class="form-control" id="first_name" type="text"
                                        placeholder="Enter the supplier's name" required>
                                </div>
                                @error('supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="first_name">Batch Number</label>
                                    <input wire:model="batch_number" class="form-control" id="first_name" type="text"
                                        placeholder="Enter the batch number" required>
                                </div>
                                @error('batch_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="first_name">Quantity</label>
                                    <input wire:model="quantity" class="form-control" id="first_name" type="text"
                                        placeholder="Enter the quantity" required disabled>
                                </div>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="first_name">Cost</label>
                                    <input wire:model="cost" class="form-control" id="first_name" type="number"
                                        placeholder="Enter the cost" required>
                                </div>
                                @error('cost')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="first_name">Price</label>
                                    <input wire:model="price" class="form-control" id="first_name" type="number"
                                        placeholder="Enter the price" required>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="first_name">Purchase Date</label>
                                    <input wire:model="purchase_date" class="form-control" id="first_name"
                                        type="date" placeholder="Enter the quantity" required>
                                </div>
                                @error('purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="first_name">Expiry Date</label>
                                    <input wire:model="expiry_date" class="form-control" id="first_name" type="date"
                                        placeholder="Enter the quantity" required>
                                </div>
                                @error('expiry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
