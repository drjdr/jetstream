<?php

namespace Laravel\Jetstream\Contracts;

interface TransfersTeams
{
    /**
     * Delete the given team.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  array  $input
     * @return void
     */
    public function transfer($user, $team, array $input);
}
