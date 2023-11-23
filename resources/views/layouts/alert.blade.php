@if(Session::has('danger'))
<div class="col-12">
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> Ошибка!</h5>
        {{ Session::get('danger') }}
    </div>
</div>
@endif

@if(Session::has('info'))
<div class="col-12">
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Информация!</h5>
        {{ Session::get('info') }}
    </div>
</div>
@endif

@if(Session::has('warning'))
<div class="col-12">
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> Внимание!</h5>
        {{ Session::get('warning') }}
    </div>
</div>
@endif

@if(Session::has('success'))
<div class="col-12">
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Успешно!</h5>
        {{ Session::get('success') }}
    </div>
</div>
@endif
