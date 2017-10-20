<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use App\Models\Resource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends WebController
{

    /**
     * Display all resources
     * @return $this
     */
    public function index()
    {
        $data['categories'] = Category::orderBy('id','desc')->get();
        return view('public.resource_list')->with($data);
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


   public function showCreate(){
       $data['categories'] = Category::orderBy('id','desc')->get();
       $data['tags'] = Tag::orderBy('id','desc')->get();
       return view('public.resource_create')->with($data);
   }



}
