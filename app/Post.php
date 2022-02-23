<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'category_id'
    ];

    public function category() {
        return $this->belongsTo('App\Category');
    }

    // Funzione per Slug univoco
    public static function getUniqueSlugFromTitle($title) {
        
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
