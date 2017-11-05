<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Resource;
use App\Models\Like;
use App\Models\Collection;
use App\Models\Tag;

use Storage;
use DB;
use App\Service\CommonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Resource\ResourceCreateRequest;
use App\Http\Requests\Resource\ResourceDeleteRequest;
use App\Http\Requests\Resource\ResourceUploadRequest;
use App\Http\Requests\Resource\ResourceUpdateRequest;
use App\Http\Requests\Resource\ResourceAddToCollectionRequest;

class ResourceController extends Controller
{
    use CommonService;

    protected $auth;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth:api', ['except' => ['index', 'search', 'show', 'file']]);
        $this->middleware(function($request, $next){
            $this->auth = Auth::guard('api')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // Create Request to Handle this limit Type
        $limit = intval($request->limit);
        $limit = $limit > 0 && $limit < 20 ? $limit : 20;

        $user_id = ($this->auth)?$this->auth->id:null;
        $tag_id = ($request->has('tag_id'))?$request->tag_id:null;
        $tag_slug = ($request->has('tag_slug'))?$request->tag_slug:null;
        $category_id = ($request->has('category_id'))?$request->category_id:null;
        $search_text = ($request->has('search_text'))?$request->search_text:null;

        $resources = Resource::select('resources.*')->with(
            ['likesCount', 'category', 'user',
                'like' => function($q)use($user_id){
                    $q->where('user_id', $user_id);
                }
            ]);
        if(!empty($tag_id) || !empty($tag_slug)){
            $resources->join('resource_tag', 'resource_tag.resource_id', '=', 'resources.id')
                ->join('tags', 'tags.id', '=', 'resource_tag.tag_id')
                ->where(function($q)use($tag_id,$tag_slug){
                    $q->where('tags.id', $tag_id)->orWhere('tags.slug', $tag_slug);
                });
        }
        if(!empty($category_id)){
            $resources->where('resources.category_id', $category_id);
        }
        if(!empty($search_text)){
            $resources->where('resources.title', 'like', '%'.$search_text.'%');
        }
        $resources = $resources->orderBy('resources.created_at', 'desc')
            ->Paginate($limit);

        $resources->appends('tag_id', $tag_id);
        $resources->appends('tag_slug', $tag_slug);
        $resources->appends('category_id', $category_id);
        $resources->appends('search_text', $search_text);

        return $this->setResponse($resources,'success','OK','200','','');
    }

    /**
     * Home page resource search option
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // Create Request to Handle this limit Type
        $limit = intval($request->limit);
        $limit = $limit > 0 && $limit < 20 ? $limit : 20;

        $resources = Resource::with('likesCount', 'category', 'user')
            ->where('title','like','%'.$request->search.'%')
            ->orderBy('created_at', 'desc')
            ->Paginate($limit);
        return $this->setResponse($resources,'success','OK','200','','');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ResourceCreateRequest $request)
    {
        $resource = new Resource(['title' => $request->title, 'slug' => $this->toSlug($request->title) . '_' . uniqid(), 'review' => $request->review, 'category_id' => $request->category_id]);

        $this->auth->resources()->save($resource);
        return $this->setResponse([],'success','OK','200','Mensaje de éxito','Recurso creado con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($param)
    {
        $resource = Resource::with('tags', 'likesCount', 'user', 'category')->where('id', $param)->orWhere('slug', $param)->firstOrFail();
        return response()->json($resource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResourceDeleteRequest $request, $id)
    {
        $resource = Resource::find($id);

        if ($resource) {
            return response()->json($resource->delete(), 200);
        } else {
            return response()->json('Error', 500);
        }
    }

    public function update(ResourceUpdateRequest $request, $id)
    {
        $resource = Resource::find($id);
        $resource->title = $request->title;
        $resource->review = $request->review;
//        $resource->content = $request->content;
        $resource->category_id = $request->category_id;
        $resource->save();
        return response()->json($resource, 200);
    }

    public function upload(ResourceUploadRequest $request, $id)
    {
        $resource = Resource::find($id);
        $previous_attachment = $resource->attachment;

        $file = $request->file('resource');

        $extension = $file->guessExtension();
        $filename = $resource->slug . '_' . uniqid($id) . '.' . $extension;

        $path = storage_path('resources_files/');

        $file->move($path, $filename);

        if ($file) {
            $resource->attachment = $filename;
            $resource->save();

            if ($previous_attachment) {
                Storage::delete('resources_files/' . $previous_attachment);
            }

            return response()->json(['attachment' => $resource->attachment], 200);
        } else {
            return response()->json($file, 500);
        }
    }

    public function file($id, $docId)
    {
        $resource = Resource::where(['id' => $id, 'attachment' => $docId])->firstOrFail();
        $filePath = storage_path('resources_files/' . $resource->attachment);
        return response()->download($filePath);
    }

    public function like($id)
    {
        $resource = Resource::find($id);
        $like = $resource->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();

            return $this->setResponse('', 'unlike', 'OK', '200', '', '');

        } else {
            $new_like = new Like(['user_id' => Auth::id()]);
            $resource->likes()->save($new_like);

            return $this->setResponse('', 'like', 'OK', '200', '', '');
        }
    }

    public function addToCollection(ResourceAddToCollectionRequest $request, $id)
    {
        $resource = Resource::find($id);
        $collection = Collection::find($request->collection_id);

        $collection->resources()->save($resource);
        return response()->json('', 200);
    }

    /**
     * Snakecase a string
     * @param str $string
     * @return str snakecased string
     */
    private function toSlug($string)
    {
        return strtolower(preg_replace('/[\s-]/', '_', $string));
    }

}
