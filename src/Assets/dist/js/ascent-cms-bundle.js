function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

// ******
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022
$.ascent = $.ascent ? $.ascent : {};
/*
 * THE HOST FORM
 */

var MultiStepForm = {
  _steps: null,
  _init: function _init() {
    var self = this;
    this._steps = $(this.element).find('.msf-step').multistepformstep(); // remove the back button from the first step

    $(this._steps[0]).find('.msf-back').remove();
    $(this._steps[0]).multistepformstep('show'); // handler for step-complete event (validation handled in the step)

    $(this.element).on('step-complete', function (e) {
      var nextStep = $(e.target).nextAll('.msf-step:not(.msf-disabled)').first()[0];

      if (nextStep) {
        // if there's a next step, display it
        $(e.target).multistepformstep('hide');
        $(nextStep).multistepformstep('show');
      } else {
        // if not, we're on the final step, so we post the data (by simply submitting the form)
        $(self.element).submit();
      }
    }); // back button handler

    $(this.element).on('step-back', function (e) {
      $(e.target).multistepformstep('hide');
      $(e.target).prevAll('.msf-step:not(.msf-disabled)').first().multistepformstep('show');
    }); // Error Message removal - disabled
    // $(this.element).on('change', 'input, select, textarea', function() {
    //     // console.log($(this).attr('name'));
    //     try {
    //         $('.error-display[for="' + $(this).attr('name').replace(/\[/g, '.').replace(/\]/g, '') + '"]').html('');
    //     } catch (e) {
    //         // nevermind
    //     }
    // });
  },
  setOptions: function setOptions($opts) {// replace the existing options with the provided array
  },
  disableStep: function disableStep($key) {
    // alert('disabling...');
    $('#msf-step-' + $key).multistepformstep('disable');
  },
  enableStep: function enableStep($key) {
    // alert('enabling...');
    $('#msf-step-' + $key).multistepformstep('enable');
  }
};
/*
 *   FORM STEP
 */

var MultiStepFormStep = {
  _init: function _init() {
    var self = this; // console.log(this);
    //    cosnsole.log($(this.element).data('validators'));
    // console.log($(this).attr('data-validators'));

    $(this.element).on('click', '.msf-continue', function () {
      if (self.validate()) {
        // advance to next step.
        $(self.element).trigger('step-complete');
      }
    });
    $(this.element).on('click', '.msf-back', function () {
      // return to previous step (note - no validation needed)
      $(self.element).trigger('step-back');
    });
  },
  setOptions: function setOptions($opts) {// replace the existing options with the provided array
  },
  validate: function validate() {
    var success = false;
    var self = this; // clear any existing form errors

    $('.error-display').html('');
    $.ajax({
      url: '/msf-validate',
      method: 'post',
      data: {
        input: $(this.element).parents('form').serialize(),
        validators: $(self.element).data('validators')
      },
      async: false,
      headers: {
        'Accept': "application/json"
      }
    }).done(function () {
      success = true;
    }).fail(function (data) {
      // console.log(data.responseJSON.errors);
      switch (data.status) {
        case 422:
          // validation fail
          var errors = self.flattenObject(data.responseJSON.errors);

          for (fldname in errors) {
            var undotArray = fldname.split('.');

            for (i = 1; i < undotArray.length; i++) {
              undotArray[i] = '[' + undotArray[i] + ']';
            }

            aryname = undotArray.join('');
            val = errors[fldname];

            if ((typeof val === "undefined" ? "undefined" : _typeof(val)) == 'object') {
              //fldname = fldname + '[]';
              val = Object.values(val).join('<BR/>');
            }

            $('.error-display[for="' + aryname + '"]').append('<small class="validation-error alert alert-danger form-text" role="alert">' + val + '</small>');
          } // need to display these errors:


          break;

        default:
          // something else
          alert(data.statusText + " - " + data.responseJSON.message);
      }
    });
    return success;
  },
  // removes the step from the form flow
  disable: function disable() {
    console.log(this);
    $(this.element).addClass('msf-disabled');
    $('#progress-' + $(this.element).data('stepslug')).addClass('msf-disabled');
  },
  // adds the step back into the form flow
  enable: function enable() {
    $(this.element).removeClass('msf-disabled');
    $('#progress-' + $(this.element).data('stepslug')).removeClass('msf-disabled');
  },
  show: function show() {
    $('ol li.current').removeClass('current');
    $('#progress-' + $(this.element).data('stepslug')).addClass('current');
    $(this.element).show(); //fadeIn('fast');

    $(this.element).trigger({
      type: 'msf.show.step',
      step: $(this.element).data('stepslug')
    });
  },
  hide: function hide() {
    $(this.element).hide(); //fadeOut('fast');

    $(this.element).trigger({
      type: 'msf.hide.step',
      step: $(this.element).data('stepslug')
    });
  },
  flattenObject: function flattenObject(ob) {
    var toReturn = {};

    for (var i in ob) {
      if (!ob.hasOwnProperty(i)) continue;

      if (_typeof(ob[i]) == 'object' && ob[i] !== null) {
        var flatObject = this.flattenObject(ob[i]);

        for (var x in flatObject) {
          if (!flatObject.hasOwnProperty(x)) continue;
          toReturn[i + '.' + x] = flatObject[x];
        }
      } else {
        toReturn[i] = ob[i];
      }
    }

    return toReturn;
  }
};
$.widget('ascent.multistepformstep', MultiStepFormStep);
$.extend($.ascent.MultiStepFormStep, {});
$.widget('ascent.multistepform', MultiStepForm);
$.extend($.ascent.MultiStepForm, {});
$(document).ready(function () {
  $('form.multistepform').multistepform();
});
$.ascent = $.ascent ? $.ascent : {};
var AjaxLink = {
  self: null,
  targetPath: null,
  responseTarget: null,
  _init: function _init() {
    var self = this;
    this.widget = this;
    var thisID = this.element[0].id;
    var obj = this.element; // We're calling this on click, so just launch straight into the business end...
    // window.location.href = $(this.element).attr('href');

    if (this.options.target) {
      this.targetPath = this.options.target;
    } else {
      this.targetPath = $(this.element).attr('href');
    }

    if (obj.data('response-target')) {
      this.responseTarget = obj.data('response-target');
    } //$('#ajaxModal').hide();


    console.log(self.targetPath);
    $.ajax({
      type: 'GET',
      url: self.targetPath,
      headers: {
        'Accept': "application/json"
      }
    }).done(function (data, xhr, request) {
      console.log(self.responseTarget);

      if (self.responseTarget) {
        switch (self.responseTarget) {
          case 'reload':
          case 'refresh':
            //  alert('refreshing...');
            window.location.reload();
            break;

          default:
            $(self.responseTarget).html(data);
            break;
        }
      } else {
        alert(data);
      }
    }).fail(function (data) {
      // hopefully this won't ever fail as we did the HEAD first
      console.log(data);

      switch (data.status) {
        default:
          alert('An unexpected error occurred:\n' + data.responseJSON.message);
          break;
      }
    });
    return false;
  }
};
$.widget('ascent.ajaxLink', AjaxLink);
$.extend($.ascent.ajaxLink, {});
/* Assign this behaviour by link class */

$(document).on('click', 'A.ajaxLink, A.ajax-link', function (e) {
  $(this).ajaxLink();
  e.stopPropagation();
  return false; // stop the link firing normally!
}); // Code (c) Kieran Metcalfe / Ascent Creative 2022
// Code may be used as part of a site built and hosted by Ascent Creative, but may not be transferred to 3rd parties

$.ascent = $.ascent ? $.ascent : {};
var CookieManager = {
  _init: function _init() {
    var self = this;
    this.widget = this;
    var cookieCount = 0;
    var typeCount = 0;

    for (item in self.options.types) {
      var crumb = $.cookie('acm_' + item);

      if (crumb) {
        cookieCount++;
      }

      typeCount++;
    }

    if (cookieCount == 0) {
      //var status = 'new';
      self.prompt(false);
    } else if (cookieCount == typeCount) {
      self.action(); //var status = 'ok';
    } else {
      self.prompt(true); //var status = 'changed';
    }

    self.action();
    var opts = self.options;
    $(window).on('resize', function () {//	self.layout();
    }); //self.layout();

    $('.acm_manage').on('click', function () {
      $('#acm_modal').modal('show');
    });
  },
  manage: function manage() {
    this.prompt('manage');
  },
  prompt: function prompt(changed) {
    var acm = this;

    if (changed) {
      var headertext = "Our cookies have changed - please review your preferences.";
    }

    $('.acm_cookietype').on('click', function () {
      $(this).toggleClass('acm_selected');
    });
    $('.acm_acceptselected').on('click', function () {
      $('.acm_cookietype').each(function () {
        if ($(this).hasClass("acm_selected") || $(this).hasClass("acm_mandatory")) {
          //acm.options.types[item].mandatory || $('#acm_details_' + item).hasClass('acm_selected')) {
          $.cookie($(this).attr('data-cookie'), '1', {
            path: '/',
            expires: 365
          });
        } else {
          $.cookie($(this).attr('data-cookie'), '0', {
            path: '/',
            expires: 365
          });
        }
      });
      $('#acm_wrap').fadeOut(); //remove();

      acm.action();
      $('#acm_wrap').remove();
      $('#acm_modal').modal('hide');
      return false;
    });
    $('#acm_wrap').fadeIn();
    $('.acm_acceptall').on('click', function () {
      // console.log('all');
      $('.acm_cookietype').each(function () {
        $.cookie($(this).attr('data-cookie'), '1', {
          path: '/',
          expires: 365
        });
        $(this).addClass("acm_selected");
      });
      $('#acm_wrap').fadeOut(); //remove();

      acm.action();
      $('#acm_wrap').remove();
      $('#acm_modal').modal('hide');
      return false;
    });
    $('A#acm_choose').on('click', function () {
      $('#acm_choose').hide(); // $('#acm_details').slideDown();

      return false;
    });
  },
  action: function action() {
    var acm = this;
    $('.acm_cookietype').each(function () {
      // if the cookie is set to YES, copy the template into the DOM.
      if ($.cookie($(this).attr('data-cookie')) == '1') {
        console.log($(this).attr('data-cookie'));
        var template = $('template#' + $(this).attr('data-cookie'));

        if ($(template).length > 0) {
          $('body').append(template.html());
        }

        var headtemplate = $('template#' + $(this).attr('data-cookie') + '_head');

        if ($(headtemplate).length > 0) {
          $('head').append(headtemplate.html());
        }
      }
    });
  },
  check: function check(type) {
    var val = $.cookie('acm_' + type);

    if (!val) {
      alert('is null');
      return false;
    }

    if (val == '0') {
      alert('is NO');
      return false;
    }

    if (val == '1') {
      alert('is YES');
      return true;
    }
  },
  set: function set(opts) {// try to set a cookie, but if only if the relevant type agrees!
  }
};
$.widget('ascent.cookiemanager', CookieManager);
$.extend($.ascent.CookieManager, {});
$(document).ready(function () {
  $(document).cookiemanager();
});
$.ascent = $.ascent ? $.ascent : {};
var ModalLink = {
  self: null,
  loginPath: '/modal/cms/modals.login',
  targetPath: '',
  backdrop: true,
  keyboard: true,
  _init: function _init() {
    var self = this;
    this.widget = this;
    var thisID = this.element[0].id;
    var obj = this.element;
    /* I think, actually, we should read these from the loaded Modal... 
        Makes it more flexible in a run of dialogs so each can be specified individually */

    if (this.element.data('backdrop') != null) {
      this.backdrop = this.element.data('backdrop');
    }

    if (this.element.data('keyboard') != null) {
      this.keyboard = this.element.data('keyboard');
    } // We're calling this on click, so just launch straight into the business end...


    if (this.options.target) {
      this.targetPath = this.options.target;
    } else {
      this.targetPath = $(this.element).attr('href');
    }

    if (this.element.data('serialiseForModal')) {
      self.targetPath += '?' + $(this.element.data('serialiseForModal')).serialize();
    } // alert(this.element.prop("tagName"));


    ajaxConfig = {
      headers: {
        'Accept': "application/json",
        'ModalLink': 1
      }
    };

    try {
      // allow the modal link to be used for a FORM POST as well as a link click:
      if (this.element.prop("tagName") == "FORM") {
        // alert('form process');
        ajaxConfig = $.extend(ajaxConfig, {
          type: 'POST',
          url: this.element.attr('action'),
          contentType: false,
          processData: false,
          data: new FormData(this.element[0])
        });
      } else {
        // alert('link process');
        ajaxConfig = $.extend(ajaxConfig, {
          type: 'GET',
          url: self.targetPath
        });
      }
    } catch (error) {
      console.log(error);
    }

    $.ajax(ajaxConfig).done(function (data, xhr, request) {
      $(self.element).parents(".dropdown-menu").dropdown('toggle');
      var cType = request.getResponseHeader('content-type');

      if (cType.indexOf('text/html') != -1) {
        self.showResponseModal(data);
      } else {
        //   alert(cType);
        window.location.href = self.targetPath; // close any open modals!

        $('.modal').modal('hide');
      }
    }).fail(function (data) {
      // hopefully this won't ever fail as we did the HEAD first
      console.log(data);

      switch (data.status) {
        case 401:
          console.log(data); //fire off a request to the login form instaead.

          $.get(self.loginPath + '?intended=' + self.targetPath).done(function (data) {
            self.showResponseModal(data);
          }).fail(function (data) {
            console.log('FAIL WITHIN FAIL!');
            console.log(data.responseText);
          });
          break;

        default:
          alert('An unexpected error occurred:\n' + data.responseJSON.message);
          break;
      }
    });
    return false;
  },
  showResponseModal: function showResponseModal(data) {
    /* if we're already in a modal, detect it and remove the existing modal */
    inFlow = false;

    if ($('body .modal').length > 0) {
      inFlow = true; // take note - we'll need this later

      $('body .modal#ajaxModal, body .modal-backdrop').remove(); // kill the calling modal
    } // add the newly supplied modal


    $('body').append(data);

    if (inFlow) {
      // if we were already in a flow of modals, remove the fade class
      // stops the backdrop glitching
      $('body .modal').removeClass('fade');
    } // fire up the new modal


    $('#ajaxModal').modal({
      backdrop: this.backdrop,
      keyboard: this.keyboard
    }); // if we removed the fade class, re-add it now so this one fades out nicely!

    if (inFlow) {
      $('body .modal').addClass('fade');
    } // handler to remove the HTML for this modal when it's done with


    $('#ajaxModal').on('hidden.bs.modal', function () {
      $(this).remove();
    }); // all done

    /* grab forms... */

    var self = this;
    $('#ajaxModal FORM').not('.no-ajax').submit(function () {
      try {
        var form = this;
        $('.validation-error').remove(); // switched to use formdata to allow files.

        var formData = new FormData($(form)[0]); // console.log(...formData);

        $.ajax({
          type: 'POST',
          contentType: false,
          processData: false,
          url: $(this).attr('action'),
          headers: {
            'Accept': "application/json",
            'ModalLink': 1
          },
          // responseType: 'blob',
          xhr: function xhr() {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function () {
              //   alert('here');
              if (xhr.readyState == 2) {
                // detect if we're getting a file in the response
                var disposition = xhr.getResponseHeader('content-disposition');

                if (disposition && disposition.indexOf('attachment') !== -1) {
                  // if so, we'll interpret it as an arraybuffer (to create a BLOB to return to the user)
                  xhr.responseType = "arraybuffer";
                } else {
                  // no attachment? Must be text-based / json / html etc
                  xhr.responseType = "text";
                }
              }
            };

            return xhr;
          },
          data: formData,
          statusCode: {
            200: function _(data, xhr, request) {
              var disposition = request.getResponseHeader('content-disposition');

              if (disposition && disposition.indexOf('attachment') !== -1) {
                /** INCOMING DOWNLOAD!  */
                // convert to a blob and pass to the DOM as an object which gets downloaded.
                var contentType = request.getResponseHeader('content-type');
                var file = new Blob([data], {
                  type: contentType
                });
                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                var matches = filenameRegex.exec(disposition);

                if (matches != null && matches[1]) {
                  filename = matches[1].replace(/['"]/g, '');
                }

                if ('msSaveOrOpenBlob' in window.navigator) {
                  window.navigator.msSaveOrOpenBlob(file, filename);
                } // For Firefox and Chrome
                else {
                  // Bind blob on disk to ObjectURL
                  var data = URL.createObjectURL(file);
                  var a = document.createElement("a");
                  a.style = "display: none";
                  a.href = data;
                  a.download = filename;
                  document.body.appendChild(a);
                  a.click(); // For Firefox

                  setTimeout(function () {
                    document.body.removeChild(a); // Release resource on disk after triggering the download

                    window.URL.revokeObjectURL(data);
                  }, 100);
                }

                $('#ajaxModal').modal('hide');
              } else {
                if (request.getResponseHeader('fireEvent')) {
                  $(document).trigger(request.getResponseHeader('fireEvent'));
                }

                if (data) {
                  if ($(data).hasClass('modal')) {
                    self.showResponseModal(data);
                  } else {
                    $(document).trigger({
                      type: 'modal-link-response',
                      response: data
                    });
                    $('#ajaxModal').modal('hide');
                  }
                } else {
                  switch ($(form).attr('data-onsuccess')) {
                    case 'refresh':
                      window.location.reload();
                      break;

                    default:
                      $('#ajaxModal').modal('hide');
                  }
                }
              }
            },
            201: function _(data, xhr, request) {
              switch ($(form).attr('data-onsuccess')) {
                case 'refresh':
                  window.location.reload();
                  break;

                default:
                  if (data) {
                    self.showResponseModal(data);
                  } else {
                    $('#ajaxModal').modal('hide');
                  }

              }
            },
            302: function _(data, xhr, request) {
              if (data.getResponseHeader('fireEvent')) {
                $(document).trigger(data.getResponseHeader('fireEvent'));
              }

              if (data.responseJSON.hard) {
                window.location = data.responseJSON.url;
                return;
              }

              switch (data.responseJSON) {
                case 'reload':
                case 'refresh':
                  window.location.reload();
                  break;

                default:
                  $('body').modalLink({
                    target: data.responseJSON
                  });
                  break;
              } //$('.modal').modal('hide');

            },
            422: function _(data, xhr, request) {
              console.log(422);
              console.log(data.responseJSON.errors);
              var errors = self.flattenObject(data.responseJSON.errors);

              for (fldname in errors) {
                var undotArray = fldname.split('.');

                for (i = 1; i < undotArray.length; i++) {
                  undotArray[i] = '[' + undotArray[i] + ']';
                }

                aryname = undotArray.join('');
                val = errors[fldname];

                if ((typeof val === "undefined" ? "undefined" : _typeof(val)) == 'object') {
                  //fldname = fldname + '[]';
                  val = Object.values(val).join('<BR/>');
                }

                $('.error-display[for="' + aryname + '"]').append('<small class="validation-error alert alert-danger form-text" role="alert">' + val + '</small>');
              }
            },
            500: function _(data, xhr, request) {
              alert('An unexpected error occurred:' + "\n\n" + data.responseJSON.message);
            }
          }
        });
      } catch (e) {
        console.log(e);
        return false;
      }

      return false;
    });
  },
  flattenObject: function flattenObject(ob) {
    var toReturn = {};

    for (var i in ob) {
      if (!ob.hasOwnProperty(i)) continue;

      if (_typeof(ob[i]) == 'object' && ob[i] !== null) {
        var flatObject = this.flattenObject(ob[i]);

        for (var x in flatObject) {
          if (!flatObject.hasOwnProperty(x)) continue;
          toReturn[i + '.' + x] = flatObject[x];
        }
      } else {
        toReturn[i] = ob[i];
      }
    }

    return toReturn;
  }
};
$.widget('ascent.modalLink', ModalLink);
$.extend($.ascent.ModalLink, {});
/* Assign this behaviour by link class */

$(document).on('click', 'A.modalLink, A.modal-link', function (e) {
  $(this).modalLink();
  e.stopPropagation();
  return false; // stop the link firing normally!
});
/* Assign this behaviour by link class */

$(document).on('submit', 'form.modal-link', function (e) {
  $(this).modalLink();
  e.stopPropagation();
  return false; // stop the link firing normally!
});
$.ascent = $.ascent ? $.ascent : {};
var NestedSet = {
  self: null,
  _init: function _init() {
    var self = this;
    this.widget = this;
    var thisID = this.element[0].id;
    obj = this.element; //self = this;

    obj.addClass("nestedset"); /// alert('init NS');

    console.log(this.options.scopeData);
    console.log(this.options.nestedSetData);
    this.options.scopeVal = $(obj).find('INPUT.ns_scopefield').val();
    this.options.relationshipVal = $(obj).find('INPUT.ns_relationshipfield').val();
    this.options.relationVal = $(obj).find('INPUT.ns_relationfield').val();
    this.options.relationLabel = $(obj).find('INPUT.ns_relationlabel').val();
    $(obj).append('<div class="ns_scope" />');
    $(obj).append('<div class="ns_relate" style="display: flex; justify-content: space-between; padding-top: 10px;"/>');
    $(obj).find('.ns_relate').append('<SELECT style="flex: 0 0 20%;" class="ns_relationshipselect form-control" name="' + this.options.relationshipFieldName + '"><OPTION value="">Position As:</OPTION></SELECT>');
    $(obj).find('SELECT.ns_relationshipselect').append('<option value="first-child">First Child Of</option><option value="before">Sibling Before</option><option value="after">Sibling After</option>');
    $(obj).find('SELECT.ns_relationshipselect').val(this.options.relationshipVal);
    $(obj).find('INPUT.ns_relationshipfield').remove();
    $(obj).find('INPUT.ns_relationfield').remove();
    $(obj).find('INPUT.ns_relationlabel').remove(); // don't set any options in the relation field - scopeChange does that based on the selected scope.

    $(obj).find('.ns_relate').append('<SELECT style="flex: 0 0 77%" class="ns_relationselect form-control" name="' + this.options.relationFieldName + '"><OPTION value="">Please Select:</OPTION></SELECT>'); // init scopes (need to do this after the relation fields so they're in place to receive values)

    $(obj).find(".ns_scope").append('<SELECT class="ns_scopeselect form-control" name="' + this.options.scopeFieldName + '"><OPTION value="">' + this.options.nullScopeLabel + '</OPTION></SELECT>');

    for (idx in this.options.scopeData) {
      item = this.options.scopeData[idx];
      $(obj).find('SELECT.ns_scopeselect').append('<OPTION value="' + item['id'] + '">' + item['title'] + '</OPTION>');
    }

    $(obj).find('SELECT.ns_scopeselect').val(this.options.scopeVal).on("change", this.scopeChange).trigger('change');
    $(obj).find('INPUT.ns_scopefield').remove(); // init relations:
    // console.log('done INIT');
  },
  scopeChange: function scopeChange() {
    console.log('scope change...');
    console.log(this);
    scope = $(this).val();
    widget = $(this).parents('.nestedset').nestedset('instance');
    obj = widget.element;
    console.log(widget);
    console.log(widget.options.relationFieldName); // console.log($(obj).nestedset());

    $(obj).find('.ns_relate SELECT.ns_relationselect OPTION[value!=""]').remove(); //alert(scope);

    if (scope == '') {
      // no scope, so no values
      $(obj).find('.ns_relate').hide();
      $(obj).find('.ns_relate SELECT').val('');
    } else {
      $(obj).find('.ns_relate').show(); // add in the options for the relation data 

      opts = widget.traverse(widget.options.nestedSetData, scope).join('');
      $(obj).find('SELECT.ns_relationselect').append(opts); //widget.traverse(widget.options.nestedSetData , scope).join('') ) ;

      if (widget.options.relationVal != '') {
        $(obj).find('SELECT.ns_relationselect').val(widget.options.relationVal);
        widget.options.relationVal = '';
      } else {
        console.log('fwefe');
        $(obj).find('SELECT.ns_relationselect').val('');
      } //$(console.log(widget.traverse(widget.options.nestedSetData , scope));

    }
  },
  traverse: function traverse(nodes, scope) {
    var depth = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;
    var opts = [];

    for (node in nodes) {
      if (nodes[node].menu_id == scope) {
        // console.log(depth + ': ' + nodes[node]);
        label = '-'.repeat(depth) + " " + nodes[node][this.options.relationLabel];
        opts.push('<OPTION value="' + nodes[node]['id'] + '">' + label.trim() + '</OPTION>');
        children = this.traverse(nodes[node].children, scope, depth + 1);

        for (var i = 0; i < children.length; i++) {
          opts.push(children[i]);
        }
      }
    }

    return opts;
  }
};
$.widget('ascent.nestedset', NestedSet);
$.extend($.ascent.NestedSet, {});
$.ascent = $.ascent ? $.ascent : {}; // Show / Hide elements based on values of other fields
// - Basic version - fires on a change event, specify a single field to monitor, hide-if/show-if values to check against
// Very likely I'll need to make this cleverer in future...

var ShowHide = {
  self: null,
  _init: function _init() {
    var self = this; // console.log('init ShowHide');

    $(document).on('change', this.process); // need a call here to run all rules to set default state.
    // find all elements with data-showhide set and evaluate their rules.
    // more processor heavy than the incremental update on change...

    $('[data-showhide]').each(function (idx) {
      self.evaluate(this, null, false);
    }); // mutation observer to run on newly added elements:

    MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
    var observer = new MutationObserver(function (mutations, observer) {
      $('[data-showhide]').each(function (idx) {
        self.evaluate(this);
      });
    }); // run on changes to the childList across the subtree

    observer.observe(document, {
      subtree: true,
      childList: true
    });
  },
  // Process an event and toggle the changes needed.
  process: function process(e) {
    console.log("processing", e);
    console.log($(e.target).attr('name'));
    var field = $(e.target).attr('name');
    var value = $(e.target).val();

    if ($(e.target).attr('type') == 'checkbox' && !$(e.target).is(":checked")) {
      value = '';
    } // console.log($(e.target).serialize());
    // get all elements with a rule based on this field.


    var elms = $('[data-showhide="' + field + '"]');
    console.log(elms.length + ' dependent elements'); // let self = this;

    $(elms).each(function (idx) {
      // console.log(self);
      $(document).showhide('evaluate', this, value);
    });
  },
  evaluate: function evaluate(elm) {
    var value = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
    var animate = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;

    if (value === null) {
      // lookup the value if not supplied from the event:
      source = $('[name="' + $(elm).attr('data-showhide') + '"]').last();

      if (source.attr('type') == 'checkbox') {
        checked = $('[name="' + $(elm).attr('data-showhide') + '"]:checked')[0];

        if (checked) {
          source = $(checked);
        }
      }

      value = source.val();

      if (source.attr('type') == 'checkbox' && !source.is(":checked")) {
        value = '';
      }
    }

    console.log('animate?', animate);

    if ($(elm).attr('data-hide-if')) {
      if (this.valueMatch($(elm).attr('data-hide-if'), value)) {
        if (animate && $(elm).attr('data-showhide-animate') != 0) {
          $(elm).slideUp('fast');
        } else {
          $(elm).hide();
        }
      } else {
        if (animate && $(elm).attr('data-showhide-animate') != 0) {
          $(elm).slideDown('fast');
        } else {
          $(elm).show();
        }
      }
    } else if ($(elm).attr('data-show-if')) {
      if (this.valueMatch($(elm).attr('data-show-if'), value)) {
        if (animate && $(elm).attr('data-showhide-animate') != 0) {
          $(elm).slideDown('fast');
        } else {
          $(elm).show();
        }
      } else {
        if (animate && $(elm).attr('data-showhide-animate') != 0) {
          $(elm).slideUp('fast');
        } else {
          $(elm).hide();
        }
      }
    }
  },
  valueMatch: function valueMatch(rule, value) {
    // first, is check an array (i.e. does it have | separators)
    rule = rule.split('|'); // quick sweep for actual values:

    if (rule.indexOf(value) !== -1) {
      return true;
    } // null value matcher


    if (rule.indexOf('@null') !== -1 && value == '') {
      return true;
    } // not null matcher


    if (rule.indexOf('@notnull') !== -1 && value != '') {
      return true;
    }

    return false;
  }
};
$.widget('ascent.showhide', ShowHide);
$.extend($.ascent.ShowHide, {}); // $(document).ready(function() {

$(document).showhide(); // });

/* Assign this behaviour by link class */
// $(document).on('click', 'A.modalLink, A.modal-link', function(e) {
//     $(this).modalLink();
//     e.stopPropagation();
//     return false; // stop the link firing normally!
// });

/**
 * jQuery Cookie plugin
 *
 * Copyright (c) 2010 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 *
 * Customised by Kieran Metcalfe to add ability to set length of cookie in seconds as well as days
 *
 */

jQuery.cookie = function (key, value, options) {
  // key and at least value given, set cookie...
  if (arguments.length > 1 && String(value) !== "[object Object]") {
    options = jQuery.extend({}, options);

    if (value === null || value === undefined) {
      options.expires = -1;
    }

    if (typeof options.expires === 'number') {
      if (typeof options.expiretype === 'undefined') {
        options.expiretype = "days";
      }

      switch (options.expiretype) {
        case 'seconds':
          var sec = options.expires,
              t = options.expires = new Date();
          t.setSeconds(t.getSeconds() + sec);
          break;

        case 'minutes':
          var min = options.expires,
              t = options.expires = new Date();
          t.setMinutes(t.getMinutes() + min);
          break;

        default:
          var days = options.expires,
              t = options.expires = new Date();
          t.setDate(t.getDate() + days);
          break;
      }
    }

    value = String(value);
    return document.cookie = [encodeURIComponent(key), '=', options.raw ? value : encodeURIComponent(value), options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
    options.path ? '; path=' + options.path : '', options.domain ? '; domain=' + options.domain : '', options.secure ? '; secure' : ''].join('');
  } // key and possibly options given, get cookie...


  options = value || {};
  var result,
      decode = options.raw ? function (s) {
    return s;
  } : decodeURIComponent;
  return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
};
/**
* jquery.matchHeight-min.js v0.5.2
* http://brm.io/jquery-match-height/
* License: MIT
*/


(function (b) {
  b.fn.matchHeight = function (a) {
    if ("remove" === a) {
      var d = this;
      this.css("height", "");
      b.each(b.fn.matchHeight._groups, function (b, a) {
        a.elements = a.elements.not(d);
      });
      return this;
    }

    if (1 >= this.length) return this;
    a = "undefined" !== typeof a ? a : !0;

    b.fn.matchHeight._groups.push({
      elements: this,
      byRow: a
    });

    b.fn.matchHeight._apply(this, a);

    return this;
  };

  b.fn.matchHeight._apply = function (a, d) {
    var c = b(a),
        e = [c];
    d && (c.css({
      display: "block",
      "padding-top": "0",
      "padding-bottom": "0",
      "border-top-width": "0",
      "border-bottom-width": "0",
      height: "100px"
    }), e = k(c), c.css({
      display: "",
      "padding-top": "",
      "padding-bottom": "",
      "border-top-width": "",
      "border-bottom-width": "",
      height: ""
    }));
    b.each(e, function (a, c) {
      var d = b(c),
          e = 0;
      d.each(function () {
        var a = b(this);
        a.css({
          display: "block",
          height: ""
        });
        a.outerHeight(!1) > e && (e = a.outerHeight(!1));
        a.css({
          display: ""
        });
      });
      d.each(function () {
        var a = b(this),
            c = 0;
        "border-box" !== a.css("box-sizing") && (c += g(a.css("border-top-width")) + g(a.css("border-bottom-width")), c += g(a.css("padding-top")) + g(a.css("padding-bottom")));
        a.css("height", e - c);
      });
    });
    return this;
  };

  b.fn.matchHeight._applyDataApi = function () {
    var a = {};
    b("[data-match-height], [data-mh]").each(function () {
      var d = b(this),
          c = d.attr("data-match-height");
      a[c] = c in a ? a[c].add(d) : d;
    });
    b.each(a, function () {
      this.matchHeight(!0);
    });
  };

  b.fn.matchHeight._groups = [];
  b.fn.matchHeight._throttle = 80;
  var h = -1,
      f = -1;

  b.fn.matchHeight._update = function (a) {
    if (a && "resize" === a.type) {
      a = b(window).width();
      if (a === h) return;
      h = a;
    }

    -1 === f && (f = setTimeout(function () {
      b.each(b.fn.matchHeight._groups, function () {
        b.fn.matchHeight._apply(this.elements, this.byRow);
      });
      f = -1;
    }, b.fn.matchHeight._throttle));
  };

  b(b.fn.matchHeight._applyDataApi);
  b(window).bind("load resize orientationchange", b.fn.matchHeight._update);

  var k = function k(a) {
    var d = null,
        c = [];
    b(a).each(function () {
      var a = b(this),
          f = a.offset().top - g(a.css("margin-top")),
          h = 0 < c.length ? c[c.length - 1] : null;
      null === h ? c.push(a) : 1 >= Math.floor(Math.abs(d - f)) ? c[c.length - 1] = h.add(a) : c.push(a);
      d = f;
    });
    return c;
  },
      g = function g(a) {
    return parseFloat(a) || 0;
  };
})(jQuery);
