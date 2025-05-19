<?php

namespace App\Http\Controllers;

use App\Models\PopupNotice;
use Illuminate\Http\Request;

class PopupNoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notices = PopupNotice::all();
        return view('frontend.popup_notices.index', compact('notices'));
    }

    public function create()
    {
        return view('frontend.popup_notices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
            'image'      => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Save image to public path
        $imageName = time() . '_' . uniqid() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('frontend_assets/img/popup-notice'), $imageName);

        PopupNotice::create([
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'image'      => 'frontend_assets/img/popup-notice/' . $imageName,
        ]);

        return redirect()->route('frontend')->with('success', 'Popup notice created.');
    }

    public function show(PopupNotice $popupNotice)
    {
        return view('frontend.popup_notices.show', compact('popupNotice'));
    }

    public function edit(PopupNotice $popupNotice)
    {
        return view('frontend.popup_notices.edit', compact('popupNotice'));
    }

    public function update(Request $request, PopupNotice $popupNotice)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only('start_date', 'end_date');

        // If new image is uploaded
    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($popupNotice->image && file_exists(public_path($popupNotice->image))) {
            unlink(public_path($popupNotice->image));
        }

        // Save new image
        $imageName = time() . '_' . uniqid() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('frontend_assets/img/popup-notice'), $imageName);
        $data['image'] = 'frontend_assets/img/popup-notice/' . $imageName;
    }

    $popupNotice->update($data);

        return redirect()->route('frontend')->with('success', 'Popup notice updated.');
    }

    public function destroy(PopupNotice $popupNotice)
    {
        // Delete the image file if it exists
        if ($popupNotice->image && file_exists(public_path($popupNotice->image))) {
            // Optional: ensure the path is within the expected directory for safety
            if (str_starts_with($popupNotice->image, 'frontend_assets/img/popup-notice/')) {
                unlink(public_path($popupNotice->image));
            }
        }

        $popupNotice->delete();

        return redirect()->back()->with('success', 'Popup notice deleted successfully.');
    }

    public function toggleStatus(PopupNotice $popupNotice)
    {
        $popupNotice->is_active = !$popupNotice->is_active;
        $popupNotice->save();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => $popupNotice->is_active,
            ]);
        }

        return redirect()->back()->with('success', 'Popup notice status updated.');
    }
}
