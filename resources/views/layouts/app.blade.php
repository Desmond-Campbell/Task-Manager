
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>@yield('title')</title>

	<link rel="icon" href="https://img.icons8.com/color/48/000000/tasklist.png" />

    @include('layouts.page-head')

  </head>

  <body v-cloak>

    @guest

    @else

    <div id="NavController">
    
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
                <a class="nav-link" href="/dashboard">{{___('Dashboard')}}</a>
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
              <li class="nav-item">
                <a class="nav-link" href="{{ get_reminders_link() }}">&nbsp;<i class="fa fa-bell"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="javascript:;" @click="toggleSchedule()">&nbsp;<i class="fa fa-calendar"></i></a>
              </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="/search">
              <a href="{{ get_index_link() }}" class="btn btn-outline-default my-2 my-sm-0" style="color: #FFF"><i class="fa fa-search-plus"></i></a>
              <input class="form-control mr-sm-2" type="text" name="query" placeholder="{{___('Search')}}" value="{{ request('query') }}">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{___('Search')}}</button>
            </form>
          </div>
        </nav>
      </div>

      <div class="hidden-lg-up">

        <nav class="n/avbar n/avbar-toggleable-md navbar-inverse bg-inverse fixed-top" style="padding: 10px;">

          <a class="white-link display-inline" href="/browse/working">&nbsp;<i class="fa fa-bars"></i>&nbsp; </a> &nbsp;
          <a class="white-link display-inline" href="/dashboard">&nbsp;<i class="fa fa-th-large"></i>&nbsp; </a> &nbsp;
          <a class="white-link display-inline" href="/new">&nbsp;<i class="fa fa-plus"></i>&nbsp; </a> &nbsp;
          <a class="white-link display-inline" href="/browse/due/today">&nbsp;<i class="fa fa-clock"></i>&nbsp;</a> &nbsp;
          <a class="white-link display-inline" href="/browse/late">&nbsp;<i class="fa fa-exclamation-triangle"></i>&nbsp;</a>
          <a class="white-link display-inline" href="/browse/pipeline/today">&nbsp;<i class="fa fa-transfer"></i>&nbsp;</a> &nbsp;
          <a class="white-link display-inline" href="/browse/followups/today">&nbsp;<i class="fa fa-share"></i>&nbsp;</a> &nbsp;
          <a class="white-link display-inline" href="{{ get_index_link() }}">&nbsp;<i class="fa fa-search-plus"></i></a>&nbsp;
          <a class="white-link display-inline" href="/search">&nbsp;<i class="fa fa-search"></i></a>
          <a class="white-link display-inline" href="{{ get_reminders_link() }}">&nbsp;<i class="fa fa-bell"></i></a>
          <a class="white-link display-inline" href="javascript:;" @click="toggleSchedule()">&nbsp;<i class="fa fa-calendar"></i></a>

        </nav>

      </div>

      <div id="schedule" v-show="showSchedule">

        <table class="table" style="position:fixed; width:100%; background: #FFF; filter: alpha(opacity=90); opacity: 0.9">

          <tr>
            <td width="5.5%">&nbsp;</td>
            <td align="center" width="13.5%"><a href="javascript:;" @click="getSchedule(-1)"><i class="fa fa-chevron-left"></i> {{ ___('S') }}</a></td>
            <td align="center" width="13.5%">{{ ___('M') }}</td>
            <td align="center" width="13.5%">{{ ___('T') }}</td>
            <td align="center" width="13.5%"><a href="javascript:;" @click="reset()">{{ ___('W') }}</a></td>
            <td align="center" width="13.5%">{{ ___('T') }}</td>
            <td align="center" width="13.5%">{{ ___('F') }}</td>
            <td align="center" width="13.5%"><a href="javascript:;" @click="getSchedule(1)"><i class="fa fa-chevron-right"></i> {{ ___('S') }}</a></td>
          </tr>
          <tr>
            <td></td>
            <td align="center" v-for="d in schedule_dates">@{{ d }}</td>
          </tr>
          
        </table>

        <table class="table schedule-day-columns">

          <tr>
            <td colspan="8">&nbsp;
            </td>
          </tr>
          <tr>
            <td colspan="8">&nbsp;
            </td>
          </tr>

          <tr v-for="h in hours">

            <td width="5.5%">@{{ h }}</td>
            <td width="13.5%" class="schedule-task-list" v-for="(d, day) in days" align="center">
              <div v-if="typeof tasks[day] !== 'undefined'">
                <div v-for="t in tasks[day][h]">
                <a :href="'/edit/' + t.id"><span :class="{ 'strikeout faded' : t.completed }">@{{t.title}} [@{{days_short[day]}}]</span></a>
                <br />
                <span class="help-block"><small>@{{ t.start_date_full | moment( "HH:mm" )}} - @{{ t.due_date_full | moment( "HH:mm (D)" )}}</small></span>
                </div>
              </div>
            </td>
          </tr>

        </table>

      </div>

    </div>

    @endguest

    <div class="container full-width">

        @yield('content')

    </div><!-- /.container -->


    @include('layouts.page-foot')

  </body>
</html>
