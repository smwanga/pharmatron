@extends('suppliers.supplier-profile')
@section('profile-content')
<div class="row">
            <div class="col-md-12 col-vlg-12 col-sm-12">
              <div class="tiles green m-b-10">
                <div class="tiles-body">
                  <div class="tiles-title text-white">OVERALL PAYMENTS </div>
                  <div class="widget-stats">
                    <div class="wrapper transparent">
                      <span class="item-title">Total</span> <span class="item-count animate-number semi-bold" data-value="{{$payments->sum('total')}}" data-animation-duration="700">{{$payments->sum('total')}}</span>
                    </div>
                  </div>
                  <div class="widget-stats">
                    <div class="wrapper transparent">
                      <span class="item-title">Paid Amount</span> <span class="item-count animate-number semi-bold" data-value="{{$payments->sum('paid')}}" data-animation-duration="700">{{$payments->sum('paid')}}</span>
                    </div>
                  </div>
                  <div class="widget-stats ">
                    <div class="wrapper last">
                      <span class="item-title">Due Amount</span> <span class="item-count animate-number semi-bold" data-value="{{$payments->sum('due')}}" data-animation-duration="700">{{$payments->sum('due')}}</span>
                    </div>
                  </div>
                  <div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
                    <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="{{number_format(($payments->sum('paid')/$payments->sum('total') * 100),2)}}%" style="width: 64.8%;"></div>
                  </div>
                  <div class="description"> <span class="text-white mini-description ">{{number_format(($payments->sum('paid')/$payments->sum('total') * 100),2)}}% Paid out</span>
                  </div>
                </div>
              </div>
            </div>
{{--             <div class="col-md-6 col-vlg-3 col-sm-6">
              <div class="tiles blue m-b-10">
                <div class="tiles-body">
                  <div class="tiles-title text-white">OVERALL ORDERS </div>
                  <div class="widget-stats">
                    <div class="wrapper transparent">
                      <span class="item-title">Orders</span> <span class="item-count animate-number semi-bold" data-value="15489" data-="" animation-duration="700">15,489</span>
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
            </div> --}}
          </div>

                <h5 class="semi-bold m-t-30 m-l-30">@lang('main.contacts')</h5>
                <table class="table no-more-tables m-t-20 m-l-20 m-b-30">
                  <thead>
                    <tr>
                      <th>@lang('main.name')</th>
                      <th>@lang('main.email')</th>
                      <th>@lang('main.phone')</th>
                      <th>@lang('main.address') </th>
                      <th>...</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contacts as $contact)
                    <tr>
                      <td class="v-align-middle bold">{{$contact->name}}</td>
                      <td class="v-align-middle"><span class="muted">{{$contact->email}}</span> </td>
                      <td><span class="muted bold text-success">{{$contact->phone_number}}</span> </td>
                      <td class="v-align-middle">{{$contact->address}}</td>
                      <td>
                        <div class="btn-group">
                          <a data-url="{{ route('suppliers.contacts.edit', $contact->id) }}" class="ajaxModal btn btn-mini btn-success"><i class="fa fa-pencil"></i></a>
                          <a data-url="{{ route('suppliers.contacts.delete', $contact->id) }}" class="btn btn-mini btn-danger delete-btn" data-name="@lang('main.contact')"><i class="fa fa-trash"></i></a>
                        </div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="5"><center>
                          <h5>There are no contacts available </h5>
                          <a class="ajaxModal btn btn-primary" data-url="{{ route('suppliers.contacts.add', $supplier->id) }}">
                            <i class="fa fa-plus"></i> &nbsp; @lang('main.add_contact')</a>
                      </center></td>
                    </tr>
                    @endforelse
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="5" class="text-center">
                        {!! $contacts->render() !!}
                      </td>
                    </tr>
                  </tfoot>
                </table>
@endsection