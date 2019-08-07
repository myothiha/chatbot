<div class="row">
    @if(Session::has('message'))
        <div class="col-lg-12">
            <p class="alert alert-{{ Session::get('type') }}">{{ Session::get('message') }} <a href="#" class="close"
                                                                                     data-dismiss="alert"
                                                                                     aria-hidden="true">&times;</a></p>
        </div>
    @endif
</div>