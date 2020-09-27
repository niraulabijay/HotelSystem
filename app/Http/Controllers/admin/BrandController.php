<?php

namespace App\Http\Controllers\admin;

use App\Model\Brand;
use App\Http\Controllers\Controller;
use App\tableList;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class BrandController extends Controller
{
    public function index(){
        $brands = Brand::all();
        return view('admin.brand.index',compact('brands'));
    }

    public function add(Request $request){
        $request->validate([
           'title' => 'required|unique:brands,title',
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
        Toastr::success('New Brand Added Successfully','Operation Success');
        return redirect()->back();
    }

    public function edit($id){
        $brands = Brand::all();
        $editBrand = Brand::findOrFail($id);
        return view('admin.brand.index',compact('brands','editBrand'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required|unique:brands,title,'.$request->id.',id',
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
            Toastr::error($e->getMessage(),'Server Error');
            return redirect()->back();
        }
        Toastr::success('Brand Updated Successfully','Operation success');
        return redirect()->route('admin.brands');
    }

    public function delete(Request $request){
        $id_key = 'brand_id';

        $tables = tableList::getTableList($id_key);
        $brand = Brand::find($request->brand_id);
        try {
            if($brand->hotels->count() > 0){
                Toastr::error('This data already used in  : ' . $tables . ' Please remove those data first');
                return redirect()->back();
            }
            $delete_query = $brand->delete();
            if ($delete_query) {
                Toastr::success('Brand has been deleted successfully','Operation Success');
                return redirect()->back();
            } else {
                Toastr::error('Something went wrong, please try again','Operation Failed');
            }

        } catch (\Illuminate\Database\QueryException $e) {
            // dd($e->getMessage());
            Toastr::error('This data already used in  : ' . $tables . ' Please remove those data first','Operation Failed');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(),'Server Error');
            return redirect()->back();
        }

    }
}
