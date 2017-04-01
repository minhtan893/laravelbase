<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PostRepository;

class PostMiddleware
{
    protected $post;
    function __construct(){
        $this->post = new PostRepository;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $post = $this->post->findId((int)$request->id);
        if($post->user_id == Auth::user()->id){
            return $next($request);
        }
        else{
            abort(404);
        }
    }
}
