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
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label for="first_name">Product Name</label>
                                    <input wire:model="name" class="form-control" id="first_name"
                                        type="text" placeholder="Enter the product name" required>
                                </div>
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
