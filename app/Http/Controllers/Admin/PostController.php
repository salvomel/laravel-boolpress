<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPostAdminNotification;
use Illuminate\Support\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // Paginate max post in index
        $posts = Post::paginate(6);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
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
        $new_post->slug = Post::getUniqueSlugFromTitle($form_data['title']);

        // Gestione immagine 
        if(isset($form_data['image'])) {
            // Metto immagine nella cartella di storage
            $img_path = Storage::put('post_covers', $form_data['image']);
            // Salvo il path al file nella colonna cover del post
            $new_post->cover = $img_path;
        }

        $new_post->save();

        // Per aggiungere ed eliminare dei record nella tabella pivot uso sync
        if(isset($form_data['tags'])) {
            $new_post->tags()->sync($form_data['tags']);
        }

        // Gestione email quando nuovo post è stato creato
        Mail::to('editor@boolpress.it')->send(new NewPostAdminNotification($new_post));

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

        $now = Carbon::now();

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
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
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
        $form_data = $request->all();

        // Richiamo Funzione Validazione
        $request->validate($this->getValidationRules());

        $post = Post::findOrFail($id);
        
        // Aggiorno lo Slug soltanto se si cambia il titolo
        if($form_data['title'] != $post->title) {
            // Richiamo funzione per Slug univoco
            $form_data['slug'] = Post::getUniqueSlugFromTitle($form_data['title']);
        }

        // Gestione immagine
        if($form_data['image']) {
            // Cancello vecchia immagine
            if($post->cover) {
                Storage::delete($post->cover);
            }

            // Upload nuova immagine
            $img_path = Storage::put('post_covers', $form_data['image']);

            // Salvo nella colonna cover il path al nuovo file
            $form_data['cover'] = $img_path;
        }
        
        $post->update($form_data);

        // Se non ci sono tags in form_data l'utente ha rimosso il check da tutti i tag quindi li rimuovo
        if(isset($form_data['tags'])) {
            $post->tags()->sync($form_data['tags']);
        } else {
            $post->tags()->sync([]);
        }

        return redirect()->route('admin.posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->tags()->sync([]);
        if($post->cover) {
            Storage::delete($post->cover);
        }
        $post->delete();

        return redirect()->route('admin.posts.index');
    }


    // Funzione Validazione
    protected function getValidationRules() {
        return [
            'title' => 'required|max:250',
            'content' => 'required|max:60000',
            'category_id' => 'exists:categories,id|nullable',
            'tags' => 'exists:tags,id',
            'image' => 'image|max:512'
        ];
    }
}
