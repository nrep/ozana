<div>
    <title>Volt Laravel Dashboard - Profile</title>
    <div class="py-4">
        <div class="card card-body border-0 shadow mb-4">
            <livewire:stock-table />
        </div>
    </div>
    <script>
        function deleteStockItem(itemId) {
            if (confirm("Are you sure you want to delete this stock item?") == true) {
                @this.deleteStockItem(itemId);
            }
        }
    </script>
</div>
