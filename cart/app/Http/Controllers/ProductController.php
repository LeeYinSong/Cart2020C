<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product; 
use App\Models\Category;
Use Session;



class productController extends Controller
{
    //
    public function index()
    {
        return view('search');
    }
  
   
    public function autocomplete(Request $request)
    {
        $data = Product::select("name")
                ->where("name","LIKE", '%'.$request->get('query').'%')
                ->get();
        return response()->json($data);
    }
  

    public function create(){
        return view('insertProduct') ->with('categories',Category::all());;
    }


    public function store(){    //step 2 
        $r=request(); //step 3 get data from HTML
        $image=$r->file('product-image');   //step to upload image get the file input
        $image->move('images',$image->getClientOriginalName());   //images is the location                
        $imageName=$image->getClientOriginalName(); 

        $addCategory=Product::create([    //step 3 bind data
            'id'=>$r->ID, //add on 
            'name'=>$r->name, //fullname from HTML
            'description'=>$r->description,
            'categoryID'=>$r->category,
            'price'=>$r->price,
            'quantity'=>$r->quantity,
            'image'=>$imageName,
            
        ]);
        Session::flash('success',"Product create succesful!");

        return redirect()->route('showProduct');
    }

    public function show(){
        $products=Product::paginate(12);
        
        return view('showProduct')->with('products',$products);
    }

    public function showProducts(){
        $products=Product::paginate(12);
        
        return view('products')->with('products',$products);
    }

    public function edit($id){
       
        $products =Product::all()->where('id',$id);
        //select * from products where id='$id'
        
        return view('editproduct')->with('products',$products)
                                ->with('categories',Category::all());
    }

    public function delete($id){
        $products=Product::find($id);
        $products->delete();
        return redirect()->route('showProduct');
    }

    public function update(){
        $r=request();//retrive submited form data
        $products =Product::find($r->ID);  //get the record based on product ID      
        if($r->file('product-image')!=''){
            $image=$r->file('product-image');        
            $image->move('images',$image->getClientOriginalName());                   
            $imageName=$image->getClientOriginalName(); 
            $products->image=$imageName;
            }         
        $products->name=$r->name;
        $products->description=$r->description;
        $products->price=$r->price;
        $products->quantity=$r->quantity;
        $products->categoryID=$r->category;
        $products->save(); //run the SQL update statment
        return redirect()->route('showProduct');
    }

    public function search(){
        $r=request();//retrive submited form data
        $keyword=$r->searchProduct;
        $products =DB::table('products')
        ->leftjoin('categories', 'categories.id', '=', 'products.categoryID')
        ->select('categories.name as catname','categories.id as catid','products.*')
        ->where('products.name', 'like', '%' . $keyword . '%')
        ->orWhere('products.description', 'like', '%' . $keyword . '%')
        //->get();
        ->paginate(4); 
               // select * from products left join categories on 
        return view('showProduct')->with('products',$products);

    }

    public function showProductDetail($id){
       
        $products =Product::all()->where('id',$id);
        //select * from products where id='$id'
        
        return view('productdetail')->with('products',$products)
                                ->with('categories',Category::all());
    }

}