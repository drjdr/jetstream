<?php

namespace Laravel\Jetstream\Http\Controllers\Inertia;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Jetstream\Actions\ValidateTeamTransfer;
use Laravel\Jetstream\Contracts\TransfersTeams;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\RedirectsActions;

class TeamTransferController extends Controller
{
    use RedirectsActions;

    /**
     * Transfer the given team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transfer(Request $request, $teamId)
    {
        $team = Jetstream::newTeamModel()->findOrFail($teamId);

        app(ValidateTeamTransfer::class)->validate($request->user(), $team, $request->all());

        $transferrer = app(TransfersTeams::class);

        $transferrer->transfer($request->user(), $team, $request->all());

        return $this->redirectPath($transferrer);
    }
}
