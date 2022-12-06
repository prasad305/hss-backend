<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>

    @if (\Session::has('error'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        </div>
    @endif

    <form class="form-horizontal m-t-20" method="POST" action="{{ route('quizUserSubmit') }}">
        @csrf

        <div class="input-group mb-3">
            <input class="form-control" name="phone" type="text" required="" placeholder="+880177738">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input class="form-control" name="email" type="email" required="" placeholder="shohan@gmail.com">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-block btn-warning w-md waves-effect waves-light mb-2"
                    type="submit">submit</button>
            </div>
        </div>

        {{-- <div class="form-group m-t-30 m-b-0">
<div class="col-sm-7">
    <a href="pages-recoverpw.html" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
</div>
<div class="col-sm-5 text-right">
    <a href="pages-register.html" class="text-muted">Create an account</a>
</div>
</div> --}}
    </form>
</body>

</html>
