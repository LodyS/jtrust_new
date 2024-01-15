@auth
    @include('home')
@else
    @include ('auth.login')
@endauth
