<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function brands()
    {
        $brands = Brand::orderBy('id', 'desc')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function addBrand()
    {
        return view('admin.new_brand');
    }

    public function brands_store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Check if the directory exists, if not create it
            $destinationPath = public_path('/uploads/brands');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $imageName);
        } else {
            $imageName = null;
        }

        // Create the brand
        $brand = Brand::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'image' => $imageName,
        ]);

        // Redirect or return response
        return redirect()->route('admin.brand')->with('success', 'Brand created successfully.');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->slug = $request->slug;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('/uploads/brands'), $imageName);
            $brand->image = $imageName;
        }

        $brand->save();

        return redirect()->route('admin.brand', $brand->id)->with('success', 'Brand updated successfully.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        // Delete the image file if exists
        if ($brand->image) {
            $imagePath = public_path('uploads/brands/' . $brand->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $brand->delete();

        return redirect()->route('admin.brand')->with('success', 'Brand deleted successfully.');
    }

    public function categories()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function addCategory()
    {
        return view('admin.add-category');
    }

    public function storeCategory(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Check if the directory exists, if not create it
            $destinationPath = public_path('/uploads/categories');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $imageName);
        } else {
            $imageName = null;
        }

        // Create the category
        $category = Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'image' => $imageName,
        ]);

        // Redirect or return response
        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
    }

    public function CategoryEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories_edit', compact('category'));
    }

    public function CategoryUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('/uploads/categories');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $image->move($destinationPath, $imageName);

            // Delete old image if exists
            if ($category->image) {
                File::delete(public_path('/uploads/categories/' . $category->image));
            }

            $category->image = $imageName;
        }

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
    }

    public function CategoryDestroy($id)
    {
        $category = Category::findOrFail($id);

        // Delete the category image if exists
        if ($category->image) {
            File::delete(public_path('/uploads/categories/' . $category->image));
        }

        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }

    public function products()
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);
        return view('admin.products', compact('products'));
    }


    public function ProductsCreate()
    {
        $brands = Brand::orderBy('created_at', 'desc')->pluck('name', 'id');
        $categories = Category::orderBy('created_at', 'desc')->pluck('name', 'id');
        return view('admin.product-create', compact('brands', 'categories'));
    }


    public function ProductsStore(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:products',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'short_description' => 'required|string|max:100',
            'description' => 'required|string',
            'regular_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'SKU' => 'required|string|max:100|unique:products',
            'quantity' => 'required|integer',
            'stock_status' => 'required|string|in:instock,outofstock',
            'featured' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle the main image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $timestamp = time();
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $imageName = "{$originalName}_{$timestamp}.{$extension}";

            // Ensure the directory exists
            $destinationPath = public_path('/uploads/products/thumbnails');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            // Store file
            $image->move($destinationPath, $imageName);
        }

        // Handle gallery images upload
        $galleryNames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $galleryImage) {
                $timestamp = time();
                $originalName = pathinfo($galleryImage->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $galleryImage->getClientOriginalExtension();
                $galleryImageName = "{$originalName}_{$timestamp}.{$extension}";

                // Ensure the directory exists
                $galleryPath = public_path('/uploads/products/gallery');
                if (!File::exists($galleryPath)) {
                    File::makeDirectory($galleryPath, 0755, true, true);
                }

                // Store file
                $galleryImage->move($galleryPath, $galleryImageName);
                $galleryNames[] = $galleryImageName;
            }
        }

        // Create a new product
        Product::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'category_id' => $request->input('category_id'),
            'brand_id' => $request->input('brand_id'),
            'short_description' => $request->input('short_description'),
            'description' => $request->input('description'),
            'regular_price' => $request->input('regular_price'),
            'sale_price' => $request->input('sale_price'),
            'SKU' => $request->input('SKU'),
            'quantity' => $request->input('quantity'),
            'stock_status' => $request->input('stock_status'),
            'featured' => $request->input('featured'),
            'image' => $imageName,
            'gallery_images' => json_encode($galleryNames),
        ]);

        return redirect()->route('admin.products')->with('success', 'Product created successfully.');
    }
}
