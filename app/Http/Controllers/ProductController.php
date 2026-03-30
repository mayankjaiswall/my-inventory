<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Return a generated unique slug for a given product name.
     * Accepts optional product_id to exclude from uniqueness check during edit.
     */
    public function generateSlug(Request $request)
    {
        $name = (string) $request->query('name', '');
        $excludeId = $request->query('exclude_id');

        $slug = $this->generateCodeSlug($name, $excludeId ? (int) $excludeId : null);

        return response()->json(['slug' => $slug]);
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'nullable|integer',
            'is_featured' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:5120',
            'weight' => 'nullable|numeric',
            'dimensions' => 'nullable|string',
            'shipping_class' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        // Auto-generate slug/code if not provided (format: XX-123)
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateCodeSlug($data['name']);
        }

        $data['is_featured'] = $request->boolean('is_featured');

        // Handle file upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'nullable|integer',
            'is_featured' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:5120',
            'weight' => 'nullable|numeric',
            'dimensions' => 'nullable|string',
            'shipping_class' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        // Auto-generate slug/code if not provided (format: XX-123)
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateCodeSlug($data['name'], $product->id);
        }

        $data['is_featured'] = $request->boolean('is_featured');

        // Handle file upload and remove old file if replaced
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            // delete old image if present and stored in public disk
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $path;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    /**
     * Generate a short code-based slug like 'TE-377' using the product name.
     * Ensures uniqueness, optionally excluding a product ID.
     */
    private function generateCodeSlug(string $name, int|null $excludeId = null): string
    {
        // derive a 2-letter prefix from name letters
        $letters = preg_replace('/[^A-Za-z]/', '', $name);
        $prefix = strtoupper(substr($letters, 0, 2));
        if (strlen($prefix) < 2) {
            $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $name), 0, 2));
        }
        if (strlen($prefix) < 2) {
            $prefix = 'PR';
        }

        do {
            $rand = random_int(100, 999);
            $slug = $prefix . '-' . $rand;

            $query = Product::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            $exists = $query->exists();
        } while ($exists);

        return $slug;
    }
    

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }
}
