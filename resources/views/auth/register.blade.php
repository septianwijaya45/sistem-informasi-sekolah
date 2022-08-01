@extends('auth.layout')

@section('title', 'Register')

@section('form')

<div class="card-body register-card-body">
  <p class="login-box-msg">Register a new membership</p>

  <form action="{{ route('register') }}" method="post" id="form-register">
    @csrf
    <div class="input-group mb-3">
      <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-envelope"></span>
        </div>
      </div>
    </div>
    <div class="input-group mb-3">
      <select type="text" id="role" name="role" class="form-control @error('role') is-invalid @enderror">
        <option value="" {{ old('role') == '' ? 'selected' : '' }}>-- Select {{ __('Level User') }} --</option>
        <option value="Guru" {{ old('role') == 'Guru' ? 'selected' : '' }}>Guru</option>
        <option value="Siswa" {{ old('role') == 'Siswa' ? 'selected' : '' }}>Siswa</option>
      </select>
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-user-tag"></span>
        </div>
      </div>
    </div>
    <div class="input-group mb-3">
      <input type="text" id="nomor_induk" name="nomor_induk" class="form-control @error('nomor_induk') is-invalid @enderror" placeholder="" value="{{ old('nomor_induk') }}">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-id-card"></span>
        </div>
      </div>
      @error('nomor_induk')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="input-group mb-3">
      <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-lock"></span>
        </div>
      </div>
    </div>
    <div class="input-group mb-3">
      <input type="password" id="confirm_password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Confirm Password">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-lock"></span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-8">
        <a href="{{ route('login') }}" class="text-center btn btn-light text-blue">Login</a>
      </div>
      <!-- /.col -->
      <div class="col-4">
        <button type="submit" class="btn btn-primary btn-block">Register</button>
      </div>
      <!-- /.col -->
    </div>
  </form>
</div>
<!-- /.form-box -->

@endsection

@section('script')

<script>
  $(function() {
    $('#form-register').validate({
      rules: {
        email: {
          required: true,
        },
        role: {
          required: true,
        },
        nomor_induk: {
          required: true,
        },
        password: {
          required: true,
        },
        confirm_password: {
          required: true,
          equalTo: "#password",
        },
      },
      messages: {
        email: {
          required: "Email harus di isi!",
        },
        role: {
          required: "Pilih role dengan benar!",
        },
        nomor_induk: {
          required: "Nomor induk harus di isi!",
        },
        password: {
          required: "Password harus di isi!",
        },
        confirm_password: {
          required: "Confirm password harus di isi sama dengan password!",
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
