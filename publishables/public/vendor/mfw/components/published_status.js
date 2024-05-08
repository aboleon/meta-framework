$(function () {
  const ps = {
    els: function () {
      return $('.aboleon-framework-published_status');
    },
    _token: function () {
      return $('meta[name="csrf-token"]').attr('content');
    },
    messages: {
      pushOnline: function (el) {
        return el.data('label-pushonline');
      },
      pushOffline: function (el) {
        return el.data('label-pushoffline');
      },
      isOnline: function (el) {
        return el.data('label-isonline');
      },
      isOffline: function (el) {
        return el.data('label-isoffline');
      },
    },
    status: function (el) {
      return el.attr('data-status');
    },
    hover: function () {
      this.els().each(function () {
        $(this).hover(function () {
          if (ps.status($(this)) === 'online') {
            $(this).find('button').removeClass('btn-success').addClass('btn-danger').text(ps.messages.pushOffline($(this)));
          } else {
            $(this).find('button').removeClass('btn-danger').addClass('btn-success').text(ps.messages.pushOnline($(this)));
          }
        }, function () {
          if (ps.status($(this)) === 'online') {
            $(this).find('button').removeClass('btn-danger').addClass('btn-success').text(ps.messages.isOnline($(this)));
          } else {
            $(this).find('button').removeClass('btn-success').addClass('btn-danger').text(ps.messages.isOffline($(this)));
          }
        });
      });
    },
    ajax: function () {
      this.els().each(function () {
        $(this).click(function () {
          $.ajax({
            url: $(this).data('ajax-url'),
            type: 'POST',
            data: 'action=publishedStatus&_token=' + ps._token() + '&from=' + ps.status($(this)) + '&id=' + $(this).attr('data-id') + '&class=' + $(this).attr('data-class'),
            context: this,
            success: function (result) {
              console.log(result);
              if (result.hasOwnProperty('success')) {
                if (ps.status($(this)) === 'online') {
                  $(this).attr('data-status', 'offline').find('button').text(ps.messages.isOffline($(this))).removeClass('btn-success').addClass('btn-danger');
                } else {
                  $(this).attr('data-status', 'online').find('button').text(ps.messages.isOnline($(this))).removeClass('btn-danger').addClass('btn-success');
                }
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {
              console.log(thrownError);
            },
          });
        });
      });
    },
    init: function () {
      this.hover();
      this.ajax();
    },
  };
  ps.init();
});
