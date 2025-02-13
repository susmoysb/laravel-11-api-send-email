<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\TestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TestEmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'subject' => ['required', 'min:5', 'max:255'],
            'body' => ['required', 'min:10',],
            'file' => ['required', 'file'],
            'image' => ['nullable', 'image'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validatedData = $validator->validated();

        try {
            Mail::to($validatedData['email'])->send(new TestEmail($validatedData));
            return response()->json(['message' => 'Email sent successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email.'], 500);
        }
    }
}
