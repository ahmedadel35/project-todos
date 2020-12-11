<div>
    <x-slot name='title'>
        {{ $user->name }} Projects
    </x-slot>

    <div class='flex items-center justify-between py-2 px-4 w-100 bg-indigo-800 mb-5'>
        <h1 class='pt-2'>{{ $user->name }} Projects</h1>
        <div class='text-right'>
            <x-jet-button type='button'
                class="m-0 {{ $this->onlyCompleted ? 'bg-red-300 hover:bg-red-700' : 'bg-green-600 hover:bg-green-800' }}"
                wire:click.prevent='showOnlyCompleted' icon='fas fa-filter'>
                completed
            </x-jet-button>
        </div>
    </div>


    <div class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 sm:gap-2 md:gap-4'>
        @forelse($projects as $project)
            <div class='relative bg-gray-700 shadow mb-4 rounded'>
                <img class='border border-white w-100' src='{{ $user->profile_photo_url }}' />
                @if($project->completed)
                    <div class='absolute top-0 left-0 bg-green-600 text-white uppercase p-1 rounded opacity-75'>
                        <i class='fas fa-check'></i>
                        completed
                    </div>
                @endif
                <div class='p-2 font-bold'>
                    <h3><a class='text-blue-500 hover:text-blue-600 hover:underline'
                            href='/projects/{{ $project->slug }}' class='text-lg'>{{ $project->name }}</a></h3>
                    <p class='text-green-600'>${{ $project->cost }}</p>
                    <p class='text-gray-700'>
                        <i class='fas fa-bookmark'></i>
                        {{ $project->category->title }}
                    </p>
                    <hr class='bg-gray-700' />

                </div>
            </div>
        @empty
            <div class='alert alert-danger w-3/4 hover:bg-red-400'>
                you hadn`t created any projects yet.
            </div>
        @endforelse
    </div>
</div>
