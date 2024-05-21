$.fn.hasParent = function (e) {
  return !!$(this).parents(e).length;
};
let token = function () {
    return $('meta[name="csrf-token"]').attr('content');
  },
  dev = true,
  spinner = '<i class="core spinner fa fa-cog fa-spin fa-fw"></i>',
  timerDefault = function () {
    return 500;
  },
  setDelay = (function () {
    let timer = 0;
    return function (callback, ms) {
      clearTimeout(timer);
      timer = setTimeout(callback, ms);
    };
  })(),
  timer = timerDefault(),
  spinout = function () {
    setTimeout(function () {
      $('.spinner').fadeOut(function () {
        $(this).remove();
      });
    }, timer + timerDefault());
  },
  notificationQueue = function (messages) {
    return messages.find(' > div').length;
  },
  notificator = function (status, data, messages) {
    messages.html('');
    if (status === 200) {
      console.log($(data).length, $(data));
      if (!$(data).length) {
        return false;
      }
      $(data).each(function (index, message) {
        timer = timerDefault() * (notificationQueue(messages) + 1);
        $.each(message, function (key, value) {
          alertDispatcher(value, messages, key);
        });
      });
    } else if (status === 422) { // Laraval JSON Validator Messages
      if (data.responseJSON.hasOwnProperty('errors')) {
        $.each(data.responseJSON.errors, function (key, value) {
          alertDispatcher(value[0], messages, 'danger');
        });
      }
    } else if (status === 404 || status === 500 || status === 401) {
      alertDispatcher($('#js_' + status).text(), messages, 'danger');
    } else {
      if (data.hasOwnProperty('responseJSON')) {
        if (data.responseJSON.ajax_messages.length > 0) {
          $.each(data.responseJSON.ajax_messages, function (key, value) {
            $.each(value, function (message_key, message_text) {
              alertDispatcher(message_text, messages, message_key);
            });
          });
        }
      }
    }
    dismissable();
  },
  alertDispatcher = function (message, messages, messageType) {
    messages.append('<div style="display:none;" class="alert alert-dismissible alert-' + messageType + '">' +
      '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
      message + '</div>');
    messages.find('div:last').fadeIn(timer);
  },
  ajax = function (formData, selector) {
    let ajax_url = document.querySelector('meta[name="ajax-route"]').content ?? null,
      ajax_url_origin,
      formTag = selector.closest('.form');

    if (selector[0].hasAttribute('data-ajax')) {
      ajax_url = selector.attr('data-ajax');
      ajax_url_origin = 'selector data-ajax';
    } else if (formTag.length) {
      if (formTag[0].hasAttribute('data-ajax')) {
        ajax_url = formTag.attr('data-ajax');
      }
    }

    dev ? console.log('Ajax started on ' + ajax_url + ' with origin ' + ajax_url_origin) : null;

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      url: ajax_url,
      type: 'POST',
      dataType: 'json',
    });

    selector = (typeof selector == 'undefined' ? $(this).closest('.form') : selector);
    selector.find('.messages').length < 1 ? selector.append('<div class="messages"></div>') : '';

    let messages = selector.find('.messages');
    $.ajax({
      data: formData,
      done: function () {
        messages.html('');
      },
      success: function (result) {
        result.hasOwnProperty('ajax_messages') ? notificator(200, result.ajax_messages, messages) : null;
        let callback = result.hasOwnProperty('callback') ? result.callback : false;
        dev ? console.log(result, 'Result') : null;
        typeof window[callback] === 'function' ? window[callback](result) : null;
        console.log(callback, typeof window[callback] === 'function');
      },
      error: function (xhr) {
        dev ? console.log(xhr) : null;
        notificator(xhr.status, xhr, messages);
      },
    }).always(function () {
      spinout();
    });
  },
  slugify = function (text) {
    return text.toString().toLowerCase().replace(/\s+/g, '-').replace(/[^\u0100-\uFFFF\w\-]/g, '-').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
  },
  guid = function (keylength = 9) {
    let str = '';
    while (str.length < keylength) {
      str += Math.random().toString(36).substr(2);
    }
    return str.substr(0, keylength);
  },
  generateUUID = function () {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
      var r = Math.random() * 16 | 0,
        v = c === 'x' ? r : (r & 0x3 | 0x8);
      return v.toString(16);
    });
  },
  access_key = function (iteration = 10, keylength = 16) {
    function s4() {
      return Math.floor((1 + Math.random()) * 0x10000)
        .toString(keylength)
        .substring(1);
    }

    let hash = '';
    for (let i = 0; i < iteration; ++i) {
      hash = hash.concat(s4());
      //return s4() + s4() + s4() + s4() + s4() + s4() + s4() + s4() + s4() + s4();
    }
    return hash;
  },
  isUrlValid = function (userInput) {
    var regexQuery = '^(https://)?(www\\.)?([-a-z0-9]{1,63}\\.)*?[a-z0-9][-a-z0-9]{0,61}[a-z0-9]\\.[a-z]{2,6}(/[-\\w@\\+\\.~#\\?&/=%]*)?$';
    var url = new RegExp(regexQuery, 'i');
    return url.test(userInput);
  },
  dismissable = function () {
    $('.alert-dismissible button').off().on('click', function () {
      $(this).parent().remove();
    });
  },
  currentDate = function () {
    var today = new Date(),
      dd = today.getDate(),
      mm = today.getMonth() + 1; //January is 0!,
    yyyy = today.getFullYear();
    if (dd < 10) {
      dd = '0' + dd;
    }
    if (mm < 10) {
      mm = '0' + mm;
    }
    return dd + '/' + mm + '/' + yyyy;
  },
  // Téléchargement des images : annuler
  cancel = function () {
    $('#fileupload table').find('tbody').html('').end().hide();
    $('#imp .messages').html('');
  },
  resetIteration = function (container) {
    let iterations = container.find('.iteration');
    console.log('lenght is ' + iterations.length, 'container is ' + container.attr('id'));
    if (iterations.length) {
      $('.iteration.zero').hide();
      iterations.each(function (index) {
        $(this).text(index + 1);
      });
    } else {
      container.parent().find('.iteration.zero').show();
    }
  },
  attributeUpdater = function (target, old_id, new_id) {

    function replace(variable) {
      return variable.replace(old_id, new_id);
    }

    target.attr('data-id', new_id);

    target.find('textarea, input, select, label').each(function () {
      let name = $(this).attr('name'),
        id = $(this).attr('id'),
        label = $(this).attr('for');
      name !== undefined ? $(this).attr('name', replace(name)) : null;
      id === undefined ? $(this).attr('id', $(this).attr('name')) : $(this).attr('id', replace(id));
      label === undefined ? $(this).attr('for', $(this).parent().find('input').attr('id')) : $(this).attr('for', replace(label));
    });
  },
  removable = function () {
    $('a.removable').off().on('click', function (e) {
      e.preventDefault();
      let container = $(this).parents('.removable').parent();
      $(this).parents('.removable').remove();
      resetIteration(container);
    });
  },
  setVeil = function (c) {
    c.prepend('<div class="veil" style="border-radius:25px"><img class="loading" src="/assets/system/loading.svg" width="40" alt="..."></div>');
  },
  removeVeil = function () {
    $('.veil').remove();
  };

const wa_geo_control = {
  reset: function (el) {
    $(el).find($('.g_autocomplete')).on('keyup change', function () {
      console.log('typing in ' + el + 'g_autocomplete');
      $('.wa_geo_lat, .wa_geo_lon').val('');
    });
  },
};
$(function () {
  $('.toggle').click(function () {
    $(this).parent().find('.toggable').slideToggle();
    $(this).find('i').toggleClass('fa-chevron-up');
  });
});


setTimeout(function () {
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

}, 500);
