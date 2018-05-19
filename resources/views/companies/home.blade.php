@extends('companies.company-profile')
@section('profile-content')
<div class="col-sm-12">
           <div class="tiles white add-margin">
                    <div class="p-t-20 p-l-20 p-r-20 p-b-20">
                      <div class="row b-grey b-b">
                        <div class="col-md-4 col-sm-4">
                          <h4 class="text-black semi-bold">Total Invoice Amount</h4>
                          <h3 class="text-success semi-bold">{{app_cry()->symbol_left}}. &nbsp;<span data-animation-duration="600" data-value="{{number_format($total,2)}}" class="animate-number">{{number_format($total,2)}}</span></h3>
                        </div>
                        <div class="col-md-3 col-sm-3">
                          <div class="m-t-20">
                            <h5 class="text-black semi-bold">Total due</h5>
                            <h4 class="text-success semi-bold">{{app_cry()->symbol_left}}. &nbsp;<span data-animation-duration="600" data-value="{{number_format($due,2)}}" class="animate-number">{{number_format($due,2)}}</span></h4>
                          </div>
                        </div>
                        <div class="col-md-5 col-sm-5 xs-m-b-20">
                          <div class="m-t-20">
                            <form id="search-form">
                                <div class="input-group">
                                <input value="{{request('query')}}" type="text" class="form-control" data-toggle="tooltip" name="query" placeholder="Search Person">
                                <span class="input-group-addon primary" style="cursor: pointer;" onclick="$('#search-form').submit()">     
                                  <span class="arrow"></span>
                                <i class="fa fa-search"></i>
                                 Search
                                </span>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tiles white add-margin"> 
                       <h5 class="semi-bold m-t-30 m-l-30">@lang('main.people')</h5>
                <table class="table no-more-tables m-t-20 m-l-20 m-b-30">
                  <thead>
                    <tr>
                      <th>@lang('main.name')</th>
                      <th>@lang('main.email')</th>
                      <th>@lang('main.phone')</th>
                      <th>@lang('main.address') </th>
                      <th>@lang('main.total') </th>
                      <th>@lang('main.due_amount') </th>
                      <th>...</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($people as $person)
                    <tr>
                      <td class="v-align-middle bold">{{$person->name}}</td>
                      <td class="v-align-middle"><span class="muted">{{$person->email}}</span> </td>
                      <td><span class="muted bold text-success">{{$person->phone_number}}</span> </td>
                      <td class="v-align-middle">{{$person->address}}</td>
                      <td class="v-align-middle">{{$person->invoices->map(function ($sale) {
                                                                                return $sale->total;
                                                                            })->sum()}}
                        </td>
                        <td class="v-align-middle">{{$person->invoices->map(function ($sale) {
                                                                                return $sale->due;
                                                                            })->sum()}}
                        </td>
                      <td>
                        <div class="btn-group">
                          <a data-url="{{ route('companies.people.edit', $person->id) }}" class="ajaxModal btn btn-mini btn-success"><i class="fa fa-pencil"></i></a>
                          <a data-url="{{ route('companies.people.delete', $person->id) }}" class="btn btn-mini btn-danger delete-btn" data-name="@lang('main.person')"><i class="fa fa-trash"></i></a>
                        </div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="5"><center>
                        @if(request('query'))
                          <h5>There are no search results found for '{{request('query')}}' </h5>
                          <a class="ajaxModal btn btn-primary" data-url="{{ route('companies.people.add', $company->id) }}">
                            <i class="fa fa-plus"></i> &nbsp; @lang('main.add_person')</a>
                        @else
                        <h5>There are no people added for this company </h5>
                          <a class="ajaxModal btn btn-primary" data-url="{{ route('companies.people.add', $company->id) }}">
                            <i class="fa fa-plus"></i> &nbsp; @lang('main.add_person')</a>
                        @endif
                      </center></td>
                    </tr>
                    @endforelse
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="5" class="text-center">
                        {!! $people->render() !!}
                      </td>
                    </tr>
                  </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection