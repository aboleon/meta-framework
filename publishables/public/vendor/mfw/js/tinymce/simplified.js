var baseHref = location.protocol+'//'+window.location.hostname+'/';
var intro_settings = {
        selector: "textarea.simplified",
        width: '100%',
        menubar : false,
        entity_encoding : "raw",
        plugins: [
        "advlist autolink autosave link lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "table directionality emoticons template paste"
        ],
        toolbar1: "formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | cut copy paste | bullist numlist | outdent indent blockquote | undo redo | link unlink code",
        image_advtab: true ,
        language: "fr_FR",
        language_url :baseHref+"js/tinymce/langs/fr_FR.js"

    }
