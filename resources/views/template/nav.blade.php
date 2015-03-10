<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#meme-navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ URL::to('') }}">MemeSpawner</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="meme-navbar">
      <ul class="nav navbar-nav">
        <li id="meme-nav-generator"><a href="{{ URL::to('') }}">
          <i class="fa fa-plus fa-fw"></i> Spawn
        </a></li>
        <li id="meme-nav-viewer"><a href="{{ URL::to('view') }}">
          <i class="fa fa-search fa-fw"></i> View
        </a></li>
        <li id="meme-nav-manage"><a href="{{ URL::to('manage') }}">
          <i class="fa fa-cog fa-fw"></i> Manage
        </a></li>
      </ul><!-- /.nav.navbar-nav -->
      @yield('navbar-right', '')
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
