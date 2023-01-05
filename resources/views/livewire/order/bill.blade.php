<div>
    <title>Volt Laravel Dashboard - Profile</title>
    <div class="py-4">
        <div class="row">
            <div class="col-12 col-xl-3"></div>
            <div class="col-12 col-xl-6">
                <div class="card card-body border-0 shadow mb-4">
                    <div id="printThis">
                        <div class="d-flex">
                            <div class=" flex-grow-1">
                                <h1 class="h4">{{ config('company.name') }} Pharmacy</h1>
                                <h2 class="h6">Tel: <span class="text-muted">{{ config('company.phone_number') }}</span></h2>
                                <h2 class="h6 mb-4">TIN N&deg;: <span class="text-muted">{{ config('company.tin') }}</span></h2>
                            </div>
                            <h2 class="h6 mt-2">Bill N&deg;: <span class="text-muted">{{ substr(config('company.name'), 0, 3) }}-{{ sprintf("%06d", $order->id) }}</h2>
                        </div>
                        <h2 class="h5">General information</h2>
                        <h2 class="h6">Name: <span class="text-muted">{{ $order->customer_name }}</span></h2>
                        <h2 class="h6 mb-4">Date: <span class="text-muted">{{ $order->date }}</span></h2>

                        <h2 class="h5">Order items</h2>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $item->stock->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->selling_price }}</td>
                                        <td>{{ $item->quantity * $item->selling_price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" scope="row">Total Amount</th>
                                    <td>{{ $order->total_price }}</td>
                                </tr>
                                <tr>
                                    <th colspan="4" scope="row">Paid Amount</th>
                                    <td>{{ $order->paid_amount }}</td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="text-muted my-4 text-center text-italic">Done at {{ config('company.name') }} Pharmacy, Muhanga on
                            {{ date('d/m/Y') }}</div>
                    </div>
                    <button wire:ignore class="btn btn-primary me-2 dropdown-toggle text-right" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" onclick="printBill()">
                        <span class="fas fa-print me-2"></span>Print
                    </button>
                    <script>
                        function printBill() {
                            $('#printThis').printThis();
                            $('#printThis').off('click');
                            $('#printThis').on('click', function () {
                                $('#printThis').printThis();
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
