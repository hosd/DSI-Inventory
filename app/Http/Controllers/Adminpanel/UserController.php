<?php

namespace App\Http\Controllers\Adminpanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use DataTables;
use App\Models\LabourOfficeDivision;
use App\Models\SmsTemplate;
use App\Library\MobitelSms;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = User::orderBy('id', 'DESC')->paginate(5);
        // return view('adminpanel.users.index', compact('data'))
        //     ->with('i', ($request->input('page', 1) - 1) * 5);

        //$roles = Role::pluck('name', 'name')->all();
        $roles = Role::select('*')->where('status','Y')->get();
        
        return view('adminpanel.users.index', compact('roles'));
    }


    public function list(Request $request)
    {
        //echo "aaa";
        if ($request->ajax()) {
//            $data = User::select(array('users.id','users.name','users.email','users.status'))
//                        ->where('users.is_delete', '0')->where('users.roleID','!=', '2')->orderBy('users.id', 'ASC');
            $data = User::join('roles', 'users.roleID', '=', 'roles.id')
                    ->select(array('users.*', 'roles.name as role'))
                    ->where('users.is_delete', '0')
                    ->where('users.roleID', '1')
                    ->orderBy('users.id', 'ASC');
            //var_dump($data); exit();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('edit', function ($row) {

                   $edit_url = route('users.edit',encrypt($row->id));
                    $btn = '<a href="' . $edit_url . '"><i class="fa fa-edit"></i></a>';
                    return $btn;
                })
//                ->addColumn('role', function ($row) {
//                    $v = "";
//                    if(!empty($row->getRoleNames())){
//                        foreach($row->getRoleNames() as $v){
//                            $v;
//                        }
//                    }
//                     return $v;
//                 })
                ->addColumn('activation', function($row){
                    if ( $row->status == "Y" )
                        $status ='fa fa-check';
                    else
                        $status ='fa fa-remove';


                    $btn = '<a href="changestatus-user/'.$row->id.'/'.$row->cEnable.'"><i class="'.$status.'"></i></a>';

                    return $btn;
                })
                // ->addColumn('blockuser', function($row){
                //     if ( $row->status == "1" )
                //         $dltstatus ='fa fa-ban';
                //     else
                //         $dltstatus ='fa fa-trash';
                //     $btn = '<a href="blockuser/'.$row->id.'/'.$row->cEnable.'"><i class="'.$dltstatus.'"></i></a>';
                //     return $btn;
                // })
                ->addColumn('blockuser', 'adminpanel.users.actionsBlock')                
                ->rawColumns(['edit','role','activation','blockuser'])
                ->make(true);
        }

       return view('adminpanel.users.list');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->where('status','Y')->all();
        return view('adminpanel.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
    $roleName = $request->roles;
    $role=  Role::select('id')->where('name',$request->roles)->get();
   
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirmpassword',
            'roles' => 'required',
        ]);

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);
        $input['roleID'] =$role[0]->id;

//        if($request->mobile_no != ''){
//            $password = $request->confirmpassword;
//
//            $smsitem = SmsTemplate::where('status', 'Y')
//                ->where('is_delete', 0)
//                ->where('id', 6)
//                ->first();
//
//                if($request->lang == "SI")
//                {
//                    $variables = ['[USER]','[EMAIL]','[PASSWORD]'];
//
//                    $variableData = [$request->name_si,$request->email,$request->password];
//
//                    $sms_body = str_ireplace($variables, $variableData, $smsitem->body_content_sin);
//                }
//                else if($request->lang == "TA")
//                {
//                    $variables = ['[USER]','[EMAIL]','[PASSWORD]'];
//
//                    $variableData = [$request->name_ta,$request->email,$request->password];
//
//                    $sms_body = str_ireplace($variables, $variableData, $smsitem->body_content_tam);
//                }
//                else
//                {
//                    $variables = ['[USER]','[EMAIL]','[PASSWORD]'];
//
//                    $variableData = [$request->name,$request->email,$request->password];
//
//                    $sms_body = str_ireplace($variables, $variableData, $smsitem->body_content_en);
//                }
//
//                $mobitelSms = new MobitelSms();
//                $session = $mobitelSms->createSession('','esmsusr_uqt','2L@boUr$m$','');
//                $mobitelSms->sendMessagesMultiLang($session,'Labour Dept',$sms_body,array($request->mobile_no),0);
//                $mobitelSms->closeSession($session);
//
//                \SmsLog::addToLog($request->name, $request->mobile_no, $sms_body);
//        }

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        \LogActivity::addToLog('New user '.$request->name.' added('.$user->id.').');

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = User::find($id);
        return view('adminpanel.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $user = User::find($id);
        $roles = Role::select('*')->get();
        $userRole = $user->roles->pluck('name', 'name')->all();
        //var_dump($user); die();
        return view('adminpanel.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       $id = $request->id;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirmpassword',
            'roles' => 'required',
        ]);
        $roleName = $request->roles;
        $role=  Role::select('id')->where('name',$request->roles)->get();
        $input['roleID'] =$role[0]->id;

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));



        \LogActivity::addToLog('User record '.$request->name.' updated('.$id.').');

        return redirect()->route('users-list')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function activation(Request $request)
    {
        $request->validate([
            // 'status' => 'required'
        ]);

        $data =  User::find($request->id);

        if ( $data->status == "Y" ) {

            $data->status = 'N';
            $data->save();
            $id = $data->id;

            \LogActivity::addToLog('User record '.$data->name.' deactivated('.$id.').');

            return redirect()->route('users-list')
            ->with('success', 'Record deactivate successfully.');

        } else {

            $data->status = "Y";
            $data->save();
            $id = $data->id;

            \LogActivity::addToLog('User record '.$data->name.' activated('.$id.').');

            return redirect()->route('users-list')
            ->with('success', 'Record activate successfully.');
        }

    }

    public function block(Request $request)
    {
        $request->validate([
            // 'status' => 'required'
        ]);

        $data =  User::find($request->id);
        $data->is_delete = 1;
        $data->save();
        $id = $data->id;

        \LogActivity::addToLog('User record '.$data->name.' deleted('.$id.').');

        return redirect()->route('users-list')
            ->with('success', 'Record deleted successfully.');
    }

    public function checkEmailAvailability(Request $request)
    {
        // echo $request->startTime;
        //   exit();
        // \DB::enableQueryLog();
        $users = User::where("email", $request->email)
                        ->get();
                        // $events = \DB::getQueryLog();
                        // print_r($events);
                        // exit();

        return response()->json($users);
    }
}
