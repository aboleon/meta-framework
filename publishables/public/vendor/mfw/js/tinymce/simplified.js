function mfw_simplified_tinymce_settings(targets) {
    let baseHref = location.protocol + '//' + window.location.hostname + '/';
    return {
        selector: targets,
        theme: "silver",
        width: '100%',
        menubar: false,
        entity_encoding: 'raw',
        plugins: 'advlist autolink autosave link code lists media searchreplace anchor wordcount fullscreen nonbreaking table directionality',
        toolbar1: 'blocks fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | cut copy paste | bullist numlist | outdent indent blockquote | undo redo | link unlink code | forecolor',
        image_advtab: true,
        language: 'fr_FR',
        language_url: baseHref + 'vendor/mfw/js/tinymce/langs/fr_FR.js'
    };
}
