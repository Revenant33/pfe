<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    // Show the contact form
    public function showForm()
    {
        return view('contact');
    }

    // Handle contact form submission
    public function submitForm(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->route('contact.show')->with('success', 'Your message has been sent!');
    }

    // View messages (admin only)
   public function viewMessages(Request $request)
{
    $query = Contact::query();

    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    $messages = $query->latest()->paginate(10);

    return view('contact.messages', compact('messages'));
}

    // Delete message (admin only)
   public function destroy($id)
{
    $message = Contact::findOrFail($id);
    $message->delete();

    return redirect()->route('admin.contact.index')->with('success', 'Message deleted.');
}

}
