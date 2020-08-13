<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\model\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public  function index(Request $request){
        $orders = Order::whereHas('client', function ($q) use ($request) {

            return $q->where('name', 'like', '%' . $request->search . '%');

        })->paginate(5);
        return view('dashboard.orders.index',compact('orders'));
    }

    public function products(Order $order)
    {
        $products = $order->products;
        return view('dashboard.orders._products', compact('order', 'products'));

    }//end of products
    public function destroy(Order $order) {
        $order->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');
    } // End of destroy
}
