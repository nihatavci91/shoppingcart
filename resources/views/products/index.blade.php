<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<link href="{{asset('assets/dist/css/product.css')}}" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{route('products')}}">Simple Ecommerce</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarsExampleDefault">
            <ul class="navbar-nav m-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('products')}}">Products</a>
                </li>
            </ul>

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
        </div>
    </div>
</nav>
<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">E-COMMERCE CATEGORY</h1>
        <p class="lead text-muted mb-0">Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte...</p>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="row">
                @foreach($products as $index => $value)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card">
                            <img class="card-img-top" src="{{$value['image']}}" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title">{{$value['title']}}</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <div class="row">
                                    <div class="col">
                                        <p class="btn btn-danger btn-block">{{$value['price']}} ₺</p>
                                    </div>
                                    <div class="col">
                                        <a href="javascript:;" data-id="{{$value['id']}}" class="btn btn-success btn-block add-cart">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>

    </div>
</div>

<!-- Footer -->
<footer class="text-light">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-lg-4 col-xl-3">
                <h5>About</h5>
                <hr class="bg-white mb-2 mt-0 d-inline-block mx-auto w-25">
                <p class="mb-0">
                    Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.
                </p>
            </div>

            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto">
                <h5>Informations</h5>
                <hr class="bg-white mb-2 mt-0 d-inline-block mx-auto w-25">
                <ul class="list-unstyled">
                    <li><a href="">Link 1</a></li>
                    <li><a href="">Link 2</a></li>
                    <li><a href="">Link 3</a></li>
                    <li><a href="">Link 4</a></li>
                </ul>
            </div>

            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto">
                <h5>Others links</h5>
                <hr class="bg-white mb-2 mt-0 d-inline-block mx-auto w-25">
                <ul class="list-unstyled">
                    <li><a href="">Link 1</a></li>
                    <li><a href="">Link 2</a></li>
                    <li><a href="">Link 3</a></li>
                    <li><a href="">Link 4</a></li>
                </ul>
            </div>

            <div class="col-md-4 col-lg-3 col-xl-3">
                <h5>Contact</h5>
                <hr class="bg-white mb-2 mt-0 d-inline-block mx-auto w-25">
                <ul class="list-unstyled">
                    <li><i class="fa fa-home mr-2"></i> My company</li>
                    <li><i class="fa fa-envelope mr-2"></i> email@example.com</li>
                    <li><i class="fa fa-phone mr-2"></i> + 33 12 14 15 16</li>
                    <li><i class="fa fa-print mr-2"></i> + 33 12 14 15 16</li>
                </ul>
            </div>
            <div class="col-12 copyright mt-3">
                <p class="float-left">
                    <a href="#">Back to top</a>
                </p>
                <p class="text-right text-muted">created with <i class="fa fa-heart"></i> by <a href="https://t-php.fr/43-theme-ecommerce-bootstrap-4.html"><i>t-php</i></a> | <span>v. 1.0</span></p>
            </div>
        </div>
    </div>
</footer>
<script>

    $(document).ready(function () {
        $('.add-cart').on('click', function (e) {
            e.preventDefault();
            const id = $(this).attr("data-id");
            $.ajax({
                url: "/cart",
                type: "POST",
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}" },
                data: {product_id: id},
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
