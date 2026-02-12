<x-layout-guest pageTitle="Welcome">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col">
                <div class="text-center mb-5">
                    {{-- logo --}}
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="200px">

                    {{-- welcome message --}}
                    <div class="card p-5">
                        <p>Welcome, <strong>{{ $user->name }}</strong>!</p>
                        <p>Your account has been successfully created.</p>
                        <p>You can now <a href="{{ route('login') }}">log in</a> to your account</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout-guest>
