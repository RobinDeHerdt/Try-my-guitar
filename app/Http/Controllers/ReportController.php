<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Report;
use App\User;
use Auth;

/**
 * Class ReportController
 * @package App\Http\Controllers
 */
class ReportController extends Controller
{
    /**
     * Contains the authenticated user.
     *
     * @var array
     */
    private $user;

    /**
     * Constructor.
     *
     * Check if the user has the 'user' role.
     * Get the authenticated user and save it to the $user variable.
     */
    public function __construct()
    {
        $this->middleware('role:user');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    /**
     * Show a listing of reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::orderBy('reviewed')->paginate(15);

        return view('admin.report.index', [
            'reports' => $reports,
        ]);
    }

    /**
     * Show the form for creating a report.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        return view('profile.report', [
            'user' => $user,
        ]);
    }

    /**
     * Store the report.
     *
     * @param  \App\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Request $request)
    {
        $report_exists = Report::where('reporter_id', $this->user->id)
            ->where('reported_id', $user->id)
            ->where('reviewed', false)
            ->exists();

        if (!$report_exists) {
            $report = new Report();

            $report->reason = $request->reason;
            $report->reported_id = $user->id;
            $report->reporter_id = $this->user->id;

            $report->save();

            Session::flash('success-message', 'Thanks for your report. The admin team will review this report as soon as possible.');
        } else {
            Session::flash('info-message', 'You have already reported this person. Please await the review of the admin team.');
        }

        return redirect(route('dashboard'));
    }

    /**
     * Show the specified report.
     *
     * @param \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        return view('admin.report.show', [
            'report' => $report,
        ]);
    }

    /**
     * Take specified action and set specified report as reviewed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function reviewed(Request $request, Report $report)
    {
        if ($request->action == 1) {
            $report->reported->active = false;
            $report->reported->save();

            $report->action = 'Ban';

            Session::flash('success-message', 'The user was banned. Report set as reviewed.');
        } else {
            $report->action = 'None';

            Session::flash('success-message', 'No action was taken. Report set as reviewed.');
        }

        $report->reviewed = true;
        $report->save();



        return redirect(route('admin.reports.index'));
    }
}
