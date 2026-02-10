<div>
    <h3>Admin Data:</h3>
    <p>Name: {{ $admin->name }}</p>
    <p>Email: {{ $admin->email }}</p>
    <p>Profile: {{ $admin->role }}</p>
    <p>Permissions</p>
    <ul>
        @foreach(json_decode($admin->permissions) as $permission)
            <li>{{ $permission }}</li>
        @endforeach
    </ul>
    <h3>Details</h3>
    <p>Address: {{ $admin->detail->address }}</p>
    <p>Zip Code: {{ $admin->detail->zip_code }}</p>
    <p>City: {{ $admin->detail->city }}</p>
    <p>Phone: {{ $admin->detail->phone }}</p>
    <p>Salary: {{ $admin->detail->salary }} €</p>
    <p>Admission Date: {{ $admin->detail->admission_date }}</p>
    <h3>Department</h3>
    <p>{{ $admin->department->name }}</p>
</div>