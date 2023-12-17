<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    // Function for dashboard page
    public function dashboard(){
        $today = Carbon::now()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $startOfLastMonth = now()->subMonth()->startOfMonth();
        $endOfLastMonth = now()->subMonth()->endOfMonth();

        // Fetch total sell for today
        $totalSellToday = DB::table('transaction')->whereDate('created_at', $today)->sum('price');

        // Fetch total sell for yesterday
        $totalSellYesterday = DB::table('transaction')->whereDate('created_at', $yesterday)->sum('price');

        // Fetch total sell for this month
        $totalSellThisMonth = DB::table('transaction')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('price');

        // Fetch total sell for last month
        $totalSellLastMonth = DB::table('transaction')->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum('price');

        return view('index', compact('totalSellToday', 'totalSellYesterday', 'totalSellThisMonth', 'totalSellLastMonth'));
    }
    
    // Function for product page
    public function allProduct(){
        $getProducts = DB::table('products')->where('quantity', '>', 0)->get();
        return view('allproducts', compact('getProducts'));
    }

    // Function for transaction page
    public function allTransaction(){
        $getTransaction = DB::table('transaction')->select('transaction.*', 'products.name')->join('products', 'transaction.product_id', '=', 'products.id')->orderBy('created_at', 'DESC')->get();

        return view('alltransaction', ['getTransaction' => $getTransaction]);
    }

    // Function for add product page
    public function addProduct(){
        return view('addproduct');
    }

    // Function for edit product page
    public function editProduct($id){
        $product = DB::table('products')->where('id', $id)->first();
        return view('editproduct', ['product' => $product]);
    }

    // Function for sell product page
    public function sellProduct($id){
        $product = DB::table('products')->where('id', $id)->first();
        return view('sell-product', ['product' => $product]);
    }

    // Function for product delete
    public function deleteProduct($id){
        $product = DB::table('products')->where('id', $id)->delete();
        if($product){
            return back();
        }
    }

    // Function for product add
    public function productAdd(Request $request){
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        $productName     = $request->input('name');
        $productPrice    = $request->input('price');
        $productQuantity = $request->input('quantity');

        $result = DB::table('products')->insert([
            'name' => $productName,
            'unit_price' => $productPrice,
            'quantity' => $productQuantity
        ]);

        if($result){
            return redirect('/product');
        } else{
            return redirect('/add-product')->with('errormsg', 'Something went wrong!');
        }

    }

    // Function for product update
    public function productUpdate($id, Request $request){
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        $productName = $request->input('name');
        $productPrice = $request->input('price');
        $productQuantity = $request->input('quantity');

        $result = DB::table('products')->where('id', $id)->update([
                'name' => $productName,
                'unit_price' => $productPrice,
                'quantity' => $productQuantity
            ]);

        if ($result) {
            return back()->with('successmsg', 'Product updated successfully');
        } else {
            return back()->with('errormsg', 'Something went wrong!');
        }
    }

    // Function for porduct sell
    public function productSell($id, Request $request){
        $productById = DB::table('products')->where('id', '=', $id)->first();
        $oldQuantity = $productById->quantity;
    
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);
    
        $productPrice = $request->input('price');
        $productQuantity = $request->input('quantity');
        $remainingQuantity = $oldQuantity - $productQuantity;
        $totalPrice = $productQuantity * $productPrice;

        if($productQuantity > $oldQuantity){
            return back()->with('errormsg', 'There are '.$oldQuantity.' products in stock!');
        } else{
            $result = DB::table('transaction')->insert([
                'product_id' => $id,
                'price' => $totalPrice,
                'quantity' => $productQuantity
            ]);
        
            $updateQuantity = DB::table('products')->where('id', $id)->update([
                'quantity' => $remainingQuantity
            ]);
        
            if ($result && $updateQuantity) {
                return back()->with('successmsg', 'Product sold successfully');
            } else {
                return back()->with('errormsg', 'Something went wrong!');
            }
        }
    }
    

}
