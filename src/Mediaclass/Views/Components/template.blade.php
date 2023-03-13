<!-- IMG FILES UPLOAD -->
<template id="mediaclass-file-upload"
          data-ajax="{{ route('mediaclass.ajax') }}">
    <div class="fileupload-container">
        <div class="mediaclass-messages"></div>
        <div class="mediaclass-fileupload">
            <div class="hidden messages">
                <span class="maxNumberOfFiles"><?=trans('mediaclass.maxNumberOfFiles');?></span>
                <span class="max_elements"><?=trans('mediaclass.max_elements');?></span>
                <span class="dimensions"><?=trans('mediaclass.img_dimensions_constraint');?></span>
            </div>

            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
                <div class="d-flex justify-content-center">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-success btn-sm fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span><?=trans('mediaclass.buttons.select');?></span>
                <input type="file" name="files[]" multiple>
            </span>

                    <button type="submit" class="btn btn-info btn-sm start mx-2">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span><?=trans('mediaclass.buttons.download');?></span>
                    </button>
                    <button type="reset" class="btn btn-warning btn-sm cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span><?=trans('mediaclass.buttons.cancel');?></span>
                    </button>
                    <!-- The global file processing state -->
                    <span class="fileupload-process"></span>
                </div>
            </div>
            <!-- The table listing the files available for upload/download -->
            <div role="presentation" class="mt-3 uploadables d-none">
                <div class="files"></div>
            </div>
            <!-- The template to display files available for upload -->
            <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <div class="template-upload">
            <div class="row">
                <div class="col-sm-3 impImg">
                    <span class="preview"></span>
                </div>
                <div class="col-sm-9 impFileName">
                    <div class="row infos">
                        <div class="col-sm-7">
                            <p class="name">{%=file.name%}</p>
                            <strong class="error text-danger"></strong>
                        </div>
                        <div class="col-sm-2">
                            <p class="size">Processing...</p>
                            <div class="mediaclass-progress progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            {% if (!i && !o.options.autoUpload) { %}
                            <button class="btn btn-info btn-xs start" disabled>{{ trans('mediaclass.buttons.download') }}</button>
                            {% } %}
                            {% if (!i) { %}
                            <button class="btn btn-warning btn-xs cancel">{{ trans('mediaclass.buttons.cancel') }}</button>
                            {% } %}
                        </div>
                    </div>

            @foreach($model->mediaLocales() as $locale)
                    <div class="row params mt-2">
                        <div class="col-sm-7 description {{ \MetaFramework\Accessors\Locale::multilang() ? '' :'no-multilang' }}"><b>Description <span class="lang">{{ trans('lang.'.$locale.'.label') }}</span></b>
                            <textarea name="description[{{ $locale }}]" type="text" class="mt-2 form-control description"></textarea>
                        </div>
                        <div class="col-sm-5 positions text-center ps-2">
                            <b>Positions par rapport au contenu</b>
                            <div class="choices pt-2">
                                <i class="bi bi-arrow-left-square-fill active" data-position="left"></i>
                                <i class="bi bi-arrow-up-square-fill" data-position="up"></i>
                                <i class="bi bi-arrow-down-square-fill" data-position="down"></i>
                                <i class="bi bi-arrow-right-square-fill" data-position="right"></i>
                                <input type="hidden" name="position" value="left"/>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
                </div>
                {% } %}

            </script>

            <!-- The template to display files available for download -->
            <script id="template-download" type="text/x-tmpl"><div class="row template-download fade"></div></script>
        </div>
    </div>
</template>
