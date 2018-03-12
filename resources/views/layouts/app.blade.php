
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

  <body v-cloak>

    @guest

    @else

    <div class="hidden-md-down">
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
          <form class="form-inline my-2 my-lg-0" action="/search">
            <input class="form-control mr-sm-2" type="text" name="query" placeholder="{{___('Search')}}" value="{{ request('query') }}">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{___('Search')}}</button>
          </form>
        </div>
      </nav>
    </div>

    <div class="hidden-lg-up">

      <nav class="n/avbar n/avbar-toggleable-md navbar-inverse bg-inverse fixed-top" style="padding: 10px;">

        <a class="navbar-brand display-inline" href="/"> &nbsp; {{___('Tasks') }}</a>

        &nbsp; &nbsp;

              <a class="white-link display-inline" href="/"><i class="fa fa-bars"></i></a> | 
              <a class="white-link display-inline" href="/new"><i class="fa fa-plus"></i></a> | 
              <a class="white-link display-inline" href="/browse/due/today">{{___('Due')}}</a> | 
              <a class="white-link display-inline" href="/browse/late">{{___('Late')}}</a> | 
              <a class="white-link display-inline" href="/browse/pipeline/today">{{___('Pipeline')}}</a> | 
              <a class="white-link display-inline" href="/browse/followups/today">{{___('F/ups')}}</a>

    
      </nav>

      <form class="form-inline" action="/search" style="margin-top: -15px; margin-bottom: 20px">
        <input class="form-control mr-sm-2" type="text" name="query" placeholder="{{___('Search')}}" value="{{ request('query') }}">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{___('Search')}}</button>
      </form>

    </div>


    @endguest

    <div class="container full-width">

        @yield('content')

    </div><!-- /.container -->


    @include('layouts.page-foot')

  </body>
</html>
