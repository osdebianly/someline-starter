@extends('admin.angulr.layout.frame')

@section('content')

    <div class="app-content-body ">


        <div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="
    app.settings.asideFolded = true;
    app.settings.asideDock = true;
  ">
            <!-- main -->
            <div class="col">
                <div class="bg-black dker wrapper-lg" ng-controller="FlotChartDemoCtrl">
                    <ul class="nav nav-pills nav-xxs nav-rounded m-b-lg">
                        <li class="active"><a href="">Day</a></li>
                        <li><a href="" ng-click="refreshData()">Week</a></li>
                        <li><a href="" ng-click="refreshData()">Month</a></li>
                    </ul>
                    <div ui-jq="plot" ui-refresh="d0_1" ui-options="
        [
          { data: [ [0,7],[1,6.5],[2,12.5],[3,7],[4,9],[5,6],[6,11],[7,6.5],[8,8],[9,7] ], points: { show: true, radius: 2}, splines: { show: true, tension: 0.4, lineWidth: 1 } }
        ],
        {
          colors: ['#23b7e5', '#7266ba'],
          series: { shadowSize: 3 },
          xaxis:{ font: { color: '#507b9b' } },
          yaxis:{ font: { color: '#507b9b' }, max:16 },
          grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#1c2b36' },
          tooltip: true,
          tooltipOpts: { content: 'Visits of %x.1 is %y.4',  defaultTheme: false, shifts: { x: 10, y: -25 } }
        }
      " style="min-height: 360px; padding: 0px; position: relative;">
                        <canvas class="flot-base"
                                style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 873px; height: 360px;"
                                width="1746" height="720"></canvas>
                        <div class="flot-text"
                             style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);">
                            <div class="flot-x-axis flot-x1-axis xAxis x1Axis"
                                 style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                                <div style="position: absolute; max-width: 87px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 14px; text-align: center;">
                                    0
                                </div>
                                <div style="position: absolute; max-width: 87px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 108px; text-align: center;">
                                    1
                                </div>
                                <div style="position: absolute; max-width: 87px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 203px; text-align: center;">
                                    2
                                </div>
                                <div style="position: absolute; max-width: 87px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 297px; text-align: center;">
                                    3
                                </div>
                                <div style="position: absolute; max-width: 87px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 392px; text-align: center;">
                                    4
                                </div>
                                <div style="position: absolute; max-width: 87px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 486px; text-align: center;">
                                    5
                                </div>
                                <div style="position: absolute; max-width: 87px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 581px; text-align: center;">
                                    6
                                </div>
                                <div style="position: absolute; max-width: 87px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 675px; text-align: center;">
                                    7
                                </div>
                                <div style="position: absolute; max-width: 87px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 770px; text-align: center;">
                                    8
                                </div>
                                <div style="position: absolute; max-width: 87px; top: 347px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 864px; text-align: center;">
                                    9
                                </div>
                            </div>
                            <div class="flot-y-axis flot-y1-axis yAxis y1Axis"
                                 style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                                <div style="position: absolute; top: 336px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 6px; text-align: right;">
                                    4
                                </div>
                                <div style="position: absolute; top: 280px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 6px; text-align: right;">
                                    6
                                </div>
                                <div style="position: absolute; top: 224px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 6px; text-align: right;">
                                    8
                                </div>
                                <div style="position: absolute; top: 168px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 0px; text-align: right;">
                                    10
                                </div>
                                <div style="position: absolute; top: 112px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 0px; text-align: right;">
                                    12
                                </div>
                                <div style="position: absolute; top: 56px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 0px; text-align: right;">
                                    14
                                </div>
                                <div style="position: absolute; top: 1px; font-style: normal; font-variant: normal; font-weight: 400; font-stretch: normal; font-size: 11px; line-height: 13px; font-family: &quot;Source Sans Pro&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(80, 123, 155); left: 0px; text-align: right;">
                                    16
                                </div>
                            </div>
                        </div>
                        <canvas class="flot-overlay"
                                style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 873px; height: 360px;"
                                width="1746" height="720"></canvas>
                    </div>
                </div>
                <div class="wrapper-md bg-white-only b-b">
                    <div class="row text-center">
                        <div class="col-sm-3 col-xs-6">
                            <div>Users <i class="fa fa-fw fa-caret-up text-success text-sm"></i></div>
                            <div class="h2 m-b-sm">219k</div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div>Items <i class="fa fa-fw fa-caret-down text-warning text-sm"></i></div>
                            <div class="h2 m-b-sm">1230</div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div>Orders <i class="fa fa-fw fa-caret-up text-success text-sm"></i></div>
                            <div class="h2 m-b-sm">2839</div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div>Visits <i class="fa fa-fw fa-caret-down text-danger text-sm"></i></div>
                            <div class="h2 m-b-sm">2,300</div>
                        </div>
                    </div>
                </div>
                <div class="wrapper-md">
                    <div class="row text-center">
                        <div class="col-sm-3 col-xs-6">
                            <div>Todays activity</div>
                            <div ui-jq="easyPieChart" ui-options="{
              percent: 75,
              lineWidth: 4,
              trackColor: '#e8eff0',
              barColor: '#7266ba',
              scaleColor: false,
              size: 115,
              rotate: 90,
              lineCap: 'butt'
            }" class="inline m-t easyPieChart" style="width: 115px; height: 115px; line-height: 115px;">
                                <div>
                                    <span class="text-primary h3">75%</span>
                                </div>
                                <canvas width="230" height="230" style="width: 115px; height: 115px;"></canvas>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div>Active Players</div>
                            <div ui-jq="easyPieChart" ui-options="{
              percent: 35,
              lineWidth: 4,
              trackColor: '#e8eff0',
              barColor: '#23b7e5',
              scaleColor: false,
              size: 115,
              rotate: 0,
              lineCap: 'butt'
            }" class="inline m-t easyPieChart" style="width: 115px; height: 115px; line-height: 115px;">
                                <div>
                                    <span class="text-info h3">35%</span>
                                </div>
                                <canvas width="230" height="230" style="width: 115px; height: 115px;"></canvas>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div>Weekly Changes</div>
                            <div ui-jq="easyPieChart" ui-options="{
              percent: 50,
              lineWidth: 4,
              trackColor: '#e8eff0',
              barColor: '#fad733',
              scaleColor: false,
              size: 115,
              rotate: 180,
              lineCap: 'butt'
            }" class="inline m-t easyPieChart" style="width: 115px; height: 115px; line-height: 115px;">
                                <div>
                                    <span class="text-warning h3">50%</span>
                                </div>
                                <canvas width="230" height="230" style="width: 115px; height: 115px;"></canvas>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div>Monthly Changes</div>
                            <div ui-jq="easyPieChart" ui-options="{
              percent: 60,
              lineWidth: 4,
              trackColor: '#e8eff0',
              barColor: '#27c24c',
              scaleColor: false,
              size: 115,
              rotate: 90,
              lineCap: 'butt'
            }" class="inline m-t easyPieChart" style="width: 115px; height: 115px; line-height: 115px;">
                                <div>
                                    <span class="text-success h3">60%</span>
                                </div>
                                <canvas width="230" height="230" style="width: 115px; height: 115px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapper-md">
                    <!-- users -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel no-border">
                                <div class="panel-heading wrapper b-b b-light">
              <span class="text-xs text-muted pull-right">
                <i class="fa fa-circle text-primary m-r-xs"></i> 12
                <i class="fa fa-circle text-info m-r-xs m-l-sm"></i> 30
                <i class="fa fa-circle text-warning m-r-xs m-l-sm"></i> 98
              </span>
                                    <h5 class="font-thin m-t-none m-b-none text-muted">Teammates</h5>
                                </div>
                                <ul class="list-group list-group-lg m-b-none">
                                    <li class="list-group-item">
                                        <a href="" class="thumb-sm m-r">
                                            <img src="img/a1.jpg" class="r r-2x">
                                        </a>
                                        <span class="pull-right label bg-primary inline m-t-sm">Admin</span>
                                        <a href="">Damon Parker</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="" class="thumb-sm m-r">
                                            <img src="img/a2.jpg" class="r r-2x">
                                        </a>
                                        <span class="pull-right label bg-info inline m-t-sm">Member</span>
                                        <a href="">Joe Waston</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="" class="thumb-sm m-r">
                                            <img src="img/a3.jpg" class="r r-2x">
                                        </a>
                                        <span class="pull-right label bg-warning inline m-t-sm">Editor</span>
                                        <a href="">Jannie Dvis</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="" class="thumb-sm m-r">
                                            <img src="img/a4.jpg" class="r r-2x">
                                        </a>
                                        <span class="pull-right label bg-warning inline m-t-sm">Editor</span>
                                        <a href="">Emma Welson</a>
                                    </li>
                                </ul>
                                <div class="panel-footer">
                                    <span class="pull-right badge badge-bg m-t-xs">32</span>
                                    <button class="btn btn-primary btn-addon btn-sm"><i class="fa fa-plus"></i>Add
                                        Teammate
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="list-group list-group-lg list-group-sp">
                                <a herf="" class="list-group-item clearfix">
              <span class="pull-left thumb-sm avatar m-r">
                <img src="img/a4.jpg" alt="...">
                <i class="on b-white right"></i>
              </span>
              <span class="clear">
                <span>Chris Fox</span>
                <small class="text-muted clear text-ellipsis">What's up, buddy</small>
              </span>
                                </a>
                                <a herf="" class="list-group-item clearfix">
              <span class="pull-left thumb-sm avatar m-r">
                <img src="img/a5.jpg" alt="...">
                <i class="on b-white right"></i>
              </span>
              <span class="clear">
                <span>Amanda Conlan</span>
                <small class="text-muted clear text-ellipsis">Come online and we need talk about the plans that we have discussed</small>
              </span>
                                </a>
                                <a herf="" class="list-group-item clearfix">
              <span class="pull-left thumb-sm avatar m-r">
                <img src="img/a6.jpg" alt="...">
                <i class="busy b-white right"></i>
              </span>
              <span class="clear">
                <span>Dan Doorack</span>
                <small class="text-muted clear text-ellipsis">Hey, Some good news</small>
              </span>
                                </a>
                                <a herf="" class="list-group-item clearfix">
              <span class="pull-left thumb-sm avatar m-r">
                <img src="img/a7.jpg" alt="...">
                <i class="busy b-white right"></i>
              </span>
              <span class="clear">
                <span>Lauren Taylor</span>
                <small class="text-muted clear text-ellipsis">Nice to talk with you.</small>
              </span>
                                </a>
                                <a herf="" class="list-group-item clearfix">
              <span class="pull-left thumb-sm avatar m-r">
                <img src="img/a8.jpg" alt="...">
                <i class="away b-white right"></i>
              </span>
              <span class="clear">
                <span>Mike Jackson</span>
                <small class="text-muted clear text-ellipsis">This is nice</small>
              </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- / users -->
                </div>
            </div>
            <!-- / main -->
            <!-- right col -->
            <div class="col w-md bg-black dk bg-auto">
                <div class="wrapper">
                    <div class="m-b-sm text-md">Who to follow</div>
                    <ul class="list-group no-bg no-borders pull-in">
                        <li class="list-group-item">
                            <a herf="" class="pull-left thumb-sm avatar m-r">
                                <img src="img/a4.jpg" alt="..." class="img-circle">
                                <i class="on b-white bottom"></i>
                            </a>
                            <div class="clear">
                                <div><a href="">Chris Fox</a></div>
                                <small class="text-muted">Designer, Blogger</small>
                            </div>
                        </li>
                        <li class="list-group-item active">
                            <a herf="" class="pull-left thumb-sm avatar m-r">
                                <img src="img/a5.jpg" alt="..." class="img-circle">
                                <i class="on b-white bottom"></i>
                            </a>
                            <div class="clear">
                                <div><a href="">Mogen Polish</a></div>
                                <small class="text-muted">Writter, Mag Editor</small>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <a herf="" class="pull-left thumb-sm avatar m-r">
                                <img src="img/a6.jpg" alt="..." class="img-circle">
                                <i class="busy b-white bottom"></i>
                            </a>
                            <div class="clear">
                                <div><a href="">Joge Lucky</a></div>
                                <small class="text-muted">Art director, Movie Cut</small>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <a herf="" class="pull-left thumb-sm avatar m-r">
                                <img src="img/a7.jpg" alt="..." class="img-circle">
                                <i class="away b-white bottom"></i>
                            </a>
                            <div class="clear">
                                <div><a href="">Folisise Chosielie</a></div>
                                <small class="text-muted">Musician, Player</small>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <a herf="" class="pull-left thumb-sm avatar m-r">
                                <img src="img/a8.jpg" alt="..." class="img-circle">
                                <i class="away b-white bottom"></i>
                            </a>
                            <div class="clear">
                                <div><a href="">Aron Gonzalez</a></div>
                                <small class="text-muted">Designer</small>
                            </div>
                        </li>
                    </ul>
                    <div class="text-center">
                        <a href="" class="btn btn-sm btn-primary padder-md m-b">More Connections</a>
                    </div>
                </div>
            </div>
            <!-- / right col -->
        </div>


    </div>
    <example></example>

@endsection
