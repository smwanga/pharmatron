@extends('users.user-profile')
@section('profile-content')

    <div class="col-sm-12">
        <div class="tiles white">
            <hr>
            <div class="row">
                <div class="sales-graph-heading">
                    <div class="col-md-5 col-sm-5">
                        <h5 class="no-margin">This Year</h5>
                        <h4>
                            <span class="item-count animate-number semi-bold" data-value="21451" data-animation-duration="700">21,451</span> {{app_cry()->symbol_left}}
                        </h4>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <p class="semi-bold">TODAY</p>
                        <h4>
                            <span class="item-count animate-number semi-bold" data-value="451" data-animation-duration="700">451</span> {{app_cry()->symbol_left}}
                        </h4>
                    </div>
                    <div class="col-md-4 col-sm-3">
                        <p class="semi-bold">THIS MONTH</p>
                        <h4>
                            <span class="item-count animate-number semi-bold" data-value="8514" data-animation-duration="700">8,514</span> {{app_cry()->symbol_left}}
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="row white">
                <div class="col-md-4">
                    <table class="table no-more-tables m-t-20">
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
                <div class="col-md-8">
                    <div id="sales-graph">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection