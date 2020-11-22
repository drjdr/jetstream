<?php

namespace App\Actions\Jetstream;

use Arr;
use Laravel\Jetstream\Contracts\TransfersTeams;
use Laravel\Jetstream\Events\AddingTeamMember;
use Laravel\Jetstream\Events\TeamMemberAdded;
use Laravel\Jetstream\Jetstream;

class TransferTeam implements TransfersTeams
{
    /**
     * Transfer the given team.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  array  $input
     * @return void
     */
    public function transfer($user, $team, array $input)
    {
        $team->forceFill([
            'user_id' => $input['user_id'],
        ])->save();

        AddingTeamMember::dispatch($team, $user);

        $team->users()->attach(
            $user,
            ['role' => Arr::first(Jetstream::$roles)->key ]
        );

        TeamMemberAdded::dispatch($team, $user);
    }
}
