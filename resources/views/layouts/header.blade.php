<nav class="navbar navbar-expand-lg navbar-light main_header ">
    <a class="navbar-brand" href="{{ url('/home') }}">GESDOC</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Administracion de sistema
          </a>
          <div class="dropdown-menu staticPositionHeader" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ url('/roles') }}">Administración de Roles</a>
            <a class="dropdown-item" href="{{ url('/users') }}">Administración de Usuarios</a>
            <a class="dropdown-item" href="{{ url('/departments') }}">Administración de Departamentos</a>
            <a class="dropdown-item" href="{{ url('/flows') }}">Adminsitración de Flujos </a>
         </div>          
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Gestión de documentos
        </a>
        <div class="dropdown-menu staticPositionHeader" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ url('/documentFlow') }}"> Documentos asociados a mis flujos </a>
          <a class="dropdown-item" href="{{ url('/userDocFlow') }}">Documentos compartidos en flujo  </a>
          <a class="dropdown-item" href="{{ url('/home') }}">Documentos</a>  
        </div>          
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/record') }}">
        Historial
      </a>      
  </li>
        
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
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
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


 