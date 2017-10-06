<div class="modal-dialog">
    <div class="modal-content ">
        <style type="text/css">
            .select2-search {
                display: none;
            }
        </style>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title text-uppercase" id="myModalLabel">@lang('main.add_customer')</h4>
        </div>     
        <div class="modal-body grid simple vertical horizontal green">              
            <div class="grid-body">
                <div class="row">
                      <form  id="create-customer" class="form form-horizontal"  style="width: 100% !important;" action="{{ route('customers.save') }}" method="post">
                            {{csrf_field()}}
                        <div class="form-group">
                            <strong class="control-label col-sm-3">@lang('main.customer_name') <span class="text-danger">*</span></strong>
                                <div class="col-sm-8">
                                <input required="" type="text" name="name" class="form-control" placeholder="@lang('main.customer_name')">
                                </div>
                        </div>
                        <div class="form-group">
                             <strong class="control-label col-sm-3">@lang('main.email')</strong>
                               <div class="col-sm-8">
                                <input type="text" name="email" class="form-control" placeholder="@lang('main.email')">
                                </div>
                        </div>
                        <div class="form-group">
                             <strong class="control-label col-sm-3">@lang('main.phone')</strong>
                               <div class="col-sm-8">
                                <input type="text" name="phone_number" class="form-control" placeholder="@lang('main.phone')">
                                </div>
                        </div>
                        <div class="form-group">
                             <strong class="control-label col-sm-3">@lang('main.address')</strong>
                               <div class="col-sm-8">
                                <input type="text" name="address" class="form-control" placeholder="@lang('main.address')">
                                </div>
                        </div>
                        <div class="form-group">
                             <strong class="control-label col-sm-3">@lang('main.city')</strong>
                               <div class="col-sm-8">
                                <input type="text" name="city" class="form-control" placeholder="@lang('main.city')">
                                </div>
                        </div>
                        <div class="form-group">
                            <strong class="control-label col-sm-3">@lang('main.company')</strong>
                            <div class="col-sm-8">
                                 <select class="select2" name="company_id">
                                <optgroup label="Roles">
                                    <option value="" selected disabled=""> @lang('main.select_company') </option>
                                    @foreach($companies as $company)
                                    <option value="{{$company->id}}">{{$company->company_name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-11">
                            <button type="submit" id="add-row" class="btn btn-success pull-right"><i class="fa fa-check"></i> &nbsp; @lang('main.create')</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>                                     
<script type="text/javascript">
        $('.select2').select2({width:'100%'});
        var $customerForm = $('#create-customer');
        if(typeof $customerForm !== 'undefined'){
            $customerForm.on('submit', function(e) {
            e.preventDefault();
            var data = $customerForm.getFormData()
            axios.post($customerForm.attr('action'), data).then(function(response) {
                new PNotify({
                    title: '<h4>Customer Created</h4>',
                    text: '<p class="lead">A new Customer '+response.data.name+' has been added</p>',
                    type: 'success', 
                    icon: 'fa fa-bell-o fa-lg',
                    styling: 'fontawesome'
                });
                $('#modal').modal('hide');
            }).catch(function(error) {
                console.log(error);
            });            
          });
        }

</script>