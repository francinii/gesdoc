var myEditor;
DecoupledDocumentEditor.create(document.querySelector(".editor"), {
    toolbar: {
        items: [
            "heading",
            "|",
            "fontSize",
            "fontFamily",
            "|",
            "bold",
            "italic",
            "underline",
            "strikethrough",
            "highlight",
            "|",
            "alignment",
            "|",
            "numberedList",
            "bulletedList",
            "|",
            "indent",
            "outdent",
            "|",
            "todoList",
            "link",
            "blockQuote",
            "imageUpload",
            "insertTable",
            "mediaEmbed",
            "specialCharacters",
            
            "|",
            "undo",
            "redo"
        ]
    },
    language: "es",
    image: {
        toolbar: ["imageTextAlternative", "imageStyle:full", "imageStyle:side"]
    },
    table: {
        contentToolbar: [
            "tableColumn",
            "tableRow",
            "mergeTableCells",
            "tableCellProperties",
            "tableProperties"
        ]
    },
    licenseKey: ""
})
    .then(editor => {
        myEditor=editor;
       // editor.execute( 'pageBreak' );
        window.editor = editor;
       // editor.isReadOnly = true
        // Set a custom container for the toolbar.
        document
            .querySelector(".document-editor__toolbar")
            .appendChild(editor.ui.view.toolbar.element);
        document.querySelector(".ck-toolbar").classList.add("ck-reset_all");
    })
    .catch(error => {
        console.error("Oops, something gone wrong!");
        console.error(
            "Please, report the following error in the https://github.com/ckeditor/ckeditor5 with the build id and the error stack trace:"
        );
        console.warn("Build id: 1ec2378iquub-nlir1rqomxfc");
        console.error(error);
    });

    $( document ).ready(function() {
        myEditor.execute( 'pageBreak' );
    });
   
