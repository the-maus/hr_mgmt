<x-layout-guest pageTitle="Password Recovery">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-5">

                <!-- logo -->
                <div class="text-center mb-5">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="200px">
                </div>

                <!-- forgot password -->
                <div class="card p-5">
                    @if(!session('status'))
                        <p>To recover your password, please provide your email address. You will receive an email with a link to reset your password.</p>

                        <form action="{{ route('password.email') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('login') }}">Already know your password?</a>
                                <button type="submit" class="btn btn-primary px-4">Send email</button>
                            </div>

                        </form>
                    @else
                        <div class="text-center mb-5">
                            <p>If you are registered on this platform, you will receive an email with a link to recover your password.</p>
                            <p class="mb-5">Please check your inbox.</p>
                            <a href="{{ route('login') }}" class="btn btn-primary px-4">Back to login</a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-layout-guest>