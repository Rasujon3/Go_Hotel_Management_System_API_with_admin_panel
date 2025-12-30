<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageRequest;
use App\Models\Package;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        try {
            if($request->ajax()){

                $products = Package::select('*')->latest();

                return Datatables::of($products)
                    ->addIndexColumn()

                    ->addColumn('name', function($row){
                        return $row->name;
                    })

                    ->addColumn('duration', function($row){
                        return $row->duration;
                    })

                    ->addColumn('price', function($row){
                        return $row->price;
                    })

                    ->addColumn('status', function($row){
                        return $row->status;
                    })

                    ->addColumn('action', function($row){

                        $btn = "";
                        $btn .= '&nbsp;';

                        $btn .= ' <a href="'.route('packages.show',$row->id).'" class="btn btn-primary btn-sm action-button edit-data" data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';

                        $btn .= '&nbsp;';


                        $btn .= ' <a href="#" class="btn btn-danger btn-sm delete-data action-button" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';

                        return $btn;
                    })
                    ->rawColumns(['name','price','duration','status','action'])
                    ->make(true);
            }
            return view('admin.packages.index');
        } catch(Exception $e) {
            // Log the error
            Log::error('Error in storing Package: ', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine()
            ]);
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
    public function create()
    {
        return view('admin.packages.create');
    }
    public function store(PackageRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $package = new Package();
            $package->name = $request->name;
            $package->duration = $request->duration;
            $package->price = $request->price;
            $package->status = $request->status;
            $package->save();

            $notification=array(
                'message' => 'Successfully a Package has been added',
                'alert-type' => 'success',
            );

            DB::commit();

            return redirect()->route('packages.index')->with($notification);

        } catch(Exception $e) {
            DB::rollback();
            // Log the error
            Log::error('Error in storing Package: ', [
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
        return view('admin.packages.edit', compact('package'));
    }
    public function edit()
    {
        return view('admin.packages.edit');
    }
    public function update(PackageRequest $request, Package $package)
    {
        DB::beginTransaction();
        try
        {
            $package->name = $request->name;
            $package->duration = $request->duration;
            $package->price = $request->price;
            $package->status = $request->status;
            $package->save();

            $notification=array(
                'message' => 'Successfully Package has been updated',
                'alert-type' => 'success',
            );

            DB::commit();

            return redirect()->route('packages.index')->with($notification);

        } catch(Exception $e) {
            DB::rollback();
            // Log the error
            Log::error('Error in updating Package: ', [
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
    public function destroy(Package $package)
    {
        DB::beginTransaction();
        try
        {
            $package->delete();

            DB::commit();
            return response()->json(['status'=>true, 'message'=>'Successfully the Package has been deleted']);
        } catch(Exception $e) {
            DB::rollback();
            // Log the error
            Log::error('Error in deleting Package: ', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine()
            ]);

            return response()->json(['status'=>false, 'message'=>'Something went wrong!!!']);
        }
    }
}
