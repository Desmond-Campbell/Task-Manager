
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>@yield('title')</title>

    @include('layouts.page-head')

  </head>

  <body>

    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="/">Tasks</a>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="/"><i class="fa fa-bars"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/new"><i class="fa fa-plus"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/browse/due/today">{{___('Due')}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/browse/late">{{___('Late')}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/browse/pipeline/today">{{___('Pipeline')}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/browse/followups/today">{{___('Follow-ups')}}</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>

    <div class="container full-width">

        @yield('content')

    </div><!-- /.container -->


    @include('layouts.page-foot')

  </body>
</html>
