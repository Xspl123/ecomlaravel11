<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupan;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;



class AdminController extends Controller
{
    // public function index()
    // {

    //     $totalOrders = Order::count();
    //     $totalAmount = Order::sum('total');

    //     $pendingOrders = Order::where('status', 'pending')->count();
    //     $pendingOrdersAmount = Order::where('status', 'pending')->sum('total');

    //     $deliveredOrders = Order::where('status', 'delivered')->count();
    //     $deliveredOrdersAmount = Order::where('status', 'delivered')->sum('total');

    //     $canceledOrders = Order::where('status', 'canceled')->count();
    //     $canceledOrdersAmount = Order::where('status', 'canceled')->sum('total');
    //     $recentOrders = Order::orderBy('created_at', 'DESC')->limit(5)->get();

    //     // Define date ranges
    //     $thisWeekStart = Carbon::now()->startOfWeek();
    //     $thisWeekEnd = Carbon::now()->endOfWeek();
    //     $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
    //     $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();

    //     // Fetch data for this week
    //     $earningsThisWeek = Order::whereBetween('created_at', [$thisWeekStart, $thisWeekEnd])->sum('total');
    //     $totalOrdersThisWeek = Order::whereBetween('created_at', [$thisWeekStart, $thisWeekEnd])->count();

    //     // Fetch data for last week
    //     $earningsLastWeek = Order::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->sum('total');
    //     $totalOrdersLastWeek = Order::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();

    //     // Calculate percentage change
    //     $revenueChange = $earningsLastWeek == 0 ? 0 : (($earningsThisWeek - $earningsLastWeek) / $earningsLastWeek) * 100;
    //     $orderChange = $totalOrdersLastWeek == 0 ? 0 : (($totalOrdersThisWeek - $totalOrdersLastWeek) / $totalOrdersLastWeek) * 100;



    //     return view('admin.index', compact(
    //         'totalOrders',
    //         'totalAmount',
    //         'pendingOrders',
    //         'pendingOrdersAmount',
    //         'deliveredOrders',
    //         'deliveredOrdersAmount',
    //         'canceledOrders',
    //         'canceledOrdersAmount',
    //         'recentOrders',
    //         'earningsThisWeek',
    //         'earningsLastWeek',
    //         'totalOrdersThisWeek',
    //         'totalOrdersLastWeek',
    //         'revenueChange',
    //         'orderChange'
    //     ));
    // }

    public function index()
    {
        // Order statistics
        $totalOrders = Order::count();
        $totalAmount = Order::sum('total');

        $pendingOrders = Order::where('status', 'pending')->count();
        $pendingOrdersAmount = Order::where('status', 'pending')->sum('total');

        $deliveredOrders = Order::where('status', 'delivered')->count();
        $deliveredOrdersAmount = Order::where('status', 'delivered')->sum('total');

        $canceledOrders = Order::where('status', 'canceled')->count();
        $canceledOrdersAmount = Order::where('status', 'canceled')->sum('total');
        $recentOrders = Order::orderBy('created_at', 'DESC')->limit(5)->get();

        // Define date ranges
        $thisWeekStart = Carbon::now()->startOfWeek();
        $thisWeekEnd = Carbon::now()->endOfWeek();
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();

        // Fetch data for this week
        $earningsThisWeek = Order::whereBetween('created_at', [$thisWeekStart, $thisWeekEnd])->sum('total');
        $totalOrdersThisWeek = Order::whereBetween('created_at', [$thisWeekStart, $thisWeekEnd])->count();

        // Fetch data for last week
        $earningsLastWeek = Order::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->sum('total');
        $totalOrdersLastWeek = Order::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();

        // Calculate percentage change
        $revenueChange = $earningsLastWeek == 0 ? 0 : (($earningsThisWeek - $earningsLastWeek) / $earningsLastWeek) * 100;
        $orderChange = $totalOrdersLastWeek == 0 ? 0 : (($totalOrdersThisWeek - $totalOrdersLastWeek) / $totalOrdersLastWeek) * 100;

        // Data for chart (monthly)
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $totalMonthlyData = $this->getMonthlyData('total');
        $pendingMonthlyData = $this->getMonthlyData('pending');
        $deliveredMonthlyData = $this->getMonthlyData('delivered');
        $canceledMonthlyData = $this->getMonthlyData('canceled');

        return view('admin.index', compact(
            'totalOrders',
            'totalAmount',
            'pendingOrders',
            'pendingOrdersAmount',
            'deliveredOrders',
            'deliveredOrdersAmount',
            'canceledOrders',
            'canceledOrdersAmount',
            'recentOrders',
            'earningsThisWeek',
            'earningsLastWeek',
            'totalOrdersThisWeek',
            'totalOrdersLastWeek',
            'revenueChange',
            'orderChange',
            'months',
            'totalMonthlyData',
            'pendingMonthlyData',
            'deliveredMonthlyData',
            'canceledMonthlyData'
        ));
    }

    private function getMonthlyData($status)
    {
        $data = [];
        foreach (range(1, 12) as $month) {
            $start = Carbon::now()->month($month)->startOfMonth();
            $end = Carbon::now()->month($month)->endOfMonth();
            if ($status === 'total') {
                $data[] = Order::whereBetween('created_at', [$start, $end])->sum('total');
            } else {
                $data[] = Order::where('status', $status)
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('total');
            }
        }
        return $data;
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
        // dd($request);
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
                $galleryPath = public_path('/uploads/products');

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

    public function ProductsShow($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product-show', compact('product'));
    }

    public function ProductsEdit($id)
    {
        $product = Product::findOrFail($id);
        $brands = Brand::orderBy('created_at', 'desc')->pluck('name', 'id');
        $categories = Category::orderBy('created_at', 'desc')->pluck('name', 'id');
        return view('admin.product-edit', compact('product', 'brands', 'categories'));
    }

    public function ProductsUpdate(Request $request, $id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:products,slug,' . $id,
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'short_description' => 'required|string|max:100',
            'description' => 'required|string',
            'regular_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'SKU' => 'required|string|max:100|unique:products,SKU,' . $id,
            'quantity' => 'required|integer',
            'stock_status' => 'required|string|in:instock,outofstock',
            'featured' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle the main image upload
        $imageName = $product->image;
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

            // Delete the old image if exists
            if ($product->image && File::exists($destinationPath . '/' . $product->image)) {
                File::delete($destinationPath . '/' . $product->image);
            }
        }

        // Handle gallery images upload
        $galleryNames = $product->images ? json_decode($product->images) : [];
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

        // Update the product
        $product->update([
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
            'images' => json_encode($galleryNames),
        ]);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    public function ProductDestroy($id)
    {
        // Find the product by its ID
        $product = Product::findOrFail($id);

        // Delete the product's main image from the server
        if ($product->image) {
            $imagePath = public_path('/uploads/products/thumbnails/' . $product->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        // Delete the product's gallery images from the server
        if ($product->gallery_images) {
            $galleryImages = json_decode($product->gallery_images);
            foreach ($galleryImages as $galleryImage) {
                $galleryImagePath = public_path('/uploads/products/gallery/' . $galleryImage);
                if (File::exists($galleryImagePath)) {
                    File::delete($galleryImagePath);
                }
            }
        }

        // Delete the product from the database
        $product->delete();

        // Redirect to the products list with a success message
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }


    public function coupans()
    {
        $coupans = Coupan::orderBy('expiry_date', 'DESC')->paginate(10);
        return view('admin.coupans', compact('coupans'));
    }

    public function addCoupon()
    {
        return view('admin.coupan-create');
    }

    public function storeCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:coupans',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);

        Coupan::create([
            'code' => $request->input('code'),
            'type' => $request->input('type'),
            'value' => $request->input('value'),
            'cart_value' => $request->input('cart_value'),
            'expiry_date' => $request->input('expiry_date'),
        ]);

        return redirect()->route('admin.coupons')->with('success', 'Coupon created successfully.');
    }

    public function CouponEdit($id)
    {
        $coupon = Coupan::findOrFail($id);
        return view('admin.coupan-edit', compact('coupon'));
    }


    public function updateCoupon(Request $request, $id)
    {

        $request->validate([
            'code' => 'required|string|max:10|unique:coupans,code,' . $id,
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);
        $coupon = Coupan::findOrFail($id);
        $coupon->update([
            'code' => $request->input('code'),
            'type' => $request->input('type'),
            'value' => $request->input('value'),
            'cart_value' => $request->input('cart_value'),
            'expiry_date' => $request->input('expiry_date'),
        ]);
        return redirect()->route('admin.coupons')->with('success', 'Coupon updated successfully.');
    }


    public function CouponDestroy($id)
    {

        $coupon = Coupan::findOrFail($id);
        $coupon->delete();
        return redirect()->route('admin.coupons')->with('success', 'Coupon deleted successfully.');
    }


    public function orders(Request $request)
    {
        $query = Order::query();
        $search = $request->input('name');

        if (!empty($search)) {
            $columns = Schema::getColumnListing('orders');
            $query->where(function ($q) use ($columns, $search) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            });
        }

        $orders = $query->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.orders', compact('orders'));
    }


    public function order_details($id){

        $order = Order::where('id',$id)->first();
        $order_items = OrderItem::where('order_id', $id)->orderBy('id')->paginate(3);
        $transations = Transaction::where('order_id', $id)->first();
        //dd($transations);
        return view('admin.order_details', compact('order', 'order_items','transations'));
    }
}
