<?php

namespace App\Http\Controllers;

use App\Http\Requests\WithdrawRequest;
use App\Models\Hotel;
use App\Models\Package;
use App\Models\Withdraw;
use App\Models\WithdrawalMethod;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        try {
            if($request->ajax()){

                $products = Withdraw::with('hotel')->select('*')->latest();

                return Datatables::of($products)
                    ->addIndexColumn()

                    ->addColumn('title', function($row){
                        return $row->title;
                    })

                    ->addColumn('hotel_name', function($row){
                        return $row->hotel?->hotel_name ?? 'N/A';
                    })

                    ->addColumn('payment_type', function($row){
                        return $row->payment_type;
                    })

                    ->addColumn('amount', function($row){
                        return $row->amount;
                    })

                    ->addColumn('withdraw_at', function($row){
                        return $row->withdraw_at;
                    })

                    ->addColumn('action', function($row){

                        $btn = "";
                        $btn .= '&nbsp;';

                        # $btn .= ' <a href="'.route('withdraws.show',$row->id).'" class="btn btn-primary btn-sm action-button edit-data" data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';

                        # $btn .= '&nbsp;';

                        $btn .= ' <a href="#" class="btn btn-danger btn-sm delete-data action-button" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';

                        return $btn;
                    })
                    ->rawColumns(['title','hotel_name','payment_type','amount','withdraw_at','action'])
                    ->make(true);
            }
            return view('admin.withdraws.index');
        } catch(Exception $e) {
            // Log the error
            Log::error('Error in storing Withdraw: ', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine()
            ]);
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
    public function create()
    {
        $hotels = Hotel::with('withdrawMethod')->get();
        return view('admin.withdraws.create', compact('hotels'));
    }
    public function store(WithdrawRequest $request)
    {
        try {
            $hotelId = $request->hotel_id;
            $amount = $request->amount;

            $checkWithdrawalMethodExist = $this->checkWithdrawalMethodExist($hotelId);
            if (!$checkWithdrawalMethodExist) {
                $notification=array(
                    'message' => 'No withdrawal method found.',
                    'alert-type' => 'error'
                );

                return redirect()->back()->with($notification);
            }

            $checkBalance = $this->checkBalance($hotelId, $amount);
            if (!$checkBalance) {
                $notification=array(
                    'message' => 'You can not withdraw more than balance.',
                    'alert-type' => 'error'
                );

                return redirect()->back()->with($notification);
            }

            // start store data
            $userId  = auth()->id();
            // Get withdrawal method
            $withdrawalMethod = WithdrawalMethod::where('hotel_id', $hotelId)->firstOrFail();

            DB::beginTransaction();

            $withdraw = new Withdraw();
            $withdraw->user_id = $userId;
            $withdraw->hotel_id = $hotelId;
            $withdraw->withdrawal_method_id = $withdrawalMethod->id;
            $withdraw->title = $withdrawalMethod->payment_method . '_' . $withdrawalMethod->acc_no;
            $withdraw->payment_type = $request->payment_type;
            $withdraw->amount = $amount;
            $withdraw->withdraw_at = $request->withdraw_at;
            $withdraw->trx_id = $request->trx_id;
            $withdraw->reference = $request->reference;
            $withdraw->created_by = $userId;
            $withdraw->save();

            // Update hotel balance
            $hotel = Hotel::lockForUpdate()->findOrFail($hotelId);
            $hotel->balance = $hotel->balance - $amount;
            $hotel->save();

            DB::commit();

            $notification=array(
                'message' => 'Withdraw request created successfully.',
                'alert-type' => 'success'
            );

            return redirect()->route('withdraws.index')->with($notification);

        } catch(Exception $e) {
            DB::rollback();
            // Log the error
            Log::error('Error in storing Withdraw: ', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine()
            ]);

            $notification=array(
                'message' => 'Something went wrong!!!',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
    }
    public function show(Package $package)
    {
        //
    }
    public function edit()
    {
        return view('admin.withdraws.edit');
    }
    public function update(Request $request, Package $package)
    {
        //
    }
    public function destroy(Withdraw $withdraw)
    {
        DB::beginTransaction();
        try {
            // 1. Add amount to hotel balance
            $hotel = Hotel::where('id', $withdraw->hotel_id)->first();
            $prevAmount = $withdraw->amount;

            $hotel->balance = $hotel->balance + $prevAmount;
            $hotel->update();

            // 2. Finally, delete itself
            $withdraw->delete();

            DB::commit();
            return response()->json(['status'=>true, 'message'=>'Successfully the Withdraw has been deleted']);

        } catch (Exception $e) {
            DB::rollBack();

            // Log error
            Log::error('Error deleting data: ' , [
                'id' => $withdraw->id,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine()
            ]);

            return response()->json(['status'=>false, 'message'=>'Something went wrong!!!']);
        }
    }
    public function getHotelWithdrawInfo($id)
    {
        $hotel = Hotel::with('withdrawMethod')
            ->findOrFail($id);

        return response()->json([
            'balance' => $hotel->balance,
            'acc_no' => $hotel->withdrawMethod?->acc_no,
            'payment_method' => $hotel->withdrawMethod?->payment_method,
        ]);
    }
    private function checkWithdrawalMethodExist($hotelId)
    {
        $check = WithdrawalMethod::where('hotel_id', $hotelId)->first();

        return $check;
    }
    private function checkBalance($hotelId, $amount)
    {
        $hotelBalance = Hotel::where('id', $hotelId)->value('balance');
        $status = $hotelBalance >= $amount;

        return $status;
    }

}
