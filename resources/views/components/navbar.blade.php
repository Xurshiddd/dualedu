<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="navbar-brand">
            <a href="/"><img src="/uz.png" style="max-width: 190px;" alt="logo"></a>
        </div>
    </div>

    <div class="header-right">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn text-black">Log out</button>
        </form>
    </div>
</nav>
