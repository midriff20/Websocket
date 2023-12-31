<main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
              <img src="{{URL::asset('/img/illustration-signup.jpg')}}">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-size: cover;">
              </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
              <div class="card card-plain">
                <div class="card-header">
                  <h4 class="font-weight-bolder">Change Password</h4>
                  <p class="mb-0">Enter your old password</p>
                </div>
                <div class="card-body">
                  <form role="form"  action="{{'changepassword'}}" method="post">
                  @csrf
                   {{ csrf_field() }}
                   <!-- @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    <div class="input-group input-group-outline mb-3">
                   
                      <label class="form-label">Name</label>
                      <input type="text" name="name" class="form-control">
                     
                    </div>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" name="email" class="form-control">
                     
                    </div> -->
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Old Password</label>
                      <input type="password" name="old_password" class="form-control">
                   
                    </div>
                    <!--  -->
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">New Password</label>
                      <input type="password" name="new_password" class="form-control">
                   
                    </div>
                    <!--  -->
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Confirm Password</label>
                      <input type="password" name="confirm_password" class="form-control">
                   
                    </div>
                    <!-- <div class="form-check form-check-info text-start ps-0">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                      <label class="form-check-label" for="flexCheckDefault">
                        I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                      </label>
                    </div> -->
                    <div class="text-center">
                      <button type="submit" name="btn" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Change Password</button>
                    </div>
                  </form>
                </div>
                <!-- <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-2 text-sm mx-auto">
                    Already have an account?
                    <a href="{{url('user-login')}}" class="text-primary text-gradient font-weight-bold">Sign in</a>
                  </p>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>