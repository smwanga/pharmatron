@extends('layouts.app')

@section('content')
<div class="container-fluid">
<div class="widget-item ">
  <div class="controller overlay right">
    <a href="javascript:;" class="reload"></a>
    <a href="javascript:;" class="remove"></a>
  </div>
                        <div class="tiles green  overflow-hidden full-height" style="max-height:150px">
    <div class="overlayer bottom-right fullwidth">
      <div class="overlayer-wrapper">
        <div class="tiles gradient-black p-l-20 p-r-20 p-b-20 p-t-20">
          <div class="pull-right"> <a href="#" class="hashtags transparent"> <i class="fa fa-chevron-down fa-lg"></i> </a> </div>
          <p class="h2 text-white">{{$supplier->supplier_name}}</p>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <img src="/assets/img/others/10.png" alt="" class="lazy hover-effect-img image-responsive-width"> </div>
   <div class="tiles white ">
    <div class="tiles-body">
      <div class="row">
        <div class="user-profile-pic text-left"> <img width="69" height="69" data-src-retina="/img/avatar.png" data-src="/img/avatar.png" src="/img/avatar.png" alt="">
          <div class="pull-right m-r-20 m-t-35"><div class="btn-group">
                        <button class="btn btn-small btn-white btn-demo-space">Action</button>
                        <button class="btn btn-small btn-white dropdown-toggle btn-demo-space" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span> </button>
                        <ul class="dropdown-menu pull-right">
                          <li><a href="#">Action</a></li>
                          <li><a href="#">Another action</a></li>
                          <li><a href="#">Something else here</a></li>
                          <li class="divider"></li>
                          <li><a href="#">Separated link</a></li>
                        </ul>
                      </div> </div>
        </div>
        <div class="col-md-12 no-padding">
          <div class="tiles white">
            <div class="row">
            <div class="col-md-6 col-vlg-3 col-sm-6">
              <div class="tiles green m-b-10">
                <div class="tiles-body">
                  <div class="tiles-title text-white">OVERALL PAYMENTS </div>
                  <div class="widget-stats">
                    <div class="wrapper transparent">
                      <span class="item-title">Total</span> <span class="item-count animate-number semi-bold" data-value="2415" data-animation-duration="700">2,415</span>
                    </div>
                  </div>
                  <div class="widget-stats">
                    <div class="wrapper transparent">
                      <span class="item-title">Paid Amount</span> <span class="item-count animate-number semi-bold" data-value="751" data-animation-duration="700">751</span>
                    </div>
                  </div>
                  <div class="widget-stats ">
                    <div class="wrapper last">
                      <span class="item-title">Due Amount</span> <span class="item-count animate-number semi-bold" data-value="1547" data-animation-duration="700">1,547</span>
                    </div>
                  </div>
                  <div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
                    <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="64.8%" style="width: 64.8%;"></div>
                  </div>
                  <div class="description"> <span class="text-white mini-description ">4% Paid out</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-vlg-3 col-sm-6">
              <div class="tiles blue m-b-10">
                <div class="tiles-body">
                  <div class="tiles-title text-white">OVERALL ORDERS </div>
                  <div class="widget-stats">
                    <div class="wrapper transparent">
                      <span class="item-title">Overall Visits</span> <span class="item-count animate-number semi-bold" data-value="15489" data-="" animation-duration="700">15,489</span>
                    </div>
                  </div>
                  <div class="widget-stats">
                    <div class="wrapper transparent">
                      <span class="item-title">Today's</span> <span class="item-count animate-number semi-bold" data-value="551" data-animation-duration="700">551</span>
                    </div>
                  </div>
                  <div class="widget-stats ">
                    <div class="wrapper last">
                      <span class="item-title">Monthly</span> <span class="item-count animate-number semi-bold" data-value="1450" data-animation-duration="700">1,450</span>
                    </div>
                  </div>
                  <div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
                    <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="54%" style="width: 54%;"></div>
                  </div>
                  <div class="description"> <span class="text-white mini-description ">4% higher <span class="blend">than last month</span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
                <div class="row">
                  <div class="sales-graph-heading">
                    <div class="col-md-5 col-sm-5">
                      <h5 class="no-margin">You have earned</h5>
                      <h4><span class="item-count animate-number semi-bold" data-value="21451" data-animation-duration="700">21,451</span> USD</h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                      <p class="semi-bold">TODAY</p>
                      <h4><span class="item-count animate-number semi-bold" data-value="451" data-animation-duration="700">451</span> USD</h4>
                    </div>
                    <div class="col-md-4 col-sm-3">
                      <p class="semi-bold">THIS MONTH</p>
                      <h4><span class="item-count animate-number semi-bold" data-value="8514" data-animation-duration="700">8,514</span> USD</h4>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
                <h5 class="semi-bold m-t-30 m-l-30">LAST SALE</h5>
                <table class="table no-more-tables m-t-20 m-l-20 m-b-30">
                  <thead style="display:none">
                    <tr>
                      <th style="width:9%">Project Name</th>
                      <th style="width:22%">Description</th>
                      <th style="width:6%">Price</th>
                      <th style="width:1%"> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="v-align-middle bold text-success">25601</td>
                      <td class="v-align-middle"><span class="muted">Redesign project template</span> </td>
                      <td><span class="muted bold text-success">$4,500</span> </td>
                      <td class="v-align-middle"></td>
                    </tr>
                    <tr>
                      <td class="v-align-middle bold text-success">25601</td>
                      <td class="v-align-middle"><span class="muted">Redesign project template</span> </td>
                      <td><span class="muted bold text-success">$4,500</span> </td>
                      <td class="v-align-middle"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
</div>
@endsection