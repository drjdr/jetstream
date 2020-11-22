<x-jet-form-section submit="transferTeam">
    <x-slot name="title">
        {{ __('Transfer Team') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Transfer team ownership to another team member.') }}
    </x-slot>

    <x-slot name="form">
        <!-- New Team Owner Information -->
        <div class="col-span-6">
            <x-jet-label value="{{ __('New Team Owner') }}" />

            <div>
                <select id="user_id" wire:model.defer="state.user_id" :disabled="! Gate::check('transfer', $team)" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    @foreach ($team->users->sortBy('name') as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <x-jet-input-error for="user_id" class="mt-2" />
        </div>

    </x-slot>

    @if (Gate::check('transfer', $team))
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="transferred">
                {{ __('Transferred.') }}
            </x-jet-action-message>

            <x-jet-danger-button type="submit">
                {{ __('Transfer') }}
            </x-jet-danger-button>
        </x-slot>
    @endif
</x-jet-form-section>
