<div class="col-12 " style="text-align: center"></div>
<div class="col-12">
    
</div>

<div class="historial col-md-6">  
    <div class="card">
        <div class="card-header bg-danger ">
        <h5 class="card-title text-light">Documento</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-8">                
                    <div>
                        <span><b class="card-text ">Código</b></span>
                        <span class="card-text "></span>
                    </div>
                    <div>
                        <span><b class="card-text ">Propietario</b></span>
                        <span class="card-text "></span>
                    </div>
                    <div>
                        <span><b class="card-text ">Resumen</b></span>
                        <span class="card-text "></span>
                    </div>
                </div>
                <div class="col-4">
                    <div>
                        <span><b class="card-text ">Fecha de creación</b></span>
                        <span class="card-text "></span>
                    </div>
                    <div>
                        <span><b class="card-text ">Hora</b></span>
                        <span class="card-text "></span>
                    </div>
                </div>
            </div>            
        </div>
    </div>
    
    <h5 style="padding-top: 5%"> <b>Historial de versiones</b> </h5>

    @foreach ($versions as $version)
            <div>
                @include('documentFlow.card')
            </div>
    @endforeach
</div>

<div class="historial col-md-6">
    <iframe src="http://docs.google.com/gview?url=http://upgrade.com.mx/_docs/prueba.doc&embedded=true" style="width:600px; height:600px;" frameborder="0"></iframe>
</div>