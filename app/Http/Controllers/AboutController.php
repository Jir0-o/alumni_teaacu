<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abouts = About::where('is_active', 1)->get();
        return view('about.index', compact('abouts'));
    }

    public function create()
    {
        return view('about.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'about_details' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalName();
            $image->move(public_path('frontend_assets/img/about'), $imageName);
            $imagePath = 'frontend_assets/img/about/' . $imageName;
        }

        About::create([
            'details' => $request->about_details,
            'image' => $imagePath
        ]);

        return redirect()->route('frontend')->with('success', 'About created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(About $about)
    {
        return view('about.edit', compact('about'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, About $about)
    {
        $request->validate([
            'about_details' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($about->image && file_exists(public_path($about->image))) {
                unlink(public_path($about->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalName();
            $image->move(public_path('frontend_assets/img/about'), $imageName);
            $about->image = 'frontend_assets/img/about/' . $imageName;
        }

        $about->details = $request->about_details;
        $about->save();

        return redirect()->route('frontend')->with('success', 'About updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $about = About::findOrFail($id);
        if ($about->image && file_exists(public_path($about->image))) {
            unlink(public_path($about->image));
        }
        $about->delete();
        return redirect()->route('frontend')->with('success', 'About deleted successfully.');
    }
}
