<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Models\Product;

class ProductController extends Controller
{
    private $product_repository;
    private $category_repository;

    public function __construct(ProductRepositoryInterface $product_repository, CategoryRepositoryInterface $category_repository)
    {
        $this->product_repository = $product_repository;
        $this->category_repository = $category_repository;
    }
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
        })->paginate(5);

        return view('products.index', compact('products', 'search'));
        /* 
        $products = Product::with('category')->paginate(6); // 10 productos por página
        return view('products.index', compact('products')); */
    }


    public function create()
    {
        $categories = $this->category_repository->all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $this->product_repository->create($validated_data);

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit($id)
    {
        $product = $this->product_repository->find($id);
        $categories = $this->category_repository->all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $this->product_repository->update($id, $validated_data);

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $this->product_repository->delete($id);
        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }
    public function show($id)
    {
        $this->product_repository->find($id);
        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }

    public function search($search)
    {
        //$search = $request->input('search');

        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
        })->get();

        return response()->json($products);
    }

    public function findByBarcode($barcode)
    {
        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return response()->json($product);
    }


}
