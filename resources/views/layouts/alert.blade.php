@if(session()->has('error'))
<div class="text-center alert alert-danger alert-dismissible fade show" role="alert">
    <button class="close" data-dismiss="alert" type="button" aria-label="close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{{ session()->get('error') }}</strong>
</div>
@elseif(session()->has('success'))
<div class="text-center alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{{ session()->get('success') }}</strong>
</div>
@endif