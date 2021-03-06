<?php
namespace App\Http\Controllers;

use App\Customer;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Crud4Controller extends Controller
{
    public function index(Request $request)
    {
        $images = Image::orderBy('created_at', 'desc')->paginate(8);
        return view('crud_4.index', compact('images'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get'))
            return view('crud_4.form');
        else {
            $rules = [
                'description' => 'required',
            ];
            $this->validate($request, $rules);
            $image = new Image();
            if ($request->hasFile('image')) {
                $dir = 'uploads/';
                $extension = strtolower($request->file('image')->getClientOriginalExtension()); // get image extension
                $fileName = Str::random(40) . '.' . $extension; // rename image
                $request->file('image')->move($dir, $fileName);
                $image->image = $fileName;
            }
            $image->description = $request->description;
            $image->save();
            return redirect('/laravel-crud-image-gallery');
        }
    }

    public function delete($id)
    {
        Image::destroy($id);
        return redirect('/laravel-crud-image-gallery');
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('get'))
            return view('crud_4.form', ['image' => Image::find($id)]);
        else {
            $rules = [
                'description' => 'required',
            ];
            $this->validate($request, $rules);
            $image = Image::find($id);
            if ($request->hasFile('image')) {
                $dir = 'uploads/';
                if ($image->image != '' && File::exists($dir . $image->image))
                    File::delete($dir . $image->image);
                $extension = strtolower($request->file('image')->getClientOriginalExtension());
                $fileName = str_random() . '.' . $extension;
                $request->file('image')->move($dir, $fileName);
                $image->image = $fileName;
            } elseif ($request->remove == 1 && File::exists('uploads/' . $image->image)) {
                File::delete('uploads/' . $image->post_image);
                $image->image = null;
            }
            $image->description = $request->description;
            $image->save();
            return redirect('/laravel-crud-image-gallery');
        }
    }
}
