<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeadershipMessage;
use Illuminate\Support\Facades\Storage;

class LeadershipMessageController extends Controller
{

    public function update(Request $request)
    {
        $request->validate([
            'vc_image' => 'nullable|image|max:2048',
            'vc_message' => 'nullable|string',

            'president_image' => 'nullable|image|max:2048',
            'president_message' => 'nullable|string',

            'advisor_image' => 'nullable|image|max:2048',
            'advisor_message' => 'nullable|string',
        ]);

        $message = LeadershipMessage::firstOrNew(['id' => 1]);

        if ($request->hasFile('vc_image')) {
            $file = $request->file('vc_image');
            $filename = 'vc_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/messages'), $filename);
            $message->vc_image = 'uploads/messages/' . $filename;
        }

        if ($request->hasFile('president_image')) {
            $file = $request->file('president_image');
            $filename = 'president_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/messages'), $filename);
            $message->president_image = 'uploads/messages/' . $filename;
        }

        if ($request->hasFile('advisor_image')) {
            $file = $request->file('advisor_image');
            $filename = 'advisor_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/messages'), $filename);
            $message->advisor_image = 'uploads/messages/' . $filename;
        }

        // Remove old images if new ones are uploaded
        if ($request->hasFile('vc_image') && $message->getOriginal('vc_image')) {
            $oldVcImage = public_path($message->getOriginal('vc_image'));
            if (file_exists($oldVcImage)) {
                unlink($oldVcImage); // Delete the old image
            }
        }

        if ($request->hasFile('president_image') && $message->getOriginal('president_image')) {
            $oldPresidentImage = public_path($message->getOriginal('president_image'));
            if (file_exists($oldPresidentImage)) {
                unlink($oldPresidentImage); // Delete the old image
            }
        }

        if ($request->hasFile('advisor_image') && $message->getOriginal('advisor_image')) {
            $oldAdvisorImage = public_path($message->getOriginal('advisor_image'));
            if (file_exists($oldAdvisorImage)) {
                unlink($oldAdvisorImage); // Delete the old image
            }
        }

        // Save text
        $message->vc_message = $request->vc_message;
        $message->president_message = $request->president_message;
        $message->advisor_message = $request->advisor_message;

        $message->save();

        return back()->with('success', 'Messages updated successfully.');
    }
}
