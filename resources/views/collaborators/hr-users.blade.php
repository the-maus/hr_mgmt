<x-layout-app pageTitle="Human Resources">
    <div class="w-100 p-4">

        <h3>Human Resources Collaborators</h3>

        <hr>

        @if ($collaborators->count() === 0)
            <div class="text-center my-5">
                <p>No collaborators found.</p>
                <a href="{{ route('collaborators.new') }}" class="btn btn-primary">Create a new collaborators</a>
            </div>
        @else
            <div class="mb-3">
                <a href="{{ route('collaborators.new') }}" class="btn btn-primary">Create a new collaborators</a>
            </div>

            <table class="table" id="table">
                <thead class="table-dark">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Salary</th>
                    <th>Admission date</th>
                    <th>City</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($collaborators as $collaborator)
                        <tr>
                            <td>{{ $collaborator->name }}</td>
                            <td>{{ $collaborator->email }}</td>
                            <td>{{ $collaborator->role }}</td>
                            
                            <td>R$ {{ $collaborator->detail->salary }}</td>
                            <td>{{ $collaborator->detail->admission_date }}</td>
                            <td>{{ $collaborator->detail->city }}</td>

                            <td>
                                <div class="d-flex gap-3 justify-content-end">
                                    <a href="{{ route('collaborators.edit', ['id' => $collaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3">
                                        <i class="fa-regular fa-pen-to-square me-2"></i>Edit
                                    </a>
                                    <a href="{{ route('collaborators.delete', ['id' => $collaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3">
                                        <i class="fa-regular fa-trash-can me-2"></i>Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-layout-app>
