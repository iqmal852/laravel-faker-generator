
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Faker Generator</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="/vendor/laravel-faker-generator/css/app.css" rel="stylesheet">
    <link href="/vendor/laravel-faker-generator/css/select2.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="/vendor/laravel-faker-generator/js/jquery.min.js"></script>
    <script src="/vendor/laravel-faker-generator/js/select2.min.js"></script>
    <script src="/vendor/laravel-faker-generator/js/popper.min.js"></script>
    <script src="/vendor/laravel-faker-generator/js/bootstrap.min.js"></script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('laravel-faker-generator.index') }}">
                Laravel Faker Generator
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
    $(document).ready(function() {
        $('.selection2').select2();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</body>
</html>
