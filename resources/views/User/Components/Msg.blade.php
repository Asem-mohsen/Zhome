@if(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@elseif(session('error'))
    <div id='errorMessages' class='ErrorMessages'>
        <div class='alert alert-danger text-center'>
            <i class='fa-regular fa-circle-xmark'></i>
            <p> {{ session('error') }}</p>
        </div>
    </div>
@endif


