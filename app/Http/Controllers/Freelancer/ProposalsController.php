<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Project;
use App\Models\Proposal;
use App\Notifications\NewProposalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ProposalsController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = auth()->guard('web')->user();
        $proposals = $user->proposals()
            ->with('project')->latest()->paginate();
        // dd(auth()->user());
        return view('freelancer.proposals.index', ['proposals' => $proposals]);
    }

    /**
     * Summary of create
     * @param mixed $project_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Project $project)
    {
        return view('freelancer.proposals.create', [
            'project' => $project,
            'proposal' => new Proposal(),
            'units' => Proposal::units()
        ]);
    }

    /**
     * Summary of store
     * @param Request $request
     * @param mixed $project_id
     */
    public function store(Request $request, $project_id)
    {

        $project = Project::findOrFail($project_id);
        if ($project->status !== 'open') {
            return redirect()->route('freelancer.proposal.index')
                ->with('error', 'You can not submit propsal to this project');
        }

        // if ($user->proposedProjects()->find($project->id)) {
        //     return redirect()->route('freelancer.proposal.index')
        //         ->with('error', 'You already submitted proposal to this project');
        // }

        $request->validate([
            'description' => ['required', 'string'],
            'cost' => ['required', 'numeric', 'min:1'],
            'duration' => ['required', 'int', 'min:1'],
            'duration_unit' => ['required', 'in:day,week,month,year']
        ]);

        $user = auth()->user();
        $proposal = $user->proposals()->create([
            'project_id' => $project->id,
            'description' => $request->description,
            'cost' => $request->cost,
            'duration' => $request->duration,
            'duration_unit' => $request->duration_unit,
        ]);

        //Notifications
        //Channels: mail, database, nexmo(sms), broadcast(Realtime Notification -> like -> socialMedia likes,comments..), slack
        $project->user->notify(
            new NewProposalNotification($proposal, $user)
        );

        // if need send a notification for list of users
        $admins = Admin::all();
        // foreach ($admins as $admin) {
        //     $admin->notify(new NewProposalNotification($proposal, $user));
        // }
        /** or **/
        // Notification::send($admins, new NewProposalNotification($proposal, $user));

        // if need send an email for outer email
        // ارسال رسالة إلى ايميل خارج النظام غير مسجل في قاعدة بيانات النظام
        Notification::route('mail', 'developer@ok.dev')->notify(new NewProposalNotification($proposal, $user));

        return
            // redirect()->route('projects.show', $project->id)
            to_route('freelancer.proposal.index')
            ->with('success', 'Your Proposal has been submitted');
    }

    public function edit() {}

    public function update() {}
    public function destroy($id) {}
}
