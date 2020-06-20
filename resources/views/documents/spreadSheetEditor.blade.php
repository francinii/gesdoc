@extends('layouts.template')

@section('title', 'Hoja de cálculo')

@section('head')
<!--<script src="{{ asset('../resources/extensions/spreadSheet/codebase/spreadsheet.js?v=3.1.4') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('../resources/extensions/spreadSheet/codebase/spreadsheet.css?v=3.1.4') }}" >
<link rel="stylesheet" type="text/css" href="{{ asset('../resources/extensions/spreadSheet/common/index.css?v=3.1.4') }}" >
<script type="text/javascript" src="{{ asset('../resources/extensions/spreadSheet/common/dataset.js?v=3.1.4') }}"></script>
-->

<link rel="stylesheet" href="https://unpkg.com/x-data-spreadsheet@1.1.4/dist/xspreadsheet.css">
<script src="https://unpkg.com/x-data-spreadsheet@1.1.4/dist/xspreadsheet.js"></script>
<script src="https://unpkg.com/x-data-spreadsheet@1.1.4/dist/locale/en.js"></script>

<script>
  x_spreadsheet.locale('en');
</script>

<!-- Esto es para la liberi[a de sheetJS-->

<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

@stop
@section('header')
@include('layouts.header')
@stop
@section('content')
<div class="container-fluid">

<div class="row justify-content-center">
    <div class="col-md-11 button-group">
        <button  type="button" id="CreateSubmit" onclick="" class="btn btn-success ml-auto">
          <i class="fas fa-arrow-left"></i>
        </button> 
        <button type="button" class="btn btn-success float-right" onclick="">
            <i class="fa fa-save" aria-hidden="true"></i>
          Guardar
        </button>
        <button type="button" class="btn btn-danger float-right" onclick="downloadSpread()">
          <i class="fa fa-download"> </i>
          Descargar
        </button>
        <input  type="file" id = "xlf" name = "xlfile" type="button" class="btn btn-info float-right" >
          <i class="fa fa-upload"> </i>
          Importar
       
        <button type="button" class="btn btn-primary float-right" onclick="">
          <i class="fa fa-share-alt"> </i>
          Compartir
        </button> 
    </div>
    <div class="col-md-11">      
        <div id = "xspreadsheet"></div>  
    </div>   
<script>

    var options = {
        mode: 'edit', // edit | read
        showToolbar: true,
        showGrid: true,
        showContextmenu: true,
        view: {
            height: () => document.documentElement.clientHeight,
            width: () => document.documentElement.clientWidth,
        },
        row: {
            len: 100,
            height: 25,
        },
        col: {
            len: 26,
            width: 100,
            indexWidth: 60,
            minWidth: 60,
        },
        style: {
            bgcolor: '#ffffff',
            align: 'left',
            valign: 'middle',
            textwrap: false,
            strike: false,
            underline: false,
            color: '#0a0a0a',
            font: {
            name: 'Helvetica',
            size: 10,
            bold: false,
            italic: false,
            },
        },
    }
     sheet = x_spreadsheet('#xspreadsheet', options);
     
function xtos(sdata) {
 // sheet.cellStyle(ri, ci);
  var out = XLSX.utils.book_new();
  sdata.forEach(function(xws) {
    var aoa = [[]];
    var rowobj = xws.rows;
    for(var ri = 0; ri < rowobj.len; ++ri) {
      var row = rowobj[ri];
      if(!row) continue;
      aoa[ri] = []; 
      Object.keys(row.cells).forEach(function(k) {
        var idx = +k;
        if(isNaN(idx)) return;
        aoa[ri][idx] = row.cells[k].text;
      });
    }
    var ws = XLSX.utils.aoa_to_sheet(aoa);
    XLSX.utils.book_append_sheet(out, ws, xws.name);
  });
  return out;
}




function downloadSpread(){
        /* build workbook from the grid data */
        
        var new_wb = xtos(sheet.getData());
        /* generate download */
        XLSX.writeFile(new_wb, "SheetJS.xlsx");
}



function sheetJSToXSpread(wb) {
  var out = [];
  wb.SheetNames.forEach(function(name) {
    var o = {name:name, rows:{}};
    var ws = wb.Sheets[name];
    var aoa = XLSX.utils.sheet_to_json(ws, {raw: false, header:1});
    aoa.forEach(function(r, i) {
      var cells = {};
      r.forEach(function(c, j) { cells[j] = ({ text: c }); });
      o.rows[i] = { cells: cells };
    })
    out.push(o);
  });
  return out;
}


function uploadSheet() {
 // var files = e.target.files;
 // var f = files[0];
  var reader = new FileReader();
  reader.onload = function(e) {
    var data = new Uint8Array(e.target.result);
    var workbook = XLSX.read(data, {type: 'array'});
    sheet.loadData(sheetJSToXSpread(workbook));
  };
  //reader.readAsArrayBuffer(f);
}

///////////////////////////////////////////////////////////////////////////////////////
/*jshint browser:true */
    /* eslint-env browser */
    /* eslint no-use-before-define:0 */
    /*global Uint8Array, Uint16Array, ArrayBuffer */
    /*global XLSX */
    var X = XLSX;
    var XW = {
        /* worker message */
        msg: 'xlsx',
        /* worker scripts */
        worker: './xlsxworker.js'
    };
    var do_file = (function() {
        var rABS = typeof FileReader !== "undefined" && (FileReader.prototype||{}).readAsBinaryString;
        // Lo que esta comentado es para habilitar  lectura binaria con checkbox
        //var domrabs = document.getElementsByName("userabs")[0];
        //if(!rABS) domrabs.disabled = !(domrabs.checked = false);
       // rABS = true; 
    
        var use_worker = typeof Worker !== 'undefined';
       // var domwork = document.getElementsByName("useworker")[0];
        //if(!use_worker) domwork.disabled = !(domwork.checked = false);
    
        var xw = function xw(data, cb) {
            var worker = new Worker(XW.worker);
            worker.onmessage = function(e) {
                switch(e.data.t) {
                    case 'ready': break;
                    case 'e': console.error(e.data.d); break;
                    case XW.msg: cb(JSON.parse(e.data.d)); break;
                }
            };
            worker.postMessage({d:data,b:rABS?'binary':'array'});
        };
    
        return function do_file(files) {
            //rABS = domrabs.checked;
            rABS = true;
           // use_worker = domwork.checked;
           use_worker = true;
            var f = files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                if(typeof console !== 'undefined') console.log("onload", new Date(), rABS, use_worker);
                var data = e.target.result;
                if(!rABS) data = new Uint8Array(data);
                if(use_worker) xw(data, process_wb);
                else process_wb(X.read(data, {type: rABS ? 'binary' : 'array'}));
            };
            if(rABS) reader.readAsBinaryString(f);
            else reader.readAsArrayBuffer(f);
        };
    })();
    
   
    (function() {
        var xlf = document.getElementById('xlf');
        if(!xlf.addEventListener) return;
        function handleFile(e) { do_file(e.target.files); }
        xlf.addEventListener('change', handleFile, false);
    })();
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36810333-1']);
        _gaq.push(['_trackPageview']);
    
        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        //    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();



////////////////////////////////////////////////////////////////////////////////////////








/*
var do_file = (function() {
	var rABS = typeof FileReader !== "undefined" && (FileReader.prototype||{}).readAsBinaryString;
	var domrabs = document.getElementsByName("userabs")[0];
	if(!rABS) domrabs.disabled = !(domrabs.checked = false);

	var use_worker = typeof Worker !== 'undefined';
	var domwork = document.getElementsByName("useworker")[0];
	if(!use_worker) domwork.disabled = !(domwork.checked = false);

	var xw = function xw(data, cb) {
		var worker = new Worker(XW.worker);
		worker.onmessage = function(e) {
			switch(e.data.t) {
				case 'ready': break;
				case 'e': console.error(e.data.d); break;
				case XW.msg: cb(JSON.parse(e.data.d)); break;
			}
		};
		worker.postMessage({d:data,b:rABS?'binary':'array'});
	};

	return function do_file(files) {
		rABS = domrabs.checked;
		use_worker = domwork.checked;
		var f = files[0];
		var reader = new FileReader();
		reader.onload = function(e) {
			if(typeof console !== 'undefined') console.log("onload", new Date(), rABS, use_worker);
			var data = e.target.result;
			if(!rABS) data = new Uint8Array(data);
			if(use_worker) xw(data, process_wb);
			else process_wb(X.read(data, {type: rABS ? 'binary' : 'array'}));
		};
		if(rABS) reader.readAsBinaryString(f);
		else reader.readAsArrayBuffer(f);
	};
})();*/



function prueba() {
//	var xlf = document.getElementById('import');
//	if(!xlf.addEventListener) return;
	function handleFile(e) { do_file(e.target.files); }
	//xlf.addEventListener('click', handleFile, false);
   
}



</script>

</div> 
  <div class="row  justify-content-center">
        <div class="col-md-12 ">
            <div data-editor="DecoupledDocumentEditor" data-collaboration="false">
                <div class="centered">
                    <div class="row">
                        <div class="document-editor__toolbar"></div>
                    </div>
                    <div class="">
                        <div class="editor">
                         
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </div>
    </div>


</div>
@stop



