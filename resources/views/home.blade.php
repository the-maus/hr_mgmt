<x-layout-app pageTitle="Home">
    <div class="w-100 p-4">
        <h3>Home</h3>
        <hr>
        <div class="d-flex">
            <x-info-title-value itemTitle="Total collaborators" :itemValue="$data['total_collaborators']"/>
            <x-info-title-value itemTitle="Total deleted collaborators" :itemValue="$data['total_collaborators_deleted']"/>
            <x-info-title-value itemTitle="Total salary" :itemValue="$data['total_salary']"/>
        </div>

        <hr>

        <div class="d-flex">
            <x-info-title-list itemTitle="Collaborators by department" :list="$data['total_collaborators_by_department']"/>
            <x-info-title-list itemTitle="Salary by department" :list="$data['total_salary_by_department']"/>
        </div>
    </div>
</x-layout-app>