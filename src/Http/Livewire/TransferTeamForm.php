<?php

namespace Laravel\Jetstream\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Actions\ValidateTeamTransfer;
use Laravel\Jetstream\Contracts\TransfersTeams;
use Laravel\Jetstream\RedirectsActions;
use Livewire\Component;

class TransferTeamForm extends Component
{
    use RedirectsActions;

    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * Mount the component.
     *
     * @param  mixed  $team
     * @return void
     */
    public function mount($team)
    {
        $this->team = $team;

        $this->state = ['user_id' => ''];
    }

    /**
     * Update the team's name.
     *
     * @param  \Laravel\Jetstream\Actions\ValidateTeamTransfer  $validator
     * @param  \Laravel\Jetstream\Contracts\TransfersTeams  $transferrer
     * @return void
     */
    public function transferTeam(ValidateTeamTransfer $validator, TransfersTeams $transferrer)
    {
        $validator->validate($this->user, $this->team, $this->state);

        $transferrer->transfer($this->user, $this->team, $this->state);

        $this->emit('transferred');

        return $this->redirectPath($transferrer);
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('teams.transfer-team-form');
    }
}
