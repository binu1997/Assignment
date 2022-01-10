<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Image;
use Illuminate\Support\Carbon;
class MainController extends Controller
{

    public function index(){

        $products = Product::latest()->get();;
        return view('welcome',compact('products'));
    }


    public function addproduct(Request $request){

        $validate = $request->validate([
            'product_image' => 'required',
            'product_price' => 'required',
            'product_name' => 'required',
            'product_description' => 'required',
        ],
        [
            'product_name.required' => 'Please name',
            'product_price.required' => 'Please input price',
            'product_image.required' => 'Please input image',
            'product_description.required' => 'Please input description',

        ]);

        $product_image = $request->file('product_image');
        $up_location = 'images/ProductImages/';
        $name_gen = hexdec(uniqid()).'.'.$product_image->getClientOriginalExtension();
        Image::make($product_image)->resize(286,180)->save($up_location.$name_gen);
        $last_img = $up_location.$name_gen;


        $query = Product::insert([
            'product_image' => $last_img,
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'product_price'=> $request->product_price,
            'created_at' => Carbon::now()

        ]);

        if($query > 0 ){
            $notification = array(
                'message' =>'Product inserted successfully.',
                'alert-type' =>'success'
            );

            //return Redirect()->route('admin/portfolio/post/viewall')->with($notification);
            return Redirect()->back()->with($notification);
        }else{
            $notification = array(
                'message' =>'Error while adding Product',
                'alert-type' =>'error'
            );

            return Redirect()->back()->with($notification);
        }

    }

    public function updatestatus($status,$id){

        $updatestatus = Product::find($id)->update([
            'product_status' => $status,
            'updated_at' => Carbon::now()
        ]);
        if($updatestatus > 0){
            $notification = array(
                'message' =>'Product Updated successfully.',
                'alert-type' =>'success'
            );

            return Redirect()->back()->with($notification);
        }else{
            $notification = array(
                'message' =>'Error while updating product',
                'alert-type' =>'error'
            );

            return Redirect()->back()->with($notification);
        }

    }

    public function deleteproduct($id){
        $delete = Product::find($id)->delete();

        if($delete > 0){
            $notification = array(
                'message' =>'Product deleted successfully.',
                'alert-type' =>'success'
            );

            return Redirect()->back()->with($notification);
        }else{
            $notification = array(
                'message' =>'Error while deleting product',
                'alert-type' =>'error'
            );

            return Redirect()->back()->with($notification);
        }

    }

}
