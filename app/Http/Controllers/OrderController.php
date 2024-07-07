<?php

namespace App\Http\Controllers;

use App\Enum\OrderStatus as EnumOrderStatus;
use App\Models\Order;
use App\Services\ProcessIdSelector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrderStatus;
use App\Services\OrderAPIEndPoint;
use DateTime;

class OrderController extends Controller
{

    /**
     * API
     * Display all orders placed by logged in user
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return $orders;
        
    }


    /**
     * API
     * Store a newly created Order.
     * 
     */
    public function store(Request $request)
    {
        //Validating 
        $request->validate([
            'customer_name' => 'required|max:255|string',
            'value' => ['required',
                        'regex:/^\d{1,8}(\.\d{1,2})?$/'
                        ],
        ]);

        //Get processing ID
        $processing_id = new ProcessIdSelector();
        $newOrder = Order::create([
            'customer_name'=>$request->customer_name,
            'process_id' => $processing_id->getId(),
            'value' => $request->value,
            'status' => OrderStatus::PROCESSING,
            'user_id' => Auth::id()
        ]);

        $Order_Date = new DateTime($newOrder->created_at);


        //Create payload using newly created order model for api endpoint at beeceptor.com
        $apiData = [
            "Order_ID" => strval($newOrder->id),
            "Customer_Name" => $newOrder->customer_name,
            "Order_Value" => (float)$newOrder->value,
            "Order_Date" => $Order_Date->format('Y-m-d H:i:s'),
            "Order_Status"=> $newOrder->status,
            "Process_ID" => strval($newOrder->process_id)
        ];

        //sending created order payload to api endpoint
        // $orderAPI = new OrderAPIEndPoint();
        // return $orderAPI->send($apiData);        
        return "Order added successfully";
    }
}
