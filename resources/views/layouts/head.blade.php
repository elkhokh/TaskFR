    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{ asset('/') }}css/base.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/vendor.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/main.css">

    <!-- script
    ================================================== -->
    <script src="{{ asset('/') }}js/modernizr.js"></script>

    <!-- favicons
    ================================================== -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/') }}images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/') }}images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/') }}images/favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

    @yield('css')
<style>
.pagination {
    font-size: 1.2rem;
}
.pagination li a,
.pagination li span {
    padding: 8px 12px;
    margin: 2px;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.pagination li a:hover {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.pagination li.active span {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}
</style>
