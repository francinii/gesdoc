<nav class="navbar navbar-expand-lg navbar-light main_header staticPosition ">
    <a class="navbar-brand" href="{{ url('/home') }}">{{ __('app.header.home') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

       <?php
      //debug blade.php
      //    xdebug_break();
        $permissions = Auth::user()->role->permissions;
        $permissionsArray = $permissions->pluck('id')->toArray();
       ?>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">

      @if(in_array(1, $permissionsArray)   || in_array(2, $permissionsArray)  || in_array(3, $permissionsArray)  || in_array(4, $permissionsArray) )
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ __('app.header.adminSystem') }}
          </a>
          <div class="dropdown-menu staticPositionHeader" aria-labelledby="navbarDropdown">

        @if(in_array(1, $permissionsArray))
            <a class="dropdown-item" href="{{ url('/roles') }}">{{ __('app.header.adminRole') }}</a>
        @endif
        @if(in_array(2, $permissionsArray))
            <a class="dropdown-item" href="{{ url('/users') }}">{{ __('app.header.adminUser') }}</a>
        @endif
        @if(in_array(3, $permissionsArray))
            <a class="dropdown-item" href="{{ url('/departments') }}">{{ __('app.header.adminDepartements') }}</a>
        @endif
        @if(in_array(4, $permissionsArray))
            <a class="dropdown-item" href="{{ url('/flows') }}">{{ __('app.header.adminFlow') }} </a>
        @endif           
         </div>          
      </li>
      @endif
      @if(in_array(5, $permissionsArray) || in_array(6, $permissionsArray))
        <li class="nav-item dropdown">      
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ __('app.header.managerDocuments') }}
            </a>       
            <div class="dropdown-menu staticPositionHeader" aria-labelledby="navbarDropdown">
            @if(in_array(5, $permissionsArray))
            <a class="dropdown-item" href="{{ url('/documentFlow') }}">{{ __('app.header.documentsInMyFlow') }} </a>
            @endif 
            @if(in_array(6, $permissionsArray))
            <a class="dropdown-item" href="{{ url('/userDocFlow') }}">{{ __('app.header.documentsInShareFlow') }} </a>
            @endif                  
            </div>          
        </li>
      @endif 

    @if(in_array(7, $permissionsArray))  
    <li class="nav-item">    
        <a class="nav-link" href="{{ url('/record') }}"> Historial </a>           
    </li>
    @endif     
        
      </ul>

      <div class="form-inline my-2 my-lg-0">
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                
                <li class="nav-item dropdown" >
                   
                        <a  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ __('app.header.notification') }} <span id='notificationsNumber' class="badge badge-light"></span>
                        </a>
                        <div class=" dropdown-menu dropdown-menu-right" aria-labelledby="notifications">
                            <div class="card-header" id="notificationsButton">
                                <button id="deleteNotifications" class="btn btn-link dropdown-item" onclick="readNotification()"><i class="fas fa-trash-alt"></i> Limpiar notificaciones</button>
                            </div>
                            <div id="notifications" class="card-body"  style="height: auto;  max-height: 200px; overflow-x: hidden;">                     
                            </div>
                        </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('profile') }}">
                            {{ __('app.header.profile') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                            {{ __('app.header.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
    </div>
  </nav>


 