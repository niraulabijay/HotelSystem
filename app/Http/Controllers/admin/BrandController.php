<?php

namespace App\Http\Controllers\admin;

use App\Model\Brand;
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
        $request->validate([
           'title' => 'required|unique:brands,title,NULL,id,deleted_at,NULL',
            'logo' => 'required|mimes:jpeg,bmp,png',
        ]);
        $brand = new Brand();
        $brand->title = $request->title;
        $brand->description = $request->description;
        if($request->status){
            $brand->status = "Active";
        }else{
            $brand->status = "Inactive";
        }
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
            'title' => 'required|unique:brands,title,'.$request->id.',id,deleted_at,NULL',
            'logo' => 'mimes:jpeg,bmp,png',
        ]);
        try{
            $brand = Brand::find($request->id);
            $brand->title = $request->title;
            $brand->description = $request->description;
            if($request->status){
                $brand->status = "Active";
            }else{
                $brand->status = "Inactive";
            }
            $brand->save();
            if($request->hasFile('logo')){
                $brand->addMediaFromRequest('logo')
                    ->toMediaCollection('brand_logo');
            }
        }catch(\Exception $e){
            return redirect()->back()->with('sweetAlert-error',$e->getMessage());
        }
        return redirect()->route('admin.brands')->with('sweetAlert-success','Brand Updated Successfully');
    }

    public function delete(Request $request){
        $id_key = 'brand_id';

        $tables = tableList::getTableList($id_key);
        $brand = Brand::find($request->brand_id);
        try {
            if($brand->hotels->count() > 0){
                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                return redirect()->back()->with('sweetAlert-error', $msg);
            }
            if($brand->hasMedia('brand_logo')){
                foreach($brand->getMedia('brand_logo') as $media){
                    $delete = $brand->deleteMedia($media);
                }
            }
            $delete_query = $brand->delete();
            if ($delete_query) {
                return redirect()->back()->with('sweetAlert-success', 'Brand has been deleted successfully');
            } else {
                return redirect()->back()->with('sweetAlert-error', 'Something went wrong, please try again');
            }

        } catch (\Illuminate\Database\QueryException $e) {
            // dd($e->getMessage());
            $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
            return redirect()->back()->with('sweetAlert-error', $msg);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('sweetAlert-error', 'Something went wrong, please try again');
        }

    }
}
