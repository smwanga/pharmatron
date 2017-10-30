@extends('settings.app-settings')
@section('content')
<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div class="grid simple horizontal green">
    <div class="grid-title">
        Application Backups
    </div>
    <div class="grid-body">
        <div class="row m-t-10 m-b-20">
            <a class="btn btn-primary pull-right" href="{{route('backup.create')}}">Create Backup</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Backup Name</th>
                    <th>Size</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($backups as $key => $backup)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$backup->path()}}</td>
                    <td>{{Spatie\Backup\Helpers\Format::getHumanReadableSize($backup->size())}}</td>
                    <td>{{$backup->date()->format('l d F Y')}}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-white btn-small" data-toggle="dropdown">Options</button>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="{{route('backup.download')}}?file={{$backup->path()}}"> Download File</a>
                                </li>
                                <li>
                                    <a href="{{route('backup.delete')}}?file={{$backup->path()}}"> Delete File</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- END PAGE -->
@endsection