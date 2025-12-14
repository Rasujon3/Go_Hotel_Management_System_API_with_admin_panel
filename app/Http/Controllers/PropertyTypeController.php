<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyTypeRequest;
use App\Models\PropertyType;
use App\Services\S3Service;
use Exception;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PropertyTypeController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            if($request->ajax()){

                $products = PropertyType::select('*')->latest();

                return Datatables::of($products)
                    ->addIndexColumn()

                    ->addColumn('name', function($row){
                        return $row->name;
                    })

                    ->addColumn('status', function($row){
                        return $row->status;
                    })

                    ->addColumn('image_url', function($row){
                        $url = asset($row->image_url);
                        return '<img src="' . $url . '" alt="PropertyType Image" style="height:60px;">';
                    })

                    ->addColumn('action', function($row){

                        $btn = "";
                        $btn .= '&nbsp;';

                        $btn .= ' <a href="'.route('propertyTypes.show',$row->id).'" class="btn btn-primary btn-sm action-button edit-product" data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';

                        $btn .= '&nbsp;';


                        $btn .= ' <a href="#" class="btn btn-danger btn-sm delete-data action-button" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';

                        return $btn;
                    })
                    ->rawColumns(['name','status','image_url','action'])
                    ->make(true);
            }

            return view('admin.propertyTypes.index');
        }catch(Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
    public function create()
    {
        return view('admin.propertyTypes.create');
    }
    public function store(PropertyTypeRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $image_url = null;
            $image_path = null;

            if($request->hasFile('image')) {
                $s3 = app(S3Service::class);
                $file = $request->file('image');
                $result = $s3->upload($file, 'propertyType');

                if ($result) {
                    $image_url = $result['url'];
                    $image_path = $result['path'];
                }
            }

            $propertyType = new PropertyType();
            $propertyType->name = $request->name;
            $propertyType->status = $request->status;
            $propertyType->image_url = $image_url;
            $propertyType->image_path = $image_path;
            $propertyType->save();

            $notification=array(
                'message' => 'Successfully a Property Type has been added',
                'alert-type' => 'success',
            );
            DB::commit();

            return redirect()->route('propertyTypes.index')->with($notification);

        } catch(Exception $e) {
            DB::rollback();
            // Log the error
            Log::error('Error in storing Property Type: ', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            $notification=array(
                'message' => 'Something went wrong!!!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function show(PropertyType $propertyType)
    {
        return view('admin.propertyTypes.edit', compact('propertyType'));
    }
    public function edit(PropertyTypeRequest $propertyType)
    {
        //
    }
    public function update(PropertyTypeRequest $request, PropertyType $propertyType)
    {
        try
        {
            $image_url = $propertyType->image_url;
            $image_path = $propertyType->image_path;

            if($request->hasFile('image')) {
                $s3 = app(S3Service::class);

                $s3->delete($propertyType->image_path);

                $file = $request->file('image');
                $result = $s3->upload($file, 'propertyType');

                if ($result) {
                    $image_url = $result['url'];
                    $image_path = $result['path'];
                }
            }

            $propertyType->name = $request->name;
            $propertyType->status = $request->status;
            $propertyType->image_url = $image_url;
            $propertyType->image_path = $image_path;
            $propertyType->save();

            $notification=array(
                'message'=>'Successfully the Property Type has been updated',
                'alert-type'=>'success',
            );

            return redirect()->route('propertyTypes.index')->with($notification);

        } catch(Exception $e) {
            // Log the error
            Log::error('Error in updating Property Type: ', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            $notification=array(
                'message' => 'Something went wrong!!!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function destroy(PropertyType $propertyType)
    {
        try
        {
            $s3 = app(S3Service::class);
            $s3->delete($propertyType->image_path);

            $propertyType->delete();
            return response()->json(['status'=>true, 'message'=>'Successfully the Property Type has been deleted']);
        } catch(Exception $e) {
            DB::rollback();
            // Log the error
            Log::error('Error in deleting Property Type: ', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            $notification=array(
                'message' => 'Something went wrong!!!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
