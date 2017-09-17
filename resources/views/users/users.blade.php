@extends('layouts.app')

@section('content')
    <div class="row-fluid">
		<h2>Users</h2>
        <div class="grid simple">
        <div class="searchable-container grid-body">
            <div class="col-lg-12 form-group">
                <input type="search" class="form-control" id="input-search" placeholder="Search Users..." >
            </div>
            @foreach($users as $user)
            <div class="items col-xs-12 col-sm-12 col-md-6 col-lg-6 clearfix">
               <div class="info-block block-info clearfix">
                    <div class="col-xs-4">
                        <div class="square-box pull-left">
                            <span class="glyphicon glyphicon-user glyphicon-lg"></span>
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <div class="pull-right">
                            <div class="btn-group">
                                <button class="btn btn-small btn-white dropdown-toggle btn-demo-space btn-rounded" data-toggle="dropdown" aria-expanded="false" style="border-radius: 50%;"> <span class="fa fa-ellipsis-v"></span> </button>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </div> 
                        </div>
                        <p>
                            <i class="glyphicon glyphicon-user"></i>: 
                            &nbsp; <strong>{{$user->name}}</strong>
                        </p>
                        <p>
                            <i class="fa fa-envelope-o"></i> : 
                            &nbsp; {{$user->email}}
                        </p>
                         <p>
                            <i class="fa fa-cog"></i> :
                             &nbsp; {{optional($user->roles->first())->name ?: 'N/A'}}
                         </p>
                     </div>
                </div>

            </div>
            @endforeach
        </div>
	</div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
      $(function() {    
        $('#input-search').on('keyup', function() {
          var rex = new RegExp($(this).val(), 'i');
            $('.searchable-container .items').hide();
            $('.searchable-container .items').filter(function() {
                return rex.test($(this).text());
            }).show();
        });
    });
</script>
@endpush