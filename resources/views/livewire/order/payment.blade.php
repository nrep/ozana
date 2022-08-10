<div><title>Volt Laravel Dashboard - Profile</title>
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
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="first_name">To Be Paid</label>
                                    <input wire:model="total_price" class="form-control" id="first_name"
                                        type="text" placeholder="Total Price" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label for="first_name">Paid Amount</label>
                                    <input wire:model="paid_amount" class="form-control" id="first_name"
                                        type="number" placeholder="Paid Amount" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender">Payment Method</label>
                                <select wire:model="payment_method" class="form-select mb-0" id="gender"
                                    aria-label="Product name">
                                    <option>Choose...</option>
                                    <option value="Cash">Cash</option>
                                    <option value="MoMo">MTN Mobile Money</option>
                                </select>
                                @error('payment_method') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
