<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form_data = $request->all();

        // Richiamo Funzione Validazione
        $request->validate($this->getValidationRules());

        $new_post = new Post();
        $new_post->fill($form_data);
        
        // Richiamo funzione per Slug univoco
        $new_post->slug = $this->getUniqueSlugFromTitle($form_data['title']);

        $new_post->save();

        return redirect()->route('admin.posts.show', ['post' => $new_post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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


    // Funzione Validazione
    protected function getValidationRules() {
        return [
            'title' => 'required|max:250',
            'content' => 'required|max:60000'
        ];
    }


    // Funzione per Slug univoco
    protected function getUniqueSlugFromTitle($title) {
        
        // Check se esiste già un post con questo slug
        $slug = Str::slug($title);
        $slug_base = $slug;
        
        $post_found = Post::where('slug', '=', $slug)->first();
        $counter = 1;
        while($post_found) {

            // Se esiste, si aggiunge 1 allo slug
            // e così via se esiste già 1 provo con 2
            $slug = $slug_base . '-' . $counter;
            $post_found = Post::where('slug', '=', $slug)->first();
            $counter++;
        }

        return $slug;
    }
}
