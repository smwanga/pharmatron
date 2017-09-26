<div class="modal-dialog">
    <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title text-uppercase" id="myModalLabel">{{$pagetitle or ''}}</h4>
        </div>     
        <div class="modal-body grid simple vertical horizontal green"> 
        	<style type="text/css">
        		.select2-search {
        			display: none !important;
        		}
        	</style>
        	@yield('modal-body')
        </div>
    </div>
</div>