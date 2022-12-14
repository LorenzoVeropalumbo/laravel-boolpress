<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewContactEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Tag;
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
        
        $all_posts = Post::paginate(6);
        $all_tags = Tag::All();
        $request_info = $request->all();

        $show_deleted_message = isset($request_info['deleted']) ? $request_info['deleted'] : null;

        $data = [
          'posts' => $all_posts,
          'deleted' => $show_deleted_message,
          'tags' => $all_tags
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
        $categories = Category::all();
        $all_tags = Tag::All();

        $data = [
            'categories' => $categories,
            'tags' => $all_tags
        ];

        return view('admin.post.create',$data);
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
        if (isset($form_data['image'])) {
           $img_path = Storage::put('post-covers', $form_data['image']);
           $form_data['cover'] = $img_path;
        }
        
        $new_post = new Post(); 
        $new_post->fill($form_data);      
        $new_post->slug = $this->getFreeSlug($new_post->title);
        $new_post->save();

        if (isset($form_data['tags'])) {
            $new_post->tags()->sync($form_data['tags']);
        } else {
            $new_post->tags()->sync([]);
        }

        Mail::to('admin@boolpress.it')->send(new NewContactEmail($new_post));

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
        if($post->updated_at->diffInHours($now) > 0){
            
            $diff = $post->updated_at->diffInHours($now);
            if($diff == 1){
               $type_of_difference = 'ora'; 
            } else {
                $type_of_difference = 'ore'; 
            }
            
        } else {
            
            $diff = $post->updated_at->diffInMinutes($now);
            
            if($diff == 1){
                $type_of_difference = 'minuto'; 
            } else {
                $type_of_difference = 'minuti'; 
            }
        }
        
        $data = [
            'post' =>  $post,
            'updated' => $diff,
            'time' => $type_of_difference,
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
        $categories = Category::all();
        $post = Post::findOrFail($id);
        $all_tags = Tag::All();

        $data = [
            'post' =>  $post,
            'categories' => $categories,
            'tags' => $all_tags
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
        if (isset($form_data['image'])) {
            if($old_post->cover){
              Storage::delete($old_post->cover);  
            }
            
            $img_path = Storage::put('post-covers', $form_data['image']);
            $form_data['cover'] = $img_path;
        }
        if($form_data['title'] !== $old_post->title){
            $form_data['slug'] = $this->getFreeSlug($form_data['title']);
        }else{
            $form_data['slug'] = $old_post->slug;
        }

        $old_post->update($form_data);

        if (isset($form_data['tags'])) {
            $old_post->tags()->sync($form_data['tags']);
        } else {
            $old_post->tags()->sync([]);
        }

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
        if($post_to_delete->cover){
            Storage::delete($post_to_delete->cover);  
        }
        $post_to_delete->tags()->sync([]);
        $post_to_delete->delete();

        return redirect()->route('admin.post.index',['deleted' => 'yes']);
    }

    protected function getFreeSlug($title){
        // Prendo la variale title la faccio diventare uno slug e la salvo
        $slug_to_save = Str::slug($title, '-');
        // Mi salvo anche una versione base
        $slug_base = $slug_to_save;

        // Controllo se ne esiste gi?? uno nel mio database
        $existing_slug_post = Post::where('slug', '=' , $slug_to_save)->first();

        // Creo un counter da aggiungere a fine slug per renderlo univoco
        $counter = 1;
        while($existing_slug_post){
            // Creo lo slug con il numero univoco
            $slug_to_save = $slug_base . '-' . $counter;
            //Ricontrollo se gi?? esiste
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
            'category_id' => 'nullable|exists:categories,id',
            'cover' => 'image|max: 1024|nullable'
        ];
    }
}
