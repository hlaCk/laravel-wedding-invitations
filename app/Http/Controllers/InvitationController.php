<?php

namespace App\Http\Controllers;

use App\Mail\Attended;
use App\Mail\InvitationOpened;
use Illuminate\Http\Request;
use App\Models\Invitation;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function thx(Request $request)
    {
        return view('thx');
    }

    public function showInvitation($uniqueLink = null)
    {
        if( !$uniqueLink || !($invitation = Invitation::where('unique_link', $uniqueLink)->where('is_used', false)->first()) ) {
            return $uniqueLink && Invitation::where('unique_link', $uniqueLink)->count() ? redirect()->route('thx') : abort(404);
        }
        try {

            $mail = new InvitationOpened($invitation);

            Mail::to("somaxy@gmail.com", "SoMaxy")
                ->send($mail);
        } catch(\Exception $exception) {

        }
        return view('invitation', compact('invitation'));
    }

    public function checkPassword(Request $request, $uniqueLink)
    {
        $invitationData = Invitation::where('unique_link', $uniqueLink)->first();

        if( !$invitationData ) {
            abort(404);
        }

        $password = "123456";

        if( $request->input('password') === $password ) {
            // تسجيل استخدام الدعوة هنا
            return redirect()->route('invitation', [ 'unique_link' => $uniqueLink ]);
        } else {
            return back()->withErrors([ 'password' => 'كلمة المرور غير صحيحة' ]);
        }
    }

    // تنفيذ وظيفة لإضافة دعوة جديدة
    public function addInvitation(Request $request)
    {
        return view('add_invitation', [
            'invitation' => null,
            'invitations' => $request->has('hlack') ? Invitation::where('is_used', false)->get() : collect(),
        ]);
    }
    public function deleteInvitation(Request $request, $uniqueLink)
    {
        $invitationData = Invitation::where('unique_link', $uniqueLink)->delete();
        return redirect()->back();
    }

    public function createInvitation(Request $request)
    {
        $data = $request->validate([
                                       'pass' => 'string|required',
                                       'unique_link' => 'required|unique:invitations',
                                       'message' => 'required',
                                   ]);
        if( $data[ 'pass' ] !== '1412524' ) {
            abort(503);
        }
        $invitation = Invitation::make($request->except([ 'pass' ]));
        $invitation->save();
        $invitation->refresh()->pass = $request->get('pass');

        return view('add_invitation', [
            'invitations' => Invitation::where('is_used', false)->latest()->get(),
            'invitation' => $invitation,
        ]);
    }

    public function changeStatus(Request $request, Invitation $invitation)
    {
        abort_if($invitation->is_used, 404);
        $invitation->update([ 'is_used' => true ]);

        try {

            $mail = new Attended($invitation);

            Mail::to("somaxy@gmail.com", "SoMaxy")
                ->send($mail);
        } catch(\Exception $exception) {

        }

        return response()->json([
                                    'ok' => true,
                                ]);
    }
}
