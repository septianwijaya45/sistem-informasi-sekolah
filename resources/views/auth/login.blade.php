@extends('auth.layout')

@section('title', 'Login')

@section('form')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  {{ session('error') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<div class="card-body login-card-body">
  <p class="login-box-msg">Sign in to start your session</p>

  <form action="{{ route('login.logic') }}" method="post" id="form-login">
    @csrf
    <div class="input-group mb-3">
      <input type="email" id="email" name="email" class="form-control" placeholder="Email">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-envelope"></span>
        </div>
      </div>
    </div>
    <div class="input-group mb-3">
      <input type="password" id="password" name="password" class="form-control" placeholder="Password">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-lock"></span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-8">
        <a href="{{ route('register') }}" class="text-center btn btn-light text-blue">Register</a>
      </div>
      <!-- /.col -->
      <div class="col-4">
        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
      </div>
      <!-- /.col -->
    </div>
  </form>

</div>
<!-- /.login-card-body -->

@endsection

@section('script')

<script>
  $(function() {
    $('#form-login').validate({
      rules: {
        email: {
          required: true,
        },
        password: {
          required: true,
        },
      },
      messages: {
        email: {
          required: "Email harus di isi!",
        },
        password: {
          required: "Password harus di isi!",
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.input-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
    })
  })
</script>

@endsection
