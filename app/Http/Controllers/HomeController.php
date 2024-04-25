<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationSubmitted;
use App\Mail\Support;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        return view('index',  ['ignoreTailwind' => true], compact('patients', 'doctors'));
    }
    public function apply()
    {
        return view('doctor-apply');
    }

    public function apply_mail(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'details' => 'required|string',
            'cv' => 'required|mimes:pdf,doc,docx|max:2048', // Max file size 2MB, allowed extensions: pdf, doc, docx
        ]);

        // Store CV
        $cv = $request->file('cv');
        $cvName = 'CV_' . time() . '.' . $cv->getClientOriginalExtension();
        $cv->storeAs('cv', $cvName, 'public');
        $attachmentPath = storage_path('app/public/cv/' . $cvName);

        // Save application to database
        $application = new Application();
        $application->name = $request->input('name');
        $application->email = $request->input('email');
        $application->details = $request->input('details');
        $application->cv = $cvName; // Save file name
        $application->save();

        // Send support email
        sendSupportEmail([
            'to' => $application->email,
            'content' => 'You Have Applied For A Doctor. [#' . $application->id . ']. We Will Let You Know If You Are Shortlisted. Thank you for showing interest.',
            'contactLink' => 'https://example.com/contact',
            'contactText' => 'Contact us',
            'phoneNumber' => '+1234567890',
        ]);
        // Send email
        Mail::send(new ApplicationSubmitted(
            $request->input('name'),
            $request->input('email'),
            $request->input('details'),
            $attachmentPath
        ));

        return redirect()->back()->with('success', 'Your application has been submitted successfully.');
    }
}
