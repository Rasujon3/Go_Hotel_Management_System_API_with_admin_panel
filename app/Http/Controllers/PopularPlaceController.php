<?php

namespace App\Http\Controllers;

use App\Http\Requests\PopularPlaceRequest;
use App\Models\Package;
use App\Models\PopularPlace;
use App\Services\S3Service;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PopularPlaceController extends Controller
{
    public function index(Request $request)
    {
        try {
            if($request->ajax()){

                $products = PopularPlace::select('*')->latest();

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
                        return '<img src="' . $url . '" alt="popularPlaces Image" style="height:60px;">';
                    })

                    ->addColumn('action', function($row){

                        $btn = "";
                        $btn .= '&nbsp;';

                        $btn .= ' <a href="'.route('popularPlaces.show',$row->id).'" class="btn btn-primary btn-sm action-button edit-data" data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';

                        $btn .= '&nbsp;';

                        $btn .= ' <a href="#" class="btn btn-danger btn-sm delete-data action-button" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';

                        return $btn;
                    })
                    ->rawColumns(['name', 'image_url', 'status', 'action'])
                    ->make(true);
            }

            return view('admin.popularPlaces.index');
        } catch(Exception $e) {
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
    public function create()
    {
        return view('admin.popularPlaces.create');
    }
    public function store(PopularPlaceRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $image_url = null;
            $image_path = null;

            if($request->hasFile('image')) {
                $s3 = app(S3Service::class);
                $file = $request->file('image');
                $result = $s3->upload($file, 'popular_place');

                if ($result) {
                    $image_url = $result['url'];
                    $image_path = $result['path'];
                }
            }

            $popularPlace = new PopularPlace();
            $popularPlace->name = $request->name;
            $popularPlace->status = $request->status;
            $popularPlace->image_url = $image_url;
            $popularPlace->image_path = $image_path;
            $popularPlace->save();

            $notification=array(
                'message' => 'Successfully a Popular Place has been added',
                'alert-type' => 'success',
            );
            DB::commit();

            return redirect()->route('popularPlaces.index')->with($notification);

        } catch(Exception $e) {
            DB::rollback();
            // Log the error
            Log::error('Error in storing Popular Place: ', [
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
    public function show(PopularPlace $popularPlace)
    {
        return view('admin.popularPlaces.edit', compact('popularPlace'));
    }
    public function edit()
    {
        return view('admin.popularPlaces.edit');
    }
    public function update(PopularPlaceRequest $request, PopularPlace $popularPlace)
    {
        try
        {
            $image_url = $popularPlace->image_url;
            $image_path = $popularPlace->image_path;

            if($request->hasFile('image')) {
                $s3 = app(S3Service::class);

                $s3->delete($popularPlace->image_path);

                $file = $request->file('image');
                $result = $s3->upload($file, 'popular_place');

                if ($result) {
                    $image_url = $result['url'];
                    $image_path = $result['path'];
                }
            }

            $popularPlace->name = $request->name;
            $popularPlace->status = $request->status;
            $popularPlace->image_url = $image_url;
            $popularPlace->image_path = $image_path;
            $popularPlace->save();

            $notification=array(
                'message'=>'Successfully the Popular Place has been updated',
                'alert-type'=>'success',
            );

            return redirect()->route('popularPlaces.index')->with($notification);

        } catch(Exception $e) {
            // Log the error
            Log::error('Error in updating Popular Place: ', [
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
    public function destroy(PopularPlace $popularPlace)
    {
        try
        {
            $s3 = app(S3Service::class);
            $s3->delete($popularPlace->image_path);

            $popularPlace->delete();
            return response()->json(['status'=>true, 'message'=>'Successfully the Property Type has been deleted']);
        } catch(Exception $e) {
            DB::rollback();
            // Log the error
            Log::error('Error in deleting Property Type: ', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine()
            ]);

            return response()->json(['status'=>false, 'message'=>'Something went wrong!!!']);
        }
    }
}
