@include('partials/main')

<head>
    @include('partials/title-meta', ['title' => 'Login'])
    @include('partials/head-css')
</head>

<body class="auth-body-bg">
    <div class="bg-overlay"></div>
    <div class="wrapper-page">
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-body">

                    <div class="text-center mt-4">
                        <div class="mb-3">
                            <a href="index.html" class="auth-logo">
                                <img src={{ asset('assets/images/logo-dark.png') }} height="30"
                                    class="logo-dark mx-auto" alt="">
                                <img src={{ asset('assets/images/logo-light.png') }} height="30"
                                    class="logo-light mx-auto" alt="">
                            </a>
                        </div>
                    </div>

                    <h4 class="text-muted text-center font-size-18 mt-3"><b>Masuk</b></h4>
                    <div class="p-3">

                        @if (Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        <form class="form-horizontal" method="POST" action="{{ route('proses.login') }}">
                            @csrf

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" type="text" required="" placeholder="NIP/NISN"
                                        name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" type="password" required="" placeholder="Password"
                                        name="password">
                                </div>
                            </div>

                            {{-- <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="form-label ms-1" for="customCheck1">Ingat Saya</label>
                                        </div>
                                    </div>
                                </div> --}}

                            <div class="form-group mb-3 text-center row mt-3 pt-1">
                                <div class="col-12">
                                    <button class="btn btn-info w-100 waves-effect waves-light"
                                        type="submit">Masuk</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <!-- end -->
                </div>
                <!-- end cardbody -->
            </div>
            <!-- end card -->
        </div>
        <!-- end container -->
    </div>
    <!-- end -->
    @include('partials/vendor-scripts')
    <script src={{ asset('assets/js/app.js') }}></script>
</body>

</html>
