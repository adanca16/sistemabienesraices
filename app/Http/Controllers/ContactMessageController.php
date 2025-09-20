<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $q = ContactMessage::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%'.$request->search.'%';
                $query->where(function ($w) use ($term) {
                    $w->where('name', 'like', $term)
                      ->orWhere('email', 'like', $term)
                      ->orWhere('phone', 'like', $term)
                      ->orWhere('preferred_zone', 'like', $term)
                      ->orWhere('subject', 'like', $term)
                      ->orWhere('message', 'like', $term);
                });
            })
            ->when($request->filled('listing_type'), fn($qq)=>$qq->where('listing_type',$request->listing_type))
            ->when($request->filled('property_type'), fn($qq)=>$qq->where('property_type','like','%'.$request->property_type.'%'))
            ->orderByDesc('id');

        $messages = $q->paginate(15)->withQueryString();

        return view('contact_messages.index', compact('messages'));
    }
}
