<div class="input-group" id="advancedSearch" style="display:none;">
    <div class="form-row" style="width:100%">  
        <div class="form-group col-md-5">
        <label for="descriptionFilter">{{ __('app.documents.general.name') }}</label>
              <input type="text" class="form-control" id="descriptionFilter"  onkeyup="advancedSearchfilter(1,this)" placeholder="{{ __('app.documents.general.name') }}" name="descriptionFilter">
        </div>
        <div class="form-group col-md-3">
            <label for="classificationFilter">{{ __('app.documents.edit.classification') }}</label>
            <select id="classificationFilter"class="form-control" name="classificationFilter" onchange="advancedSearchfilter(6,this)" >
            <option value="" name ="">{{ __('app.buttons.select') }}</option>  

            </select>
            
        </div>  
        <div class="form-group col-md-3"> 
            <label for="codeFilter">{{ __('app.documents.general.code') }}</label>
            <input type="text" class="form-control" id="codeFilter" onkeyup="advancedSearchfilter(9,this)" placeholder="{{ __('app.documents.general.code') }}" name="">
        </div>                              
        <div class="dropdown col-md-1  "  >
            <label for="codeFilter">{{ __('app.home.index.otherFilters') }}</label>               
            <button type="button" class="form-control dropdown-toggle btn-secondary" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-filter"></i></button>
            <div class="dropdown-menu dropdown-menu-right"  style="width:99%">
                <form action="{{ action('DocumentController@index') }}" method="POST">
                    {{csrf_field()}}
                    <div class="form-row"> 
                    <div class="form-group col-md-3"> 
                            <label for="stadeFilter">{{ __('app.home.table.stade') }}</label>
                            <input type="text" class="form-control" id="stadeFilter"  onkeyup="advancedSearchfilter(2,this)" placeholder="{{ __('app.home.table.stade') }}" name="stadeFilter">
                            <option value="" name ="">{{ __('app.buttons.select') }}</option>                   
 
                            </select>
                        </div>  
                    <div class="form-group col-md-3"> 
                            <label for="flowFilter">{{ __('app.documents.edit.flow') }}</label>
                            <select id="flowFilter"class="form-control" name="flowFilter" onchange="advancedSearchfilter(7,this)">
                            <option value="" name ="">{{ __('app.buttons.select') }}</option>                   
 
                            </select>
                        </div>  
                        <div class="form-group col-md-3">
                            <label for="dateCreateFilter" class="col-2 col-form-label">{{ __('app.home.table.create') }}</label> 
                            <input class="form-control" type="date" value="" id="dateCreate"  onchange="advancedSearchfilter(3,this)">
 
                        </div>
                        <div class="form-group col-md-3">
                            <label for="dateModificated" class="col-2 col-form-label">{{ __('app.home.table.modified') }}</label> 
                            <input class="form-control" type="date" value="" id="dateModificated"  onchange="advancedSearchfilter(4,this)">
                        </div>                             
                    </div> 
                    <div class="form-row">
                        <div class="form-group col-md-4"> 
                            <label for="languajeFilter">{{ __('app.documents.general.languaje') }}</label>
                            <input type="text" class="form-control" id="languajeFilter" onkeyup="advancedSearchfilter(10,this)" placeholder="{{ __('app.documents.general.languaje') }}" name=""></textarea>
                        </div>            
                        <div class="form-group col-md-4">
                            <label for="summaryFilter">{{ __('app.documents.general.summary') }}</label>
                            <textarea type="text" class="form-control" id="summaryFilter" onkeyup="advancedSearchfilter(8,this)" placeholder="{{ __('app.documents.general.summary') }}" name=""></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="othersFilter">{{ __('app.documents.general.others') }}</label>
                            <textarea type="text" class="form-control" id="othersFilter" onkeyup="advancedSearchfilter(11,this)" placeholder="Otros datos" name=""></textarea>
                        </div>    

                    </div>
                </form>   
            </div>
        </div>
    </div>   
</div>

