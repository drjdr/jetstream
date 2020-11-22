<?php

namespace Laravel\Jetstream\Actions;

use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class ValidateTeamTransfer
{
    /**
     * Validate that the team can be deleted by the given user.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  array  $input
     * @return void
     */
    public function validate($user, $team, array $input)
    {
        Gate::forUser($user)->authorize('transfer', $team);

        Validator::make($input, [
            'user_id' => ['required'],
        ])->validateWithBag('transferTeam');

        if ($team->personal_team) {
            throw ValidationException::withMessages([
                'team' => __('You may not transfer your personal team.'),
            ]);
        }
    }

    /**
     * Ensure that the currently authenticated user does not own the team.
     *
     * @param  mixed  $teamMember
     * @param  mixed  $team
     * @return void
     */
    protected function ensureUserDoesNotOwnTeam($teamMember, $team)
    {
        if ($teamMember->id === $team->owner->id) {
            throw ValidationException::withMessages([
                'user_id' => [__('User must belong to .')],
            ])->errorBag('transferTeam');
        }
    }
}
