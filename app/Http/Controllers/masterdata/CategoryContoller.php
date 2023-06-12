<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Hash;
use App\Models\ProductCategory;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CategoryContoller extends Controller
{
    function __construct()
    {

        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['datalist']]);
        $this->middleware('permission:category-create', ['only' => ['index', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update','activation']]);
        $this->middleware('permission:category-list', ['only' => ['datalist']]);
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['datalist']]);
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
        
        return view('adminpanel.category.index')->with('savestatus',$savestatus)->with('title',$title);
        //return view('frontend_dealer.stock_list')->with('savestatus',$savestatus)->with('title',$title);
    }

     public function datalist(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductCategory::select('*')
                    ->where('is_delete',  0)
                    ->orderBy('name','ASC')
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

                   $edit_url = route('edit-category',encrypt($row->id));
                    $btn = '<a href="' . $edit_url . '"><i class="fa fa-edit"></i></a>';
                    return $btn;
                }) 
                
                ->addColumn('activation', function($row){
                    if ( $row->status == "Y" )
                        $status ='fa fa-check';
                    else
                        $status ='fa fa-remove';

                    $status_url = route('status-category',encrypt($row->id));
                    $btn = '<a href="'.$status_url.'"><i class="'.$status.'"></i></a>';

                    return $btn;
                })
             
                
                //->addColumn('edit', 'dealers.actionsEdit')
                //->addColumn('activation', 'dealers.actionsStatus')
                ->rawColumns(['edit', 'activation'])
                ->make(true);
        }

        return view('adminpanel.category.list');
    }

    /**
     * Store a newly created resource in storage.
     * update existing resources 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->savestatus == 'A') {
            $request->validate([
                'name' => 'required|max:50',                
                'status' => 'required',
                
            ]);
        } else {
            $request->validate([
                'name' => 'required|max:50',
                'status' => 'required',
                
            ]);
        }
        
        $data_arry = array();
        $data_arry['name'] = $request->name;
        $data_arry['status'] = $request->status; 
        
              
        if($request->savestatus == 'A'){
                       
            $id= ProductCategory::create($data_arry);
             \LogActivity::addToLog('New category'.$request->name.' added('.$id->id.').');
            return redirect('new-category')->with('success', 'New category created successfully');
        }else{
            
            $recid = $request->id;
            
            ProductCategory::where('id', decrypt($recid))->update($data_arry);
            \LogActivity::addToLog('category ' . $request->name . ' updated(' . decrypt($recid) . ').');
            return redirect('/edit-category/'.$recid.'')->with('success', 'category updated successfully');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ID = decrypt($id);
        $info = ProductCategory::where('id', '=', $ID)->get();
        $title = 'Edit';
        
        $savestatus = 'E';
        return view('adminpanel.category.index')->with('info',$info)->with('savestatus',$savestatus)->with('title',$title);
        //return view('masterdata.complain_category.edit', ['data' => $data]);
        //return view('masterdata.complain_category.edit');
    }
    
    
    public function activation(Request $request)
    {
        $idD = decrypt($request->id);

        $data =  ProductCategory::find($idD);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            \LogActivity::addToLog('category record '.$data->province_name_en.' deactivated('.$id.')');

            return redirect()->route('category-list')
            ->with('success', 'Record deactivate successfully.');

        } else {

            $data->status = "Y";
            $data->save();
            $id = $data->id;

            \LogActivity::addToLog('category record '.$data->province_name_en.' activated('.$id.')');

            return redirect()->route('category-list')
            ->with('success', 'Record activate successfully.');
        }

    }
    
     public function get_state_cities(Request $request)
    {
        $districtID =  $request->districtID;
        $city['data'] = City::select('*')->where("district_id", $districtID)->orderBy('city_name_en','ASC')->get();
        return response()->json($city);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    

}
