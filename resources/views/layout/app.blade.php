@include('layout.header.header')
        <div id="layoutSidenav">
            @include('layout.sidebar.sidebar')
            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>
@include('layout.footer.footer')