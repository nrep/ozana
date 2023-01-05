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
                    <form wire:submit.prevent="save" action="#" method="POST">
                        <div class="form-group mb-4">
                            <label for="first_name">Date</label>
                            <input wire:model="date" class="form-control" id="first_name" type="date"
                                placeholder="Enter the product name" required>
                        </div>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <h2 class="h5">Customer Information</h2>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="first_name">Names</label>
                                    <input wire:model="name" class="form-control" id="first_name" type="text"
                                        placeholder="Enter the customer's names" required>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="first_name">Age</label>
                                    <input wire:model="age" class="form-control" type="number"
                                        placeholder="Enter the customer's age" required>
                                </div>
                                @error('age')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="gender">Sex</label>
                                <select wire:model="sex" class="form-select form-control mb-0" aria-label="Sex">
                                    <option value="" selected>Choose...</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                                @error('sex')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="first_name">Phone Number</label>
                                    <input wire:model="phone_number" class="form-control" type="tel"
                                        placeholder="Enter the customer's phone number" required>
                                </div>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md mb-3">
                                <label for="gender">Insurance</label>
                                <select wire:model="insurance_id" class="form-select form-control mb-0"
                                    aria-label="Insurance" {{ count($insurances) == 1 ? 'disabled' : '' }}>
                                    <option value="" selected>Choose...</option>
                                    @foreach ($insurances as $insurance)
                                        <option value="{{ $insurance->id }}">{{ $insurance->acronym }}</option>
                                    @endforeach
                                </select>
                                @error('insurance_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md mb-3">
                                <label for="gender">Discount</label>
                                <select wire:model="discount_id" class="form-select form-control mb-0"
                                    aria-label="Discount" {{ count($discounts) == 1 ? 'disabled' : '' }}>
                                    <option value="" selected>Choose...</option>
                                    @foreach ($discounts as $discount)
                                        <option value="{{ $discount->id }}">{{ $discount->percentage }}%</option>
                                    @endforeach
                                </select>
                                @error('discount_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex">
                            <h2 class="h5 mt-4 flex-grow-1">Items</h2>
                            <div>
                                <button type="button" class="btn btn-outline-gray-800 mt-4 mb-2 animate-up-2 btn-icon"
                                    wire:click.prevent='addOrderItem'>
                                    <i class="fa fa-plus"></i>
                                    Add item
                                </button>
                            </div>
                        </div>
                        <div>
                            @for ($i = 0; $i < count($order->items); $i++)
                                @livewire('order.update.item', ['itemIndex' => $i, 'item' => $order->items[$i]], key($i))
                            @endfor
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
