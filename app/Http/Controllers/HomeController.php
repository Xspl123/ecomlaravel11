<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Mail\ContactSubmitted;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

    public function index()
    {
        $slides = Slide::where('status', 1)->take(3)->get();
        $categories = Category::orderBy('name')->get();
        $sproducts = Product::whereNotNull('sale_price')->where('sale_price','<>','')->inRandomOrder()->get()->take(8);
        $fproducts = Product::where('featured',1)->get()->take(8);
        return view('index', compact('slides','categories','sproducts','fproducts'));
    }



    public function contact(){
        return view('contact');
    }

    public function about(){
        return view('about');
    }


    public function addContact()
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'unique:contacts'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:contacts'],
            'comment' => ['required', 'string', 'max:255'],
        ]);

        Contact::create($data);

        Mail::send(new ContactSubmitted($data));

        return redirect()->back()->with('success', 'Thank you for your message. We will get back to you soon.');
    }

    public function contactList(){
        $contacts = Contact::orderBy('created_at','DESC')->paginate(10);
        return view('admin.contact', compact('contacts'));
    }
}
