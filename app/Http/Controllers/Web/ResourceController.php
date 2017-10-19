<?php

namespace App\Http\Controllers\Web;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends WebController
{

    public function index()
    {
        return view('public.resource_list');
    }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function show($param)
   {
       $data['resource_header'] = true;
       $user_id = ($this->auth)?$this->auth->id:null;
       $data['resource'] = Resource::with(['tags', 'likesCount', 'user', 'category', 'category.resources' => function($q){
                $q->limit(4);
            }, 'like' => function($q)use($user_id){
                $q->where('user_id', $user_id);
            }])
            ->where('id', $param)
            ->orWhere('slug', $param)
            ->firstOrFail();

       $data['latestResources'] = Resource::with('category')->orderBy('id', 'desc')->limit(5)->get();

       return view('public.resource')->with($data);
   }
}
