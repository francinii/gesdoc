<div class="input-group" id="advancedSearch" style="">
    <div class="form-row" style="width:100%">  
        <div class="form-group col-md-5">
        <label for="UsarHistory">{{ __('app.record.table.user') }}</label>
              <input type="text" class="form-control" id="UsarHistory"  onkeyup="advancedSearchfilter(0,this)" placeholder="{{ __('app.record.table.user') }}" name="descriptionFilter">
        </div>
        <div class="form-group col-md-3">
            <label for="actionHistory">{{ __('app.record.table.action') }}</label>
            <select id="actionHistory"class="form-control" name="actionHistory" onchange="advancedSearchfilter(1,this)" >
            <option value="" name ="">{{ __('app.buttons.select') }}</option>  

            </select>
            
        </div>  
        <div class="form-group col-md-3"> 
            <label for="documentHistory">{{ __('app.record.table.document') }}</label>
            <input type="text" class="form-control" id="documentHistory" onkeyup="advancedSearchfilter(2,this)" placeholder="{{ __('app.record.table.document') }}" name="">
        </div>                              
        <div class="dropdown col-md-1  "  >
            <label for="codeFilter">{{ __('app.home.index.otherFilters') }}</label>               
            <button type="button" class="form-control dropdown-toggle btn-secondary" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-filter"></i></button>
            <div class="dropdown-menu dropdown-menu-right"  style="width:99%">
                <form action="{{ action('DocumentController@index') }}" method="POST">
                    {{csrf_field()}}
                    <div class="form-row">  
                        <div class="form-group col-md-4">
                            <label for="dateCreateHistory" class="col-2 col-form-label">{{ __('app.record.table.create') }}</label> 
                            <input class="form-control" type="date" value="" id="dateCreate"  onchange="advancedSearchfilter(6,this)">
 
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dateModificatedHistory" class="col-2 col-form-label">{{ __('app.record.table.modified') }}</label> 
                            <input class="form-control" type="date" value="" id="dateModificatedHistory"  onchange="advancedSearchfilter(7,this)">
                        </div>  
                        <div class="form-group col-md-4"> 
                        <label for="versionHistory">{{ __('app.record.table.version') }}</label>
                            <input type="text" class="form-control" id="versionHistory" onkeyup="advancedSearchfilter(3,this)" placeholder="{{ __('app.record.table.version') }}" name=""></textarea>
                        </div>                               
                    </div> 
                    <div class="form-row">
                        <div class="form-group col-md-6">
                             <label for="flowHistory">{{ __('app.record.table.Flow') }}</label>
                            <select id="flowHistory"class="form-control" name="flowHistory" onchange="advancedSearchfilter(5,this)">
                            <option value="" name ="">{{ __('app.buttons.select') }}</option>                   
 
                            </select>
                            
                        </div>            
                        <div class="form-group col-md-6">
                            <label for="DescriptionHistory">{{ __('app.record.table.description') }}</label>
                            <textarea type="text" class="form-control" id="DescriptionHistory" onkeyup="advancedSearchfilter(4,this)" placeholder="{{ __('app.record.table.description') }}" name=""></textarea>
                        </div>
                    </div>
                </form>   
            </div>
        </div>
    </div>   
</div>
