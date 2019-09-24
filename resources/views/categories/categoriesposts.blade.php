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

                @if (session('response'))
                        <div class="alert alert-success" role="alert">
                            {{ session('response') }}
                        </div>
                    @endif
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
                               
                               @endforeach
                    @else
                  <p>No Post Available!</p>
                    @endif
                      {{$posts->links()}}
                   </div> 

                 </div>
                   </div>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
 