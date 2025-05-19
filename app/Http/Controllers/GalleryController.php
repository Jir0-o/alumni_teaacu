<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\OurGallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $getForProfile = person();
        $countUser = NewUserCount();
        $getGalleryData = Gallery::orderby('id','desc')->get();
        return view('frontend.gallery.viewGallery',compact(['getForProfile','countUser','getGalleryData']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $postGallery = new Gallery;
        $postGallery->title = $request->title;

        // $postGallery->gallery_image = $request->gallery_image;
        if ($file = $request->file('gallery_image')) {
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('backend/slide'), $imageName);
            $postGallery->gallery_image = 'backend/slide/' . $imageName; // Save relative path
        }
        $postGallery->is_active = $request->is_active;
        $postGallery->save();

        return redirect()->back()->with('success','Add Successfully');
    }

    public function disabled($id){
        $getGallery = Gallery::find(decrypt($id));
        $getGallery->is_active = 0;
        $getGallery->save();
        return redirect()->back();
    }
    public function enable($id){
        $getGallery = Gallery::find(decrypt($id));
        $getGallery->is_active = 1;
        $getGallery->save();
        return redirect()->back();
    }

    public function editView($id){
        $gallery = Gallery::findOrFail($id);
        return response()->json($gallery);
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'edit_title' => 'nullable|string|max:255',
            'edit_gallery_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'edit_is_active' => 'nullable|boolean',
        ]);

        $gallery->title = $request->edit_title;
        $gallery->is_active = $request->edit_is_active;

        if ($request->hasFile('edit_gallery_image')) {
            // Optionally delete old image
            if ($gallery->gallery_image && file_exists(public_path($gallery->gallery_image))) {
                unlink(public_path($gallery->gallery_image));
            }

            $file = $request->file('edit_gallery_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('backend/slide'), $filename);
            $gallery->gallery_image = 'backend/slide/' . $filename; 
        }

        $gallery->save();

        return response()->json(['success' => true, 'message' => 'Gallery updated successfully.']);
    }


    public function delete($id)
    {
        try {
            $gallery = Gallery::findOrFail(decrypt($id));

            // Delete image if exists
            if ($gallery->gallery_image) {
                $imagePath = public_path($gallery->gallery_image);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Delete gallery record
            $gallery->delete();

            return redirect()->back()->with('delete', 'Deleted Successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        //
    }

        public function ourIndex()
    { 
        $getForProfile = person();
        $countUser = NewUserCount();
        $getGalleryData = OurGallery::orderby('id','desc')->get();
        return view('backend.frontend.index',compact(['getForProfile','countUser','getGalleryData']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ourCreate(Request $request)
    {
        $postGallery = new OurGallery;
        $postGallery->title = $request->title;

        // $postGallery->gallery_image = $request->gallery_image;
        if ($file = $request->file('gallery_image')) {
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('backend/slide'), $imageName);
            $postGallery->gallery_image = 'backend/slide/' . $imageName; // Save relative path
        }
        $postGallery->is_active = $request->is_active;
        $postGallery->type = $request->type;
        $postGallery->save();

        return redirect()->back()->with('success','Add Successfully');
    }

    public function ourDisabled($id){
        $getGallery = OurGallery::find(decrypt($id));
        $getGallery->is_active = 0;
        $getGallery->save();
        return redirect()->back();
    }
    public function ourEnable($id){
        $getGallery = OurGallery::find(decrypt($id));
        $getGallery->is_active = 1;
        $getGallery->save();
        return redirect()->back();
    }

    public function ourEditView($id){
        $gallery = OurGallery::findOrFail($id);
        return response()->json($gallery);
    }

    public function ourUpdate(Request $request, $id)
    {
        $postGallery = OurGallery::find($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'gallery_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $postGallery->title = $request->title;
        $postGallery->type = $request->type;

        if ($file = $request->file('edit_gallery_image')) {
            if (file_exists(public_path($postGallery->gallery_image))) {
                unlink(public_path($postGallery->gallery_image));
            }

            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('backend/slide'), $imageName);
            $postGallery->gallery_image = 'backend/slide/' . $imageName; 
        }

        $postGallery->save();

        return response()->json(['success' => true, 'message' => 'Gallery updated successfully.']);
    }


    public function ourDelete($id)
    {
        $getdata = OurGallery::find(decrypt($id));

        if ($getdata && $getdata->gallery_image) {
            $imagePath = public_path($getdata->gallery_image); // full path to the file

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $getdata->delete();

        return redirect()->back()->with('delete', 'Delete Successfully');
    }


}
