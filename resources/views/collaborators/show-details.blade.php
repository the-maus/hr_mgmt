<x-layout-app page-title="Collaborator details">

    <div class="w-100 p-4">

        <h3>Collaborator details</h3>

        <hr>

        <div class="container-fluid">
            <div class="row mb-3">

                <div class="col">

                    <p>Name: <strong>{{ $collaborator->name }}</strong></p>
                    <p>Email: <strong>{{ $collaborator->email }}</strong></p>
                    <p>Role: <strong>{{ $collaborator->role }}</strong></p>
                    <p>Permissions: </p>

                    @php
                        $permissions = json_decode($collaborator->permissions);
                    @endphp
                    <ul>
                        @foreach ($permissions as $permission)
                            <li>{{ $permission }}</li>
                        @endforeach
                    </ul>

                    <p>Department: <strong>{{ $collaborator->department->name }}</strong></p>
                    <p>Active: 
                        @empty($collaborator->email_verified_at)
                            <span class="badge bg-danger">No</span>
                        @else
                            <span class="badge bg-success">Yes</span>
                        @endempty
                    </p>
                </div>

                <div class="col">
                    <p>Address: <strong>{{ $collaborator->detail->address }}</strong></p>
                    <p>Zip code: <strong>{{ $collaborator->detail->zip_code }}</strong></p>
                    <p>City: <strong>{{ $collaborator->detail->city }}</strong></p>
                    <p>Phone: <strong>{{ $collaborator->detail->phone }}</strong></p>
                    <p>Admission date: <strong>{{ $collaborator->detail->admission_date }}</strong></p>
                    <p>Salary: <strong>R$ {{ $collaborator->detail->salary }}</strong></p>
                </div>
            </div>
        </div>

        <button class="btn btn-outline-dark" onclick="window.history.back()"><i class="fas fa-arrow-left me-2"></i>Back</button>

    </div>

</x-layout-app>