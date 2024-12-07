<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import the Product model

class HomeController extends Controller
{
    public function index()
    {
        // Fetch products from the database, e.g., paginated
        $products = Product::paginate(12); // Adjust the pagination number as needed

        // Pass the products to the view
        return view('index', compact('products'));
    }
}

