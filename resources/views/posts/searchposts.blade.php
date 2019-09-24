@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
       @if(count($errors)>0)
       @foreach($errors->all() as $error)
       <div class="alert alert-danger">{{$error}}</div>
       @endforeach
       @endif
       @if (session('response'))
       <div class="alert alert-success" role="alert">
        {{ session('response') }}
      </div>
      @endif
      <div class="card-header header">
        <div class="row">
         <div class="col-md-3">Dashbord</div>
         <div class="col-md-8">
          <form  method="POST"  action='{{ url("/search1") }}'>
            @csrf
             <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                <button type="submit" class="btn btn-default btn-new">Go!</button>
              </span>
            </div><!-- /input-group -->

          </form>
        </div>

      </div>

    </div>

    <div class="card-body">
      @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
      @endif
      <div class="panel-body">
        <div class="row">
         <div class="col-md-3" style="border-right: 1px solid #e5e5e5;" align="center">
          @if(!empty($profile))
          <img src="{{ $profile->profile_pic}}" class="avatar" />
          <h3 class="lead" >{{$profile->name}}</h3>
          <h4 class="lead">{{$profile->designation}}</h4>                      
          @else
          <img src="{{url('uploads/download.png')}}" class="avatar"/>
          @endif

        </div>  
        <div class="col-md-9" align="center">
         @if(!empty($posts))
         @foreach($posts->all() as $post) 
        <div class="card card-body bg-light">
         <h4>{{$post->post_title}}</h4>
         <img src="{{ $post->post_image}}" class="img-fluid alignright" />
         <p>{{substr($post->post_body,0,150)}}</p>
         <!--<h4>{{$post->category_id}}</h4>-->
         <ul class="nav">
           <li class="nav-item">
             <a href='{{url("/view/{$post->id}")}}' class="nav-link">
               <span class="fa fa-eye" aria-hidden="true">Viwe</span>
             </a>
           </li>
           <li class="nav-item">
             <a href='{{url("/edit/{$post->id}")}}' class="nav-link">
               <span class="fa fa-pencil-square-o" aria-hidden="true">Edit</span>
             </a>
           </li>
           <li class="nav-item">
             <a href='{{url("/delete/{$post->id}")}}' class="nav-link">
               <span class="fa fa-trash-o" aria-hidden="true">Delete</span>
             </a>
           </li>

         </ul>
         <cite  >Posted on: {{date('M j, Y H:i', strtotime($post->updated_at))}}</cite>
       </div>
         <hr/>

         @endforeach   
         @else
         <p>No Post Available!</p>
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
