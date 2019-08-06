<div class="col-md-4">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- MENGGUNAKAN LOOPING VUEJS -->
            <tr v-for="(row, index) in shoppingCart">
                <td>@{{ row.name }} (@{{ row.code }})</td>
                <td>@{{ row.price | currency }}</td>
                <td>@{{ row.qty }}</td>
                <td>
                    <!-- EVENT ONCLICK UNTUK MENGHAPUS CART -->
                    <button 
                        @click.prevent="removeCart(index)"    
                        class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    @if (url()->current() == route('order.create'))
    <div class="card-footer text-muted">
        <a href="{{ route('order.checkout') }}" 
            class="btn btn-info btn-sm float-right">
            Checkout
        </a>
        @else
            <a href="{{ route('order.create') }}"
                class="btn btn-secondary btn-sm float-right"
                >
                Kembali
            </a>
        @endif
    </div>
    
</div>