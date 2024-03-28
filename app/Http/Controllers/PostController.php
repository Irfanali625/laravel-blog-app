<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResouce;
use App\Http\Resources\TagResource;
use App\Mail\PostCreatedMail;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Post::with('user', 'tags');

        if ($user && $user->is_admin) {
            $posts = $query->get();
        } else {
            $posts = $query->where('user_id', $user->id)->get();
        }
        $categories = Category::all();
        $tags = Tag::all();
        return Inertia::render('Home', [
            'categories' => CategoryResource::collection($categories),
            'tags' => TagResource::collection($tags),
            'posts' => PostResouce::collection($posts),
            'success' => session('success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $data = $request->validated();

        if ($request['image']) {
            $manger = new ImageManager(new Driver());
            $imageName = Str::random(20) . '.' . $request['image']->getClientOriginalExtension();
            $image = $manger->read($request['image']);
            $image = $image->resize(370, 246);

            $image->toJpeg(80)->save(public_path('uploads/' . $imageName));
            $imageUrl = 'uploads/' . $imageName;
        }


        $postData = [
            'user_id' => auth()->user()->id,
            'name' => $data['name'],
            'category_id' => $request['category'],
            'content' => $request['content'],
            'image' => $imageUrl ?? ''
        ];

        $post = Post::create($postData);

        foreach ($request['tags'] as $tag) {
            $postTags = [
                'post_id' => $post->id,
                'tag_id' => $tag
            ];
            PostTag::create($postTags);
        }

        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new PostCreatedMail($admin->name));
        }

        return back()->with('success', 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, $id)
    {
        $data = $request->validated();

        if ($request['image']) {
            $manger = new ImageManager(new Driver());
            $imageName = Str::random(20) . '.' . $request['image']->getClientOriginalExtension();
            $image = $manger->read($request['image']);
            $image = $image->resize(370, 246);

            $image->toJpeg(80)->save(public_path('uploads/' . $imageName));
            $imageUrl = 'uploads/' . $imageName;
        }


        $updateData = [
            'user_id' => auth()->user()->id,
            'name' => $data['name'],
            'category_id' => $request['category'],
            'content' => $request['content'],
            'image' => $imageUrl ?? ''
        ];
        $post = Post::find($id);
        $post->update($updateData);

        $postTags = PostTag::where('post_id', $id)->get();
        foreach ($postTags as $postTag) {
            $postTag->delete();
        }

        foreach ($request['tags'] as $tag) {
            $postTag = new PostTag([
                'post_id' => $post->id,
                'tag_id' => $tag
            ]);
            $postTag->save();
        }

        return back()->with('success', 'Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if ($post) {
            PostTag::where('post_id', $post->id)->delete();
            $post->delete();
        }

        return back()->with('success', 'Post deleted successfully');
    }
}
