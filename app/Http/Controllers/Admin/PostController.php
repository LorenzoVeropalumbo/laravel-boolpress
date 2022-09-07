<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Category;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $all_posts = Post::All();
        $request_info = $request->all();

        $show_deleted_message = isset($request_info['deleted']) ? $request_info['deleted'] : null;

        $data = [
          'posts' => $all_posts,
          'deleted' => $show_deleted_message
        ];
        
        return view('admin.post.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Prima di tutto valido i dati
        $request->validate($this->getValidationRules()); 

        $form_data = $request->all();
        $new_post = new Post(); 
        $new_post->fill($form_data);      
        $new_post->slug = $this->getFreeSlug($new_post->title);
        $new_post->save();
        return redirect()->route('admin.post.show', ['post' => $new_post->id]);
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
        $diff = $post->created_at->diffInHours($now);
        $data = [
            'post' =>  $post,
            'updated' => $diff,
        ];

        return view('admin.post.show', $data);
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

        $data = [
            'post' =>  $post
        ];

        return view('admin.post.edit', $data);
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
        $request->validate($this->getValidationRules()); 
        $form_data = $request->all();
        $old_post = Post::findOrFail($id);

        if($form_data['title'] !== $old_post->title){
            $form_data['slug'] = $this->getFreeSlug($form_data['title']);
        }else{
            $form_data['slug'] = $old_post->slug;
        }

        $old_post->update($form_data);

        return redirect()->route('admin.post.show', ['post' => $old_post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post_to_delete = Post::findOrFail($id);
        $post_to_delete->delete();

        return redirect()->route('admin.post.index',['deleted' => 'yes']);
    }

    protected function getFreeSlug($title){
        // Prendo la variale title la faccio diventare uno slug e la salvo
        $slug_to_save = Str::slug($title, '-');
        // Mi salvo anche una versione base
        $slug_base = $slug_to_save;

        // Controllo se ne esiste già uno nel mio database
        $existing_slug_post = Post::where('slug', '=' , $slug_to_save)->first();

        // Creo un counter da aggiungere a fine slug per renderlo univoco
        $counter = 1;
        while($existing_slug_post){
            // Creo lo slug con il numero univoco
            $slug_to_save = $slug_base . '-' . $counter;
            //Ricontrollo se già esiste
            $existing_slug_post = Post::where('slug', '=' ,$slug_to_save)->first();
            // Aumento il counter
            $counter++;
        }
        // Ritorno lo slug
        return $slug_to_save;
    }
    protected function getValidationRules() {
        // Creo le Validazioni per i campi nel form
        return [
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:10|max:60000',
        ];
    }
}
