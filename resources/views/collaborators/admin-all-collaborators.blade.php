<x-layout-app page-title="Colaborators">

    <div class="w-100 p-4">

        <h3>All colaborators</h3>

        <hr>

        <!-- table -->
        @if ($collaborators->count() === 0)
            <div class="text-center my-5">
                <p>No collaborators found.</p>
            </div>
        @else
            <table class="table" id="table">
                <thead class="table-dark">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Active?</th>
                    <th>Department</th>
                    <th>Role</th>
                    <th>Admission date</th>
                    <th>Salary</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($collaborators as $collaborator)
                        <tr>
                            <td>{{ $collaborator->name }}</td>
                            <td>{{ $collaborator->email }}</td>
                            <td>
                                @empty($collaborator->email_verified_at)
                                    <span class="badge bg-danger">No</span>
                                @else
                                    <span class="badge bg-success">Yes</span>
                                @endempty
                            </td>

                            <td>{{ $collaborator->department->name }}</td>
                            <td>{{ $collaborator->role }}</td>
                            <td>{{ $collaborator->detail->admission_date }}</td>
                            <td>R$ {{ $collaborator->detail->salary }}</td>

                            <td>
                                <div class="d-flex gap-3 justify-content-end">
                                    @if (empty($collaborator->deleted_at))
                                        <a href="{{ route('collaborators.details', ['id' => $collaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3">
                                            <i class="fas fa-eye"></i> Details
                                        </a>
                                        <a href="{{ route('collaborators.delete', ['id' => $collaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3">
                                            <i class="fa-regular fa-trash-can me-2"></i>Delete
                                        </a>
                                    @else
                                        <a href="{{ route('collaborators.restore', ['id' => $collaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3">
                                            <i class="fa-solid fa-trash-arrow-up me-2"></i>Restore
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

</x-layout-app>
