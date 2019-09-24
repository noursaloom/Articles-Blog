@extends('layouts.app')
<style type="text/css">
  .alignright{
    margin-bottom: 1em;
    width:300px;
    height:300px;
    border-radius: 8px;
  }
</style>
@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      
      <div class="card">
        <div class="card-header header">Post View</div>
        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <div class="panel-body">
            <div class="row">
             <div class="col-md-4" style="border-right: 1px solid #e5e5e5;">
               <ul class="list-group">
                <h3>Categories</h3>
                @if(count($categories) > 0)
                @foreach($categories->all() as $category)
                <li class="list-group-item">
                  <a href='{{url("category/$category->id")}}'>
                   {{$category->category}}
                 </a>
               </li>
               @endforeach
               @else
               <p>No Category Found!</p>

               @endif

             </ul>

           </div>  
           <div class="col-md-8" align="center">
             @if(!empty($posts))
             @foreach($posts->all() as $post) 
             <h4>{{$post->post_title}}</h4>
             <img src="{{ $post->post_image}}" class="alignright" />
             <p>{{$post->post_body}}</p>
             <!--<h4>{{$post->category_id}}</h4>-->
             <ul class="nav">
               <li class="nav-item">
                 <a href='{{url("/like/{$post->id}")}}' class="nav-link">
                   <span class="fa fa-thumbs-o-up" aria-hidden="true">Like({{$likeCtr}})</span>
                 </a>
               </li>
               <li class="nav-item">
                 <a href='{{url("/dislike/{$post->id}")}}' class="nav-link">
                   <span class="fa fa-thumbs-o-down" aria-hidden="true">Dislike({{$dislikeCtr}})</span>
                 </a>
               </li>
               <li class="nav-item">
                 <a href='' class="nav-link">
                   <span class="fa fa-commenting-o" aria-hidden="true">Comment</span>
                 </a>
               </li>
             </ul>
             @endforeach
             @else
             <p>No Post Available!</p>
             @endif
             <!--********Comment Form*******-->
              @if (session('response'))
                        <div class="alert alert-success" role="alert">
                            {{ session('response') }}
                        </div>
                    @endif
             <form method="POST" action='{{url("/comment/{$post->id}")}}' enctype= "multipart/form-data">
                        @csrf
              <div class="form-group">
               <textarea id="comment"  class="form-control @error('comment') is-invalid @enderror" rows="6" name="comment" required autofocus></textarea>
             </div>
              <div class="form-group">
             <button type="submit" class="btn btn-primary btn-block">Post Comment</button>
           </div>
           </form>
           <!--*******View Comments*******-->
           <hr>
           <h5 class="lead-comment">Comments</h5>
            @if(!empty($comments))
             @foreach($comments->all() as $comment) 
             
           <p class="comment">{{$comment->comment}} </p>
             @endforeach
             @else
             <p>No Comments Available!</p>
             @endif
         </div> 

       </div>
     </div>
   </div>
 </div> 
</div>
</div>
</div>
@endsection
