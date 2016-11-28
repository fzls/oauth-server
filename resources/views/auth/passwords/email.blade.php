@extends('layouts.app')

<!-- Main Content -->
{{--TODO： 修改为tab，并添加手机验证的版本--}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <!-- TAB NAVIGATION -->
                <ul class="nav nav-tabs  nav-justified" role="tablist">
                    <li class="active"><a href="#email_form" role="tab" data-toggle="tab">Reset By Email</a></li>
                    <li><a href="#phone_form" role="tab" data-toggle="tab">Reset by Phone</a></li>
                </ul>
                <!-- TAB CONTENT -->
                <div class="tab-content">
                    {{--通过邮箱重置密码--}}
                    <div class="active tab-pane fade in" id="email_form">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Send Password Reset Link
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{--通过手机重置密码--}}
                    <div class="tab-pane fade" id="phone_form">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form class="form-horizontal" role="form">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label for="phone" class="col-md-4 control-label">Phone Number</label>

                                        <div class="col-md-6">
                                            <input id="phone" type="tel" pattern="1[34578]\d{9}" class="form-control" name="phone" value="{{ old('phone') }}"
                                                   placeholder="人家只认识十一位的号码呢" required>

                                            @if ($errors->has('phone'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('token') ? ' has-error' : '' }}">
                                        <label for="token" class="col-md-4 control-label">Verification Code</label>

                                        <div class="col-md-6">
                                            <input id="token" type="text" class="form-control" name="token" value="{{ old('token') }}"
                                                   placeholder="填上手机收到的六位验证码就可以了呢" required>

                                            @if ($errors->has('token'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('token') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-4">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    {{--RE: add onclick callback--}}
                                                    <button type="button" class="btn btn-primary" style="left: 0" onclick="send_verification_code()">
                                                        Send Password Reset Link
                                                    </button>

                                                    {{--RE: add onclick callback--}}
                                                    <button type="button" class="btn btn-success" style="left: 20%" onclick="reset_password()">
                                                        &nbsp;&nbsp;&nbsp;
                                                        Next
                                                        &nbsp;&nbsp;&nbsp;
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function reset_password() {
            let phone = $('#phone').val();
            let token = $('#token').val();
            let url = "{{url('/password/reset')}}/" + token + "?phone=" + phone;
            window.location.replace(url);
        }

        function send_verification_code() {
            let phone = $('#phone').val();
            let csrf_token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "POST",
                url: "{{url('/password/phone')}}",
                data: {
                    phone: phone,
                    _token: csrf_token
                }
            }).done(function (message) {
                BootstrapDialog.show({
                    title: '收到御坂网络发回的消息',
                    message: message,
                    type: BootstrapDialog.TYPE_SUCCESS
                });

            }).fail(function (error) {
                let message = '<pre>'+JSON.stringify(JSON.parse(error.responseText),null,4)+'</pre>';
                BootstrapDialog.show({
                    title: '呜呜呜，人家跟御坂神经网络无法正常交流了',
                    message: message,
                    type: BootstrapDialog.TYPE_DANGER
                });
            })
        }
    </script>
@endsection
