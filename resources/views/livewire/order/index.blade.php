<div>
    <title>Volt Laravel Dashboard - Profile</title>
    <div class="py-4">
        <div class="card card-body border-0 shadow mb-4">
            <livewire:order-table />
        </div>
    </div>
    <script>
        function deleteOrder(orderId) {
            if (confirm("Are you sure you want to delete this order?") == true) {
                @this.deleteOrder(orderId);
            }
        }
    </script>
</div>
