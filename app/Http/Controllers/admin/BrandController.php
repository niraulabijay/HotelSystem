<?php

namespace App\Http\Controllers\admin;

use App\Brand;
use App\Http\Controllers\Controller;
use App\tableList;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(){
        tableList::getTableList('brand_id');
        $brands = Brand::all();
        return view('admin.brand.index',compact('brands'));
    }

    public function add(Request $request){
        // dd($request);
        $request->validate([
           'title' => 'required|unique:brands',
            'logo' => 'required|mimes:jpeg,bmp,png',
        ]);
        $brand = new Brand();
        $brand->title = $request->title;
        $brand->description = $request->description;
        $brand->status = "Active";
        $brand->save();
        if($request->hasFile('logo')){
            $brand->addMediaFromRequest('logo')
                ->toMediaCollection('brand_logo')
                ->setCustomProperty('logo','1');
        }
        return redirect()->back()->with('sweetAlert-success','New Brand Added Successfully');
    }

    public function edit($id){
        $brands = Brand::all();
        $editBrand = Brand::findOrFail($id);
        return view('admin.brand.index',compact('brands','editBrand'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required|unique:brands,title,'.$request->id,
            'logo' => 'required|mimes:jpeg,bmp,png',
        ]);
        try{
            $brand = Brand::find($request->id);
            $brand->title = $request->title;
            $brand->description = $request->description;
            $brand->status = "Active";
            $brand->save();
            if($request->hasFile('logo')){
                $brand->updateMediaFromRequest('logo')
                    ->toMediaCollection('brand_logo')
                    ->setCustomProperty('logo','1');
            }
        }catch(\Exception $e){
            return redirect()->back()->with('sweetAlert-error',$e->getMessage());
        }
        return redirect()->back()->with('sweetAlert-success','New Brand Added Successfully');
    }

    public function delete(Request $request){
        $id_key = 'fees_type_id';

        $tables = tableList::getTableList($id_key);
        $brand = Brand::find($request->brand_id);
        try {
            if($brand->hasMedia('brand_logo')){
                foreach($brand->getMedia('brand_logo') as $media){
                    $delete = $brand->deleteMedia($media);
                }
            }
            $delete_query = $brand->delete();
            if ($delete_query) {
                return redirect()->back()->with('sweetAlert-success', 'Fees Type has been deleted successfully');
            } else {
                return redirect()->back()->with('sweetAlert-error', 'Something went wrong, please try again');
            }

        } catch (\Illuminate\Database\QueryException $e) {
            dd($e->getMessage());
            $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
            return redirect()->back()->with('sweetAlert-error', $msg);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('sweetAlert-error', 'Something went wrong, please try again');
        }

    }
}
