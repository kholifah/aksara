<div class="header">
   <div class="container">
      <div class="logo">
        <a href="{{ route('home') }}"><img src="{{ asset('img/logo.jpg') }}" title="" /></a>
      </div>
       <!---start-top-nav---->
       <div class="top-menu">
         <div class="search">
           {!! Form::open(['url' => 'home', 'method'=>'get']) !!}
               {!! Form::text('q', isset($q) ? $q : '', [ 'placeholder' => 'Search']) !!}
               {!! $errors->first('q', '<p class="help-block">:message</p>') !!}
             {!! Form::close() !!}
         </div>

          <span class="menu"> </span>
           <ul>
            <li class="active"><a href="{{ route('home') }}">HOME</a></li>
            <li><a href="{{ route('login') }}">LOGIN</a></li>
            <div class="clearfix"> </div>
         </ul>
       </div>
       <div class="clearfix"></div>
          <script>
          $("span.menu").click(function(){
          $(".top-menu ul").slideToggle("slow" , function(){
          });
          });
          </script>
        <!---//End-top-nav---->
   </div>
</div>
