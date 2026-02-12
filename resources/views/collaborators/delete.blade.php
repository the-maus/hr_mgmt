<x-layout-app pageTitle="Delete department">
    <div class="w-25 p-4">
        <h3>Delete HR Collaborator</h3>
        <hr>
        <p>Are you sure you want to delete this collaborator?</p>
        <div class="text-center">
            <h3 class="my-5">{{ $collaborator->name }}</h3>
            <a href="{{ route('collaborators.hr-users') }}" class="btn btn-secondary px-5">No</a>
            <a href="{{ route('collaborators.delete-confirm', ['id' => $collaborator->id]) }}" class="btn btn-danger px-5">Yes</a>
        </div>
    </div>
</x-layout-app>
