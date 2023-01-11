<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
<section class="pt-5 pb-5">
    <div class="container">
        <div class="row w-100">
            <form class="form-inline my-2 my-lg-0">
                @if (Route::has('login'))
                    <a class="btn btn-success btn-sm ml-3" href="{{route('cart')}}">
                        <i class="fa fa-shopping-cart"></i> Cart
                        <span class="badge badge-light">{{$cart_quantity}}</span>
                    </a>

                    @auth
                        <a class="btn btn-danger btn-sm ml-3" href="{{route('logout')}}">
                            <i class="fa fa-user-o"></i> Logout
                        </a>
                    @else
                        <a class="btn btn-primary btn-sm ml-3" href="{{route('login')}}">
                            <i class="fa fa-address-card"></i> Login
                        </a>
                        @if (Route::has('register'))
                            <a class="btn btn-secondary btn-sm ml-3" href="{{route('register')}}">
                                <i class="fa fa-id-badge"></i> Register
                            </a>
                        @endif
                    @endauth
                @endif
            </form>
            <div class="col-lg-12 col-md-12 col-12">
                <h3 class="display-5 mb-2 text-center">Shopping Cart</h3>
                <p class="mb-5 text-center">
                    <i class="text-info font-weight-bold">{{$cart_quantity}}</i> items in your cart</p>
                <table id="shoppingCart" class="table table-condensed table-responsive">
                    <thead>
                    <tr>
                        <th style="width:60%">Product</th>
                        <th style="width:12%">Price</th>
                        <th style="width:10%">Quantity</th>
                        <th style="width:16%"></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($cart as $key => $item)
                    <tr>
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-md-3 text-left">
                                    <img src="{{$item['image']}}" alt="" class="img-fluid d-none d-md-block rounded mb-2 shadow ">
                                </div>
                                <div class="col-md-9 text-left mt-sm-2">
                                    <h4>{{$item['title']}}</h4>
                                </div>
                            </div>
                        </td>
                        <td data-th="Price">{{ $item['quantity'] * $item['price'] }} ₺</td>
                        <form class="formUpdatePrice">
                            @csrf
                            <td data-th="Quantity">
                                <input type="number" class="form-control form-control-lg text-center quantityProduct" data-id="{{$item['productId']}}" name="quantity" value="{{$item['quantity']}}">
                            </td>
                        </form>
                        <form action="{{ route('cart.delete.product') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <td class="actions" data-th="">
                                <div class="text-right">
                                    <button class="btn btn-white border-secondary bg-white btn-md mb-2 btnDeleteProduct" data-id="{{$item['productId']}}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </form>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="float-right text-right">
                    @if(!session()->has('coupon'))
                        <form action="{{ route('cart.apply_coupon') }}" method="POST">
                            @csrf
                            <label for="coupon">Code: </label>
                            <input type="text" name="coupon" class="form-control">
                            <button type="submit" class="btn btn-success m-1">Apply Coupon</button>
                        </form>
                    @else
                        Code: {{ session('coupon')['code'] }}
                        <form action="{{ route('cart.remove_coupon') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger m-1">Remove Coupon</button>
                        </form>
                    @endif


                    <h4>Subtotal:</h4>
                    <h1>{{$totalPrice}} ₺</h1>

                        <form action="{{ route('cart.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Cart</button>
                        </form>
                </div>
            </div>
        </div>
        <div class="row mt-4 d-flex align-items-center">
            <div class="col-sm-6 order-md-2 text-right">
                <a href="{{route('checkout')}}" class="btn btn-primary mb-4 btn-lg pl-5 pr-5">Checkout</a>
            </div>
            <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
                <a href="{{route('products')}}">
                    <i class="fas fa-arrow-left mr-2"></i> Continue Shopping</a>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script>

    $(document).ready(function () {
        $('.quantityProduct').change(function (e) {
            e.preventDefault();
            const id = $(this).attr("data-id");
            const quantity = $(this).val();

            $.ajax({
                url: "{{ route('cart.update') }}",
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}" },
                data: { product_id : id , quantity : quantity},
                type: "PUT",
                success: function (res) {
                    window.location.reload();
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });

        $('.btnDeleteProduct').on('click',function (e) {
            e.preventDefault();
            const id = $(this).attr("data-id");


            $.ajax({
                url: "{{ route('cart.delete.product') }}",
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}" },
                data: { product_id : id },
                type: "PUT",
                success: function (res) {
                    window.location.reload();
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });
    });
</script>
