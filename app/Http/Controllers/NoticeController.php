<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notice()
    {
        $notices = Notice::leftJoin('people','notices.person_id','=','people.id')
                    ->select('people.name','notices.*')
                    ->where('notices.isActive', 1)
                    ->orderby('created_at','DESC')
                    ->simplePaginate(5);
                    
        return view('frontend.notice.index',compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function MyNoticeAction($id)
    {
        $notice = Notice::find($id);

        return view('pages.noticeEdit',compact('notice'));
    }

    // // update notice
    // public function updateNotice(Request $request, $id)
    // {
    //     $getForProfile = person();
    //     $notice = Notice::find($id);
    //     $notice->title = $request['title'];
    //     $notice->noticeBody = $request['noticeBody'];
    //     $notice->isActive = $request['isActive'];
    //     $notice->save();
    //     return redirect(route('MyNotice'));

    // }

    // update notice
    public function updateNotice(Request $request, $id)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Validate the request inputs (title, validTill, and file if present)
        $request->validate([
            'title' => 'required',
            'validTill' => 'required|date',
            'noticeBody' => 'nullable|string',
            'refdoc' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120', // Max size is 5MB, optional
        ]);

        // Find the existing notice by ID
        $notice = Notice::findOrFail($id);

        // Check if a new file is uploaded and handle the file upload
        if ($request->hasFile('refdoc')) {
            // Validate and store the new file
            $file = $request->file('refdoc');

            // Define the upload path and generate a unique filename
            $uploadDirectory = public_path('uploads/notices');
            $newFilename = time() . '_' . $file->getClientOriginalName();

            // Move the file to the target directory
            $file->move($uploadDirectory, $newFilename);

            // Define the file path for saving in the database
            $filePath = 'uploads/notices/' . $newFilename;

            // Delete the old file if it exists
            if ($notice->filepath) {
                if (file_exists(public_path($notice->filepath))) {
                    unlink(public_path($notice->filepath));
                }
            }

            // Assign the new file path to the notice
            $notice->filepath = $filePath;
        }

        // Update the notice details
        $notice->title = $request->title;
        $notice->valid_till = $request->validTill;
        $notice->noticeBody = $request->noticeBody;

        // Ensure the URL starts with https:// or http://
        if ($request->filled('uril')) {
            $url = $request->input('uril');

            // Ensure the URL starts with http:// or https://
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                $url = 'http://' . $url; // Default to http if no scheme is provided
            }

            $notice->url = $url;
        }

        // Assign the authenticated user ID
        $notice->person_id = $user->id;

        // Save the updated notice
        $status = $notice->save();

        // Redirect back with a success message
        return redirect()->route('notice')->with('success', 'Notice successfully updated');
    }


    // view my notice
    public function MyNotice(){
        $user = Auth::user();
        $notices = Notice::where('person_id',$user->id)->orderby('id','DESC')->simplepaginate(10);

        return view('frontend.notice.index',compact(['notices']));
    }

    // new function for notice upload
    public function store(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Validate the request inputs (title, validTill, and file if present)
        $request->validate([
            'title' => 'required',
            'validTill' => 'required',
        ]);

        // Check if a file is uploaded and handle the file upload
        if ($request->hasFile('refdoc')) {
            // Validate the file type and size as per the specified requirements
            $request->validate([
                'refdoc' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120', // Max size is 5MB
            ]);

            $file = $request->file('refdoc');

            // Define the upload path and generate a unique filename
            $uploadDirectory = public_path('uploads/notices');
            $newFilename = time() . '_' . $file->getClientOriginalName();

            // Move the file to the target directory
            $file->move($uploadDirectory, $newFilename);

            // Define the file path for saving in the database
            $filePath = 'uploads/notices/' . $newFilename;
        } else {
            $filePath = null; // No file uploaded
        }

        // Create the new notice
        $notice = new Notice;
        $notice->title = $request->title;
        $notice->valid_till = $request->validTill;
        $notice->noticeBody = $request->noticeBody; 
        $notice->filepath = $filePath;
        $notice->person_id = $user->id;
        
        // Ensure the URL starts with https:// or http://
        // Check if a URL is provided
        if ($request->filled('uril')) {
            $url = $request->input('uril');

            // Ensure the URL starts with http:// or https://
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                $url = 'http://' . $url; // Using http by default, you can change it to https if needed
            }

            // Assign the formatted URL to the notice model
            $notice->url = $url;
        } else {            
            $notice->url = $request->uril;
        }

        // Save the notice
        $status = $notice->save();

        // Redirect back with success message
        return redirect()->route('frontend.notice')->with('success', 'Notice successfully created');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function AllNotice(){
        $getForProfile = person();
        $countUser = NewUserCount();
        $newNotice = NewNotice();
        $allNotice = AllNoticeShow();
        return view('pages.allnotice',compact(['getForProfile','countUser','newNotice','allNotice']));
    }
    public function approve($id)
    {
        $notice = Notice::find($id);
        $notice->isActive = 1;
        $notice->save();
        return redirect()->back()->with("Success", "Notice Approved Successfully");
    }
    public function Deactivate($id)
    {
        $notice = Notice::find($id);
        $notice->isActive = 2;
        $notice->save();
        return redirect()->back()->with("warning", "Notice Active Status Changed");
    }
    public function destroy($id)
    {
        $notice = Notice::find($id);
        $notice->delete();
        return redirect()->back()->with("Success", "Notice Delete Successfully");
    }
    
}
