<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;

class InvitationController extends Controller
{
    public function thx(Request $request)
    {
        return view('thx');
    }

    public function showInvitation($uniqueLink = null)
    {
        if (!$uniqueLink || !($invitationData = Invitation::where('unique_link', $uniqueLink)->where('is_used', false)->first())) {
            abort(404);
        }

        return view('invitation', compact('invitationData'));
    }

    public function checkPassword(Request $request, $uniqueLink)
    {
        $invitationData = Invitation::where('unique_link', $uniqueLink)->first();

        if (!$invitationData) {
            abort(404);
        }

        $password = "123456";

        if ($request->input('password') === $password) {
            // تسجيل استخدام الدعوة هنا
            return redirect()->route('invitation', ['unique_link' => $uniqueLink]);
        } else {
            return back()->withErrors(['password' => 'كلمة المرور غير صحيحة']);
        }
    }


    // تنفيذ وظيفة لإضافة دعوة جديدة
    public function addInvitation(Request $request)
    {
        $request->validate([
            'unique_link' => 'required|unique:invitations',
            'message' => 'required',
        ]);

        Invitation::create($request->all());

        return redirect()->back();
    }

    public function changeStatus(Request $request, Invitation $invitation)
    {
        abort_if($invitation->is_used, 404);
        $invitation->update(['is_used' => true]);

        return response()->json([
            'ok' => true,
        ]);
    }
}
