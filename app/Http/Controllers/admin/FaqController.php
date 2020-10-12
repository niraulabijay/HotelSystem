<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Model\Faq;
use App\Model\FaqCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index(){
        $faqCategories = FaqCategory::all();
        return view('admin.faq.index',compact('faqCategories'));
    }

    public function storeCategory(Request $request){
        $request->validate([
            'title' => 'required',
        ]);
        try{
            $faqCategory = FaqCategory::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status=="on" ? 1 : 0,
            ]);
        }catch(\Exception $e){
            Toastr::error($e->getMessage(),'Server Error');
            return redirect()->back();
        }
        Toastr::success('Category for faq created','Operation Success');
        return redirect()->back();
    }

    public function editCategory($slug){
        $editFaqCategory = FaqCategory::where('slug',$slug)->first();
        $faqCategories = FaqCategory::all();
        return view('admin.faq.index',compact('faqCategories','editFaqCategory'));
    }

    public function updateCategory(Request $request, $slug){
        $request->validate([
            'title' => 'required',
        ]);
        try{
            $faqCategory = FaqCategory::find($request->id);
            $faqCategory->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status=="on" ? 1 : 0,
            ]);
        }catch(\Exception $e){
            Toastr::error($e->getMessage(),'Server Error');
            return redirect()->back();
        }
        Toastr::success('Category updated.','Operation Success');
        return redirect()->route('admin.faqs');
    }

    public function deleteCategory(Request $request){
        try{
            $faqCategory = FaqCategory::find($request->id);
            if(!$faqCategory){
                Toastr::error('Something went wrong','Delete Failed');
                return redirect()->back();
            }
            $questions = $faqCategory->faqs ?? [];
            foreach($questions as $ques){
                $ques->delete();
            }
            $faqCategory->delete();
            Toastr::success('FAQ Category Deleted Successfully.','Operation Success');
            return redirect()->route('admin.faqs');
        }catch(\Exception $e){
            Toastr::error($e->getMessage(),'Server Error');
            return redirect()->back();
        }
    }

    public function storeQuestion(Request $request){
        try{
            $input = $request->all();
            $validator = Validator::make($input,[
                'category' => 'required',
                'question' => 'required',
                'answer' => 'required'
            ]);
            if($validator->fails()){
                Toastr::error('Please enter all the fields','Failed to create FAQ');
                return redirect()->back();
            }
            $faqCategory = FaqCategory::find($request->category);
            $faqCategory->faqs()->create([
                'question' => $request->question,
                'answer' => $request->answer
            ]);
            Toastr::success('Faq created successfully','Operation success');
            return redirect()->back();
        }catch(\Exception $e){
            Toastr::error($e->getMessage(),'Server Error');
            return redirect()->back();
        }

    }

    public function editQuestion(Request $request){
        try{
            $editFaq = Faq::find($request->faq_id);
            $faqCategories = FaqCategory::all();
            $view = view('admin.faq.editQuestion',compact('faqCategories','editFaq'))->render();
            return response()->json($view,200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(),400);
        }
    }

    public function updateQuestion(Request $request){
        try{
            $input = $request->all();
            $validator = Validator::make($input,[
                'id' => 'required',
                'category' => 'required',
                'question' => 'required',
                'answer' => 'required'
            ]);
            if($validator->fails()){
                Toastr::error('Please enter all the fields','Failed to update FAQ');
                return redirect()->back();
            }
            $faq = Faq::find($request->id);
            $faq->update([
                'faq_category_id' => $request->category,
                'question' => $request->question,
                'answer' => $request->answer
            ]);
            Toastr::success('Faq created successfully','Operation success');
            return redirect()->back();
        }catch(\Exception $e){
            Toastr::error($e->getMessage(),'Server Error');
            return redirect()->back();
        }
    }

    public function deleteQuestion(Request $request){
        try{
            $faq = Faq::find($request->id);
            if(!$faq){
                Toastr::error('Something went wrong','Delete Failed');
                return redirect()->back();
            }
            $faq->delete();
            Toastr::success('FAQ Deleted Successfully.','Operation Success');
            return redirect()->route('admin.faqs');
        }catch(\Exception $e){
            Toastr::error($e->getMessage(),'Server Error');
            return redirect()->back();
        }
    }
}
