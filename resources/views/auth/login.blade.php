
<x-guest-layout>
    <div class="container-fluid" id="loginPage">
        <div class="center">
            <img src="/images/logo.png" class="logo">
            <form method="post" action="{{route('login')}}" class="loginForm">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label text-dark" >登入帳號</label>
                    <input type="email" name="email" placeholder="Email..." class="form-control text-dark bg-transparent" id="email" aria-describedby="emailHelp"  autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-dark">登入密碼</label>
                    <input type="password" name="password" placeholder="Password..." class="form-control text-dark bg-transparent" id="password">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label text-dark" for="remember">Remember me</label>
                </div>
                <x-jet-validation-errors class="mb-4 text-danger" />
                <button type="submit" class="btn btn-primary  loginBtn">LOGIN</button>
            </form>
        </div>
    </div>
</x-guest-layout>



