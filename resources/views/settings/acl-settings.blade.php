@extends('settings.app-settings')
@section('content')
<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div class="grid simple">
    <div class="grid-title">
        @lang('main.roles_and_permissions')
    </div>
    <div class="grid-body">
       {{--  <div class="row">
            <div class="pull-right">
                <button data-toggle="dropdown" class="btn btn-white btn-small"><i class="fa fa-caret-down"></i> @lang('main.options')</button>
                <ul class="dropdown-menu">
                    <li><a data-url="{{ route('abilities.create') }}" class="ajaxModal"><i class="fa fa-key"></i> &nbsp; New Permission</a></li>
                    <li><a href=""><i class="fa fa-users"></i> &nbsp; New Role</a></li>
                </ul>
            </div>
        </div> --}}
        <div class="row">
            <div class="">
                <ul class="nav nav-tabs nav-tabs-alt nav-justified" role="tablist">
                    @foreach($roles as $role)
                    <li {{$role->id == $group->id ? 'class=active' : ''}}>
                        <a  href="{{ route('settings.acl.index', $role->name) }}" >{{$role->name}}</a>
                    </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="grid">
                            <div class="grid-title">
                                <strong>@lang('main.role_permissions', ['role' => $group->name])</strong>
                            </div>
                            <div class="grid-body">
                                <form method="post" action="{{ route('settings.acl.update', $group->id) }}">
                                    {{csrf_field()}}
                                    {{method_field('patch')}}
                                    <table class="table table-condensed">
                                        <tbody>
                                            @foreach($abilities as $ability)
                                            <tr>
                                                <td>     
                                                    <label class="switch mini">
                                                        <input type="checkbox" name="abilities[]" value="{{$ability->name}}" {{$group->hasAbility($ability->name) ? 'checked' : ''}}>
                                                        <span class="slider"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    {{$ability->name}}
                                                </td>
                                                <td>
                                                    {{$ability->title}}
                                                </td>
                                                <td>
                                                    <a data-url="{{ route('abilities.edit', $ability->id) }}" class="ajaxModal btn btn-mini btn-primary"> <i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">
                                                    <button class="btn btn-primary pull-right"><i class="fa fa-unlock"></i> &nbsp; @lang('main.give_abilities')</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE -->
@endsection