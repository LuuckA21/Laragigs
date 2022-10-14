<x-layout>
    <x-card class="p-10">
        <header>
            <h1 class="text-3xl text-center font-bold my-6 uppercase">
                Manage Gigs
            </h1>
        </header>
        <x-listing-manage :listings="$listings" />
    </x-card>
</x-layout>