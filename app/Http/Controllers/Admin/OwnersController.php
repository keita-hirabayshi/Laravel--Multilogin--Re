<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Models\Owner; //Eloquent エロクアント
use App\Models\Shop; //Eloquent エロクアント
use Illuminate\Support\Facades\DB; //クエリービルダ
use Carbon\Carbon;
use Throwable;
use Illuminate\Support\Facades\Log;

class OwnersController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:admin');

    }

    public function index()
    {
    // Carbonの使用
        // $date_now = Carbon::now();
        // $date_parse = Carbon::parse(now());
        // echo $date_now->year;
        // echo $date_parse;

        $e_all = Owner::all();
    // クエリービルダー
        // $q_get = DB::table('owners')->select('name','created_at')->get();
        // $q_first = DB::table('owners')->select('name')->first();
    // コレクション
        // $c_test = collect([
        //     'name' => 'てすと'
        // ]);
        
        // dd($e_all,$q_get,$q_first,$c_test);

    //ページネート 
        $owners = Owner::select('id','name','email','created_at')->paginate(3);
        return view ('admin.owners.index',compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.owners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255','unique:owners'],
            'email' => ['required', 'string', 'email', 'max:255','unique:owners'],
            'password' => ['required', 'confirmed','min:8']
            // 'password' => ['required', 'confirmed',Rules\Password::defaults()]
        ]);


        try{
        // ShopとOwner情報の登録
            DB::transaction(function()use($request){
                $owner = Owner::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

            Shop::create([
                'owner_id' => $owner->id,
                'name'     => '店名を入力してください',
                'information' => '',
                'filename' => '',
                'is_selling' => true,
            ]);
            }, 2);

        }catch(Throwable $e){
        // Logとthrowを使用するために、 use文にて記載を行う
        // また、errorが発生しような箇所では Logを登録しトレースできるようにしておく
            Log::error($e);
            throw $e;
        }


        return redirect()
        ->route('admin.owners.index')
        ->with(['message' => 'オーナー登録を実施しました。',
        'status' => 'info']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255','unique:owners'],
            'password' => ['required', 'confirmed']
        ]);
        
            echo $request->name;
        // Owner::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        // return redirect()->route('admin.owners.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $owner = Owner::findOrFail($id);
        // dd($owner);
        return view('admin.owners.edit', compact('owner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $owner = Owner::findOrFail($id);
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);

        $owner->save();

        return redirect()
        ->route('admin.owners.index')
        ->with(['message' => 'オーナー情報を更新しました。',
        'status' => 'info']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    // ソフトデリート
        Owner::findOrFail($id)->delete();
        return redirect()
        ->route('admin.owners.index')
        ->with(['message' => 'オーナー情報を削除しました。',
        'status' => 'alert']);
    }

    public function expiredOwnerIndex(){
        $expiredOwners = Owner::onlyTrashed()->get();
        return view('admin.expired-owners',compact('expiredOwners'));
    }

    public function expiredOwnerDestroy($id){
        Owner::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.expired-owners.index');
    }

}
