<x-layout-app pageTitle="Home">
    <h1 class="text-center">APP</h1>

    @php
        dump(auth()->user()->toArray());
    @endphp
</x-layout-app>