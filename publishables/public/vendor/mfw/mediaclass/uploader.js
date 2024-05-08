/*jshint esversion: 11 */

/**
 * dependds on /vendor/aboleon-framework/js/commons.js
 */

const MediaclassUploader = {
  template: function () {
    return $('#mediaclass-file-upload');
  },
  uploadable: function (selector) {
    return selector.closest('.mediaclass-uploadable');
  },
  uploadableContainer: function (selector) {
    return this.uploadable(selector).find('.mediaclass-upload-container').first();
  },
  fileupload: function (uploadContainer) {
    return uploadContainer.find('.mediaclass-fileupload').first();
  },
  messages: function () {
    return $('.mediaclass-messages');
  },
  progress: function () {
    return $('.mediaclass-progress');
  },
  defaultFileSize: 16000000,
  calculateMaxFileSize: function (size) {
    let value = this.defaultFileSize;
    if (!size.includes('KB') && !size.includes('MB')) {
      return value;
    }
    value = Number(size.replace(/\D+/g, ''));

    if (size.includes('KB')) {
      return value * 1024;
    }
    if (size.includes('MB')) {
      return value * 1024 * 1024;
    }
  },
  unlinkable: function () {
    $('.unlink').off().on('click', function () {
      let selector = $(this).closest('.unlinkable'),
        c = selector.closest('.uploaded'),
        formData = 'action=delete&id=' + selector.attr('data-id') + '&model=' + c.closest('.mediaclass-uploadable').attr('data-model');
      ajax(formData, MediaclassUploader.template());
      $(document).ajaxSuccess(function () {
        selector.remove();
        if (c.find('.unlinkable').length < 1) {
          $('.mediaclass-alerts').html('<div class="alert alert-info">' + $('.mediaclass-alerts').data('msg') + '</div>');
        }
      });
    });
  },
  uploaderCall: function () {
    $('span.mediaclass-uploader').off().on('click', function () {
      let instantiator = $(this).closest('.mediaclass-uploadable'),
        uploadContainer = MediaclassUploader.uploadableContainer($(this));
      if (uploadContainer.find('.fileupload-container').length < 1) {
        uploadContainer.html(MediaclassUploader.template().html());
        uploadContainer.attr('data-description', instantiator.data('description'));
        MediaclassUploader.initFileupload(uploadContainer);
        MediaclassUploader.uploaderOptions(uploadContainer);
      } else {
        uploadContainer.html('');
      }
    });
  },

  uploaderOptions: function (uploadContainer) {
    let fileuploadContainer = this.fileupload(uploadContainer),
      uploadable = this.uploadable(uploadContainer),
      limit = Number(uploadable.data('limit')),
      inputFileSize = uploadable.data('maxfilesize'),
      maxFileSize = this.calculateMaxFileSize(inputFileSize);

    console.log(maxFileSize);
    fileuploadContainer.fileupload(
      'option',
      {
        previewMaxWidth: 220,
        previewMaxHeight: 220,
        acceptFileTypes: /(\.|\/)(jpe?g|png|svg|pdf)$/i,
        maxFileSize: maxFileSize,
        autoUpload: false,
        maxNumberOfFiles: limit > 0 ? limit : null,
        messages: {
          maxNumberOfFiles: uploadable.find('.ui-messages .maxNumberOfFiles').first().text() + ' ' + limit,
          acceptFileTypes: 'Type de fichier non autorisé',
          maxFileSize: uploadable.find('.ui-messages .maxFileSize').first().text() + ' ' + (inputFileSize !== '' ? inputFileSize : (MediaclassUploader.defaultFileSize / 1024 / 1024)+ 'MB'),
        },
      });
  },
  positions: function (uploadable) {
    uploadable.find('.positions i').off().on('click', function () {
      let p = $(this).closest('.positions');
      p.find('i').removeClass('active');
      $(this).addClass('active');
      p.find('input').val($(this).data('position'));
    });
  },
  langs: {
    'fr': 'Français',
  },
  positions_tags: [
    'left',
    'up',
    'down',
    'right',
  ],
  initFileupload: function (uploadContainer) {
    let fileuploadContainer = this.fileupload(uploadContainer),
      uploadable = this.uploadable(fileuploadContainer),
      hide_description = Number(uploadable.attr('data-has-description')) !== 1;
    console.log(hide_description, 'hide_description', Number(uploadable.attr('data-has-description')));
    fileuploadContainer.off().on('fileuploadadd', function (e, data) {
      fileuploadContainer.find('.uploadables').removeClass('d-none');
      setTimeout(function () {
        if (uploadable.data('positions') !== 1) {
          uploadable.find('.positions').addClass('d-none');
        }
        if (hide_description === true) {
          uploadable.find('.description').addClass('d-none');
        }
        MediaclassUploader.positions(uploadable);
      }, 1);
    }).fileupload({
      url: MediaclassUploader.template().data('ajax'),
      dataType: 'json',
      context: fileuploadContainer[0],
      sequentialUploads: true,
      type: 'POST',
      done: function () {
        MediaclassUploader.progress().hide();
      },
      success: function (data) {
        console.log(data);
        $('.mediaclass-alerts').html('');
        if (data.hasOwnProperty('errors')) {
          notificator(data.errors, 'danger', MediaclassUploader.messages());
        } else {

          uploadable.find('.files').delay(500).fadeOut(function () {
            $(this).html('').show();
          });

          let html = '<div class="mediaclass unlinkable uploaded-image my-2" data-id="' + data.uploaded.id + '" id="mediaclass-' + data.uploaded.id + '">' +
            '<span class="unlink"><i class="bi bi-x-circle-fill"></i></span>' +
            '<div class="row m-0"><div class="col-sm-3 impImg p-0 position-relative preview ' + data.filetype + '" style="background-image: url(' + data.preview + ');">';

          html = html.concat('<div class="actions"><a target="_blank" href="' + data.link + '" class="zoom"><i class="fa-sharp fa-solid fa-magnifying-glass"></i></a>');

          if (data.filetype === 'image') {
            html = html.concat(data.cropable_link);
          }

          html = html.concat('</div>');

          if (data.filetype === 'image') {
            html = html.concat('<div class="sizes">' + data.sizes + '</div>');
          }

          html = html.concat('</div>' +
            '<div class="col-sm-9 impFileName">' +
            '<div class="row infos">' +
            '<div class="col-sm-12"><p class="name">' + data.uploaded.original_filename + '</p></div>' +
            '</div>' +

            '<div class="row params mt-2">' +
            '<div class="col-sm-7 description no-multilang' + (hide_description ? ' d-none' : '') + '">');

          for (const [key, value] of Object.entries(data.uploaded.description)) {
            html = html.concat('<b>Description <span class="lang">' + MediaclassUploader.langs[key] + '</span></b>' +
              '<textarea name="mediaclass[' + data.uploaded.id + '][description][' + key + ']" type="text" class="mt-2 form-control description">' + (value !== null ? value : '') + '</textarea>');
          }
          html = html.concat('</div>' +
            '<div class="col-sm-5 positions text-center ps-2' + (data.has_positions === true ? '' : ' d-none') + '">' +
            '<b>Positions par rapport au contenu</b>' +
            '<div class="choices pt-2">');
          for (const element of MediaclassUploader.positions_tags) {
            html = html.concat('<i class="bi bi-arrow-' + element + '-square-fill active" data-position="' + element + '"></i>');
          }
          html = html.concat('<input type="hidden" name="mediaclass[' + data.uploaded.id + '][position]" value="' + data.uploaded.position + '">' +
            '</div></div></div></div></div></div>');

          let uploadedFilesContainer = uploadable.find('.uploaded');
          uploadedFilesContainer.append(html);
          MediaclassUploader.unlinkable();
          if (uploadedFilesContainer.find('> div.mediaclass.unlinkable').length === Number(data.count_files)) {
            MediaclassUploader.uploadableContainer(uploadable).html('');
          }
          MediaclassUploader.modalCrop();
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr, thrownError);
        MediaclassUploader.messages().html('<div class="alert alert-danger">Une erreur est survenu lors du téléchargement de votre fichier</div>');
      },
      always: function () {
        // MediaclassUploader.progress().hide();
      },
      start: function () {
        MediaclassUploader.messages().html('');
        MediaclassUploader.progress().show();
      },
    });
    fileuploadContainer.bind('fileuploadsubmit', function (e, data) {
      MediaclassUploader.messages().html('');

      let validFiles = 0;
      uploadable.find('.files > div').each(function () {
        if ($(this).find('.error').first().text().length < 1) {
          validFiles += 1;
        }
      });


      data.formData = [];
      data.formData.push(
        {
          name: '_token',
          value: token(),
        },
        {
          name: 'action',
          value: 'upload',
        },
        {
          name: 'group',
          value: uploadable.data('group'),
        },
        {
          name: 'subgroup',
          value: uploadable.data('subgroup'),
        },
        {
          name: 'positions',
          value: uploadable.data('positions'),
        },
        {
          name: 'model',
          value: uploadable.data('model'),
        },
        {
          name: 'model_id',
          value: uploadable.data('model-id'),
        },
        {
          name: 'mediaclass_temp_id',
          value: $('input[name=\'mediaclass_temp_id\']').first().val() ?? '',
        },
        {
          name: 'count_files',
          value: validFiles,
        },
        {
          name: 'cropable',
          value: uploadable.data('cropable'),
        },
      );

      data.context.find('textarea, input').each(function () {
        data.formData.push({
            name: $(this).attr('name'),
            value: $(this).val(),
          },
        );
      });

    });
  },
  modalCrop: function () {
    $('#mediaclass-crop').off().on('show.bs.modal', function (e) {
      let link = $(e.relatedTarget);
      $(this).find('.modal-body').load(link.attr('href'));
    });
    $('body').on('hidden.bs.modal', '.modal', function () {
      $('#mediaclass-crop').find('.modal-body').html('');
    });
  },
  hideModal: function () {
    setTimeout(function () {
      $('#mediaclass-crop').modal('hide');
      $('body').on('hidden.bs.modal', '.modal', function () {
        $('#mediaclass-crop').find('.modal-body').html('');
      });
    }, 1500);
  },
  cropped: function (result) {
    //console.log('Cropped callback', result);
    let media = $('#mediaclass-' + result.uploaded.id);
    media.find('.preview').attr('style', 'background:url(' + result.urls['xl'] + ')');
    media.find('.sizes').html(result.sizes);
    media.find('.zoom').attr('href', result.urls['xl']);
    media.find('.crop').remove();
    this.hideModal();
  },
  init: function () {

    $('.mediaclass-uploadable').each(function () {
      MediaclassUploader.positions($(this));
    });

    this.uploaderCall();
    this.unlinkable();
    this.modalCrop();
  },
};

MediaclassUploader.init();
