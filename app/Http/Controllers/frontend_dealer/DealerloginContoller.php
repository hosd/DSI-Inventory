<?php

namespace App\Http\Controllers\frontend_dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Hash;
use App\Models\ProductCategory;
use App\Models\Productmodel;
use App\Models\Dealer_stock;
use App\Models\User;
use App\Models\Dealeruser;
use App\Models\Dealers;

use Illuminate\Validation\Rule;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DealerloginContoller extends Controller
{
    function __construct()
    {

        $this->middleware('permission:dealer-profile', ['only' => ['index']]);
        //$this->middleware('permission:stock-create', ['only' => [ 'store']]);
//        $this->middleware('permission:category-edit', ['only' => ['edit', 'update','activation']]);
//        $this->middleware('permission:category-list', ['only' => ['datalist']]);
//        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['datalist']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $savestatus= 'A';
        $title = 'New';
        
        return view('frontend_dealer.profile')->with('savestatus',$savestatus)->with('title',$title);
    }
    
    public function stock_list(Request $request)
    {
        $savestatus= 'A';
        $category = ProductCategory::select('*')->where('status','Y')->where('is_delete',  0)->orderBy('name','ASC')->get();
        $product = Productmodel::select('*')->orderBy('name','ASC')->get();
//         $count = Productmodel::select('*')->get();
        if ($request->ajax()) {
            
            $data = Dealer_stock::join('product_category', 'dealer_stock.categoryID', '=', 'product_category.id')
                    ->join('product', 'dealer_stock.productcode', '=', 'product.id')                    
                    ->select('dealer_stock.*','product_category.name AS category','product.productcode as procode', 'product.id as proid')
                    ->where('dealer_stock.dealerID',auth()->user()->dealerID )
                    ->orderBy('product.productcode','ASC')
                    ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                if($row->status == 1){
                $btn = 'Active';}
                else{  $btn = 'Inactive';}
                 return $btn;
            })  
                    ->addColumn('edit', function ($row) {
                   
                   // $btn = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editData"><i class="fa fa-edit"></i></button>';
                    $btn = '<button type="button" class="btn btn-primary btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editData" data-category-id="'.$row->categoryID.'" data-quantity="'.$row->quantity.'" data-product-code="'.$row->proid.'" data-reorder-quantity="'.$row->reorder_quantity.'" data-reorder-id="'.$row->id.'"><i class="fa fa-edit"></i></button>';
                    return $btn;
                }) 
                
                    ->addColumn('item', function ($row) {

                    // $btn = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editData"><i class="fa fa-edit"></i></button>';
                    $btn = '<button type="button" class="btn btn-primary btn-sm item-btn" data-bs-toggle="modal" data-bs-target="#edititem" data-category-id="'.$row->categoryID.'" data-quantity="'.$row->quantity.'" data-product-code="'.$row->proid.'" data-reorder-quantity="'.$row->reorder_quantity.'" data-reorder-id="'.$row->id.'"><i class="fa fa-edit"></i></button>';
                    return $btn;
                }) 
                ->addColumn('size', function ($row) {

                   $btn = $row->width.' / '.$row->profile.' x '.$row->rim;
                    return $btn;
                })
                
                ->addColumn('activation', function($row){
                    if ( $row->status == "1" )
                        $status ='fa fa-check';
                    else
                        $status ='fa fa-remove';

                    $status_url = route('status-dealer-stock',encrypt($row->id));
                    $btn = '<a href="'.$status_url.'"><i class="'.$status.'"></i></a>';

                    return $btn;
                })
                   
                
                //->addColumn('edit', 'product.actionsEdit')
                //->addColumn('activation', 'product.actionsStatus')
                ->rawColumns(['edit', 'activation','users','item'])
                ->make(true);
        }

        return view('frontend_dealer.stock_list')->with('category',$category)->with('savestatus',$savestatus)->with('product',$product);
    }

     
     public function get_product_codes(Request $request)
    {
        $catID =  $request->cateID;
        $dealerID=auth()->user()->dealerID;
        $products['data'] = Productmodel::select('*')
                ->where("product_category", $catID)
                ->where('status', 1)
                ->whereNotIn('id', function ($query)use ($dealerID) {
                    $query->select('productcode')
                    ->from('dealer_stock')
                    ->where('dealerID', $dealerID);
                })
                ->orderBy('productcode', 'ASC')
                ->get();
        return response()->json($products);
    }
    
    
     public function store(Request $request)
    {
         //var_dump($request->productcode); die();
       if ($request->savestatus == 'A') {
            $request->validate([
                'categoryID' => 'required',
                'productcode' => 'required',
                'quantity' => 'required|max_digits:5|numeric',
                'reorder_quantity' => 'required|max_digits:5|numeric',
            ]);
            
            $data_arry = array();       
        $data_arry['categoryID'] = $request->categoryID;
        $data_arry['productcode'] = $request->productcode;
        $data_arry['quantity'] = $request->quantity;
        $data_arry['reorder_quantity'] = $request->reorder_quantity;
        $data_arry['dealerID'] = $request->dealerID;
        $data_arry['userID'] = auth()->user()->id;
        $data_arry['status'] = 1;
        
        } elseif($request->savestatus == 'E') {
            $request->validate([
                
                'quantityedit' => 'required|max_digits:5|numeric',
                'reorder_quantity_edit' => 'required|max_digits:5|numeric',
            ]);
            
        $data_arry = array();       
        $data_arry['quantity'] = $request->quantityedit;
        $data_arry['reorder_quantity'] = $request->reorder_quantity_edit;
       // $data_arry['dealerID'] = $request->dealerID;
        //$data_arry['userID'] = auth()->user()->id;    
        }else{
            $request->validate([
                'categoryIDitem' => 'required',
                'productcode_item' => 'required',
            ]);
            
            $data_arry = array();       
        
        $data_arry['categoryID'] = $request->categoryIDitem;
        $data_arry['productcode'] = $request->productcode_item;
        }
       
        if($request->savestatus == 'A'){
            
            $id= Dealer_stock::create($data_arry);
              
             \LogActivity::addToLog('New dealerstock product: '.$request->productcode.' added.dealer :'.$request->dealerID.'id :'.$id->id.'.');
            return redirect('stock-list')->with('success', 'New stock created successfully');
            
        }elseif($request->savestatus == 'E') {
            
            $recid = $request->recIDstock;
            
            Dealer_stock::where('id', $recid)->update($data_arry);
            
            \LogActivity::addToLog('dealerstock updated record '.$recid.' qu/requ '. $request->quantityedit.'/'.$request->reorder_quantity_edit);
            return redirect('stock-list')->with('success', 'stock updated successfully');
        }else{
            $recid = $request->recIDitem;
            
            Dealer_stock::where('id', $recid)->update($data_arry);
            
            \LogActivity::addToLog('dealerstockitem updated record '.$recid.' cat/itemcode '. $request->categoryIDitem.'/'.$request->productcode_item);
            return redirect('stock-list')->with('success', 'stock updated successfully');
        }
    }
    
    
    public function activation(Request $request)
    {
        $idD = decrypt($request->id);

        $data =  Dealer_stock::find($idD);

        if ( $data->status == "1" ) {

            $data->status = '0';
            $data->save();
            $id = $data->id;

            \LogActivity::addToLog('delaer stock deactivated('.$id.')');

            return redirect()->route('stock-list')
            ->with('success', 'Record deactivate successfully.');

        } else {

            $data->status = "1";
            $data->save();
            $id = $data->id;

            \LogActivity::addToLog('delaer stock activated('.$id.')');

            return redirect()->route('stock-list')
            ->with('success', 'Record activate successfully.');
        }

    }
    
    
        public function user_list(Request $request)
    {
        $savestatus= 'A';
        $category = ProductCategory::select('*')->where('status','Y')->where('is_delete',  0)->orderBy('name','ASC')->get();
        $product = Productmodel::select('*')->orderBy('name','ASC')->get();
//         $count = Productmodel::select('*')->get();
        if ($request->ajax()) {
            
            $data = User::join('roles', 'users.roleID', '=', 'roles.id')                  
                    ->select('users.*','roles.name AS role')
                    ->where('users.dealerID',auth()->user()->dealerID )
                    ->where('is_delete',  0)
                    ->orderBy('users.name','ASC')
                    ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                if($row->status == 'Y'){
                $btn = 'Active';}
                else{  $btn = 'Inactive';}
                 return $btn;
            })  
                    ->addColumn('edit', function ($row) {
                   
                   $edit_url = route('dealer-user-edit',encrypt($row->id));
                    $btn = '<a  class="btn btn-primary btn-sm" href="' . $edit_url . '"><i class="fa fa-edit"></i></a>';
//                    $btn = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editData"><i class="fa fa-edit"></i></button>';
                    return $btn;
                }) 
 
                
                
                ->addColumn('activation', function($row){
                    if ( $row->status == "Y" )
                        $status ='fa fa-check';
                    else
                        $status ='fa fa-remove';

                    $status_url = route('dealer-user-status',encrypt($row->id));
                    $btn = '<a href="'.$status_url.'"><i class="'.$status.'"></i></a>';

                    return $btn;
                })
                   
                
                //->addColumn('edit', 'product.actionsEdit')
                //->addColumn('activation', 'product.actionsStatus')
                ->rawColumns(['edit', 'activation','users'])
                ->make(true);
        }

        return view('frontend_dealer.user_list')->with('category',$category)->with('savestatus',$savestatus)->with('product',$product);
    }
    
        public function dealer_user_status(Request $request)
    {
        $idD = decrypt($request->id);

        $data =  User::find($idD);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            \LogActivity::addToLog('delaer user deactivated('.$id.')');

            return redirect()->route('user-list')
            ->with('success', 'Record deactivate successfully.');

        } else {

            $data->status = "Y";
            $data->save();
            $id = $data->id;

            \LogActivity::addToLog('delaer user activated('.$id.')');

            return redirect()->route('user-list')
            ->with('success', 'Record activate successfully.');
        }

    }
    
    public function edit_dealeruser($id)
    {
        $ID = decrypt($id);
        $Userinfo = User::where('id', '=', $ID)->get();
        //var_dump($Userinfo[0]->dealerID);die();
        $Dealer_ID = encrypt($Userinfo[0]->dealerID);
        $info = Dealers::where('id', '=',$Userinfo[0]->dealerID )->get();
        
        
        $savestatus = 'E';
        return view('frontend_dealer.user_edit')->with('Userinfo',$Userinfo)->with('savestatus',$savestatus)->with('info',$info)->with('Dealer_ID',$Dealer_ID);
        //return view('masterdata.complain_category.edit', ['data' => $data]);
        //return view('masterdata.complain_category.edit');
    }
    
    public function save_dealeruser_edit(Request $request)
    {
        $dealerID = $request->dealerID;
        $data_arry = array();
        if ($request->savestatus == 'A') {
            $request->validate([
                'name' => 'required|max:50',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirmpassword',
                'phone' => 'required|max:20|min:10',
            ]);
            
            
            $data_arry['name'] = $request->name;
            $data_arry['email'] = $request->email;
            $data_arry['mobile_no'] = $request->phone;
            $data_arry['dealerID'] = decrypt($request->dealerID);
            $data_arry['roleID'] = 3;
            $data_arry['password'] = Hash::make($request->password);
            $data_arry['status'] = "Y";
            
        } else {
            $id = decrypt($request->id);
            if ($request->password) {
                $request->validate([
                    'name' => 'required|max:50',
                    'email' => 'required|email|unique:users,email,' . $id,
                    'password' => 'same:confirmpassword',
                    'phone' => 'required|max:20|min:10'
                    //'status' => 'required'
                ]);
                
                $data_arry['name'] = $request->name;
                $data_arry['email'] = $request->email;
                $data_arry['mobile_no'] = $request->phone;
                $data_arry['dealerID'] = decrypt($request->dealerID);
                $data_arry['roleID'] = 3;
                $data_arry['password'] = Hash::make($request->password);
                //$data_arry['status'] = $request->status;
            } else {
                $request->validate([
                    'name' => 'required|max:50',
                    'email' => 'required|email|unique:users,email,' . $id,
                    //'password' => 'same:confirmpassword',
                    'phone' => 'required|max:20|min:10'
                   // 'status' => 'required'
                ]);
              
                $data_arry['name'] = $request->name;
                $data_arry['email'] = $request->email;
                $data_arry['mobile_no'] = $request->phone;
                $data_arry['dealerID'] = decrypt($request->dealerID);
                $data_arry['roleID'] = 3;
                //$data_arry['password'] = Hash::make($request->password);
                //$data_arry['status'] = $request->status;
                
            }
        }
        
        
        if($request->savestatus == 'A'){
            
           
            $id= User::create($data_arry);
             \LogActivity::addToLog('New dealerportal dealer user'.$request->name.' added('.$id->id.').');
            return redirect('user-list')->with('success', 'New dealer user created successfully');
        }else{
            
            $recid = $request->id;
           
            User::where('id', decrypt($recid))->update($data_arry);
            \LogActivity::addToLog('dealerportal dealer user edited ' . $request->name . ' updated(' . decrypt($recid) . ').');
            return redirect('/dealer-user-edit/'.$recid.'')->with('success', 'dealer user updated successfully');
        }
    }
    
    public function dealer_user_profile()
    {
                
               
        return view('frontend_dealer.profile');
        
    }
    
    public function save_user_profile(Request $request)
    {
                
       $data_arry = array();
        
            $id = decrypt($request->id);       
                $request->validate([
                    'name' => 'required|max:50',
                    'email' => 'required|email|unique:users,email,' . $id,
                    //'password' => 'same:confirmpassword',
                    'phone' => 'required|max:20|min:10'
                   // 'status' => 'required'
                ]);
              
                $data_arry['name'] = $request->name;
                $data_arry['email'] = $request->email;
                $data_arry['mobile_no'] = $request->phone;
                //$data_arry['dealerID'] = decrypt($request->dealerID);
                //$data_arry['roleID'] = 3;
            
            $recid = $request->id;
           
            User::where('id', decrypt($recid))->update($data_arry);
            \LogActivity::addToLog('profile updated ' . $request->name . ' updated(' . decrypt($recid) . ').');
            return redirect('dealer-user-profile')->with('success', 'Profile updated successfully');
        
        }
   

}
