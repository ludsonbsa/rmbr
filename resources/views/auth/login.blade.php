@extends(layout())



@section('content')
<div class="container">
    <div class="row">
        <div class="logo col-md-6 col-md-offset-2">
            <img src="<?= env('APP_URL').'/images/logo_mbr_digital.svg'?>" width="300" class="col-md-offset-5 logocenter" />

        </div>
        <div class="col-md-6 col-md-offset-3">

            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        <?php echo  csrf_field()  ?>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="{{trans('auth.email')}}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="{{trans('auth.password')}}">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{trans('auth.remember')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn loginbutton col-md-12">
                                    Login
                                </button>
                            </div>
                                <a class="btn btn-link col-md-6 col-md-offset-3" href="{{ route('password.request') }}">
                                    {{trans('auth.forgot')}}
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
