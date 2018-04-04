{{-- error fallback page --}}

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href={{ url("assets/modules-v2/aksara-backend/css/style.css") }}>
    </head>

    <div class="container">
        <div class="col-md-6">
            <!-- dependencies -->
            <h3><i class="fa fa-times-circle red-icon" style="margin-right: 5px;"></i>Error Occured:</h3>
            <div class="jumbo-bubble error">
                <p>{!! $msg !!}</p>
                <a class="btn btn-xs btn-default" href="{{ $link_url }}" style="margin-top: 20px;">{{ $link_name }}</a>
            </div>
        </div>
    </div>
</div> <!-- container -->
</html>
