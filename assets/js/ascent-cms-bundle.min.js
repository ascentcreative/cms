function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

// ******
// Custom form component to enter & edit bible refs
// Expects incoming data from Laravel Eloquent
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2021
$.ascent = $.ascent ? $.ascent : {};
var AjaxUpload = {
  options: {
    disk: 'public',
    path: 'ajaxuploads',
    preserveFilename: false,
    placeholder: 'Choose file'
  },
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    var obj = this.element;
    upl = $(this.element).find('input[type="file"]');

    if ($(this.element).find('.ajaxupload-value').val() != '') {
      $(this.element).addClass('has-file');
    }

    $(this.element).find('.ajaxupload-reset').on('click', function () {
      self.reset();
    });
    upl.on('change', function () {
      var formData = new FormData();
      formData.append('payload', this.files[0]);
      formData.append('disk', self.options.disk);
      formData.append('path', self.options.path);
      formData.append('preserveFilename', self.options.preserveFilename ? 1 : 0);
      $.ajax({
        xhr: function xhr() {
          var xhr = new window.XMLHttpRequest(); //self.setUploadState();
          //Upload progress

          xhr.upload.addEventListener("progress", function (evt) {
            if (evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total * 100; //Do something with upload progress
              //prog.find('PROGRESS').attr('value', percentComplete);

              self.updateUI('Uploading...', percentComplete);
              console.log(percentComplete);
            }
          }, false);
          return xhr;
        },
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        url: "/cms/ajaxupload",
        data: formData
      }).done(function (data, xhr, requesr) {
        //Do something success-ish
        //$(obj).parents('FORM').unbind('submit', blocksubmit);
        //console.log(data);
        // $('INPUT[type=submit]').prop('disabled', false).val($('INPUT[type="submit"]').data('oldval')).css('opacity', 1);
        // prog.remove();
        // upl.remove();
        // self.updateUI(data.original_name + ' : Upload Complete', 0, 'value');
        //$(self.element).find('.ajaxupload-value').val(data.id);
        self.setValue(data.id, data.original_name);
        console.log(data);
        $(self.element).trigger('change'); //   var result = $.parseJSON(data);
        //   //console.log(result);
        //   if(result['result'] == 'OK') {
        //       obj.find('#' + self.fldName + '-filename').val(result['file']);
        //       self.setCompleteState();
        //   } else {
        //   }
      }).fail(function (data) {
        switch (data.status) {
          case 403:
            alert('You do not have permission to upload files'); //   self.updateUI('You do not have permission to upload files', 0, 'error');

            break;

          case 413:
            alert('The file is too large for the server to accept'); //self.updateUI('The file is too large for the server to accept', 0, 'error');

            break;

          default:
            alert('An unexpected error occurred'); //self.updateUI('An unexpected error occurred', 0, 'error');

            break;
        }
      });
    });
  },
  setValue: function setValue(value, text) {
    $(this.element).find('.ajaxupload-value').val(value);
    $(this.element).addClass('has-file');
    this.updateUI(text, 0);
  },
  reset: function reset() {
    $(this.element).find('.ajaxupload-value').val('');
    $(this.element).removeClass('has-file');
    this.updateUI(this.options.placeholder, 0);
    $(this.element).trigger('change');
  },
  updateUI: function updateUI(text) {
    var pct = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
    var bar = $(this.element).find('.ajaxupload-progress');
    console.log(bar);
    console.log(100 - pct + '%');
    bar.css('right', 100 - pct + '%');
    $(this.element).find('.ajaxupload-text').html(text);
  }
};
$.widget('ascent.ajaxupload', AjaxUpload);
$.extend($.ascent.AjaxUpload, {}); // ******
// Custom form component to enter & edit bible refs
// Expects incoming data from Laravel Eloquent
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2021

$.ascent = $.ascent ? $.ascent : {};
var AjaxUploadMulti = {
  options: {
    disk: 'public',
    path: 'ajaxuploads',
    preserveFilename: false,
    placeholder: 'Choose file',
    sortable: false
  },
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    var obj = this.element;
    console.log(this.options.data);

    for (file in this.options.data) {
      //$(this.element).ajaxuploadmultifile(this.options.data[file]);
      this.createFileBlock(this.options.data[file]);
    }

    upl = $(this.element).find('input[type="file"]');

    if ($(this.element).find('.ajaxupload-value').val() != '') {
      $(this.element).addClass('has-file');
    }

    upl.on('change', function () {
      // for each file selected, create a new uploader bar and show progress as it uploads.
      for (var iFile = 0; iFile < this.files.length; iFile++) {
        var item = self.createFileBlock();
        $(item).ajaxuploadmultifile('upload', this.files[iFile]);
      } //         template = $('template#ajaxuploadmulti-item');
      //         item = $(self.element).append(template.html());
      //         
      //     }

    });

    if (this.options.sortable) {
      $(this.element).sortable({
        update: function update(event, ui) {
          self.updateFileIndexes();
          ui.item.find('input').change();
        }
      });
    }
  },
  createFileBlock: function createFileBlock(data) {
    template = $('template#ajaxuploadmulti-item');
    item = $(template.html());
    $(this.element).append(item);
    $(item).ajaxuploadmultifile();

    if (data) {
      console.log('setting data');
      console.log(data);
      $(item).ajaxuploadmultifile('setValue', data.id, data.original_name);
    }

    this.updateFileIndexes();
    return item;
  },
  updateFileIndexes: function updateFileIndexes() {
    fldname = this.element.attr('name');
    $(this.element).find('.ajaxuploadmulti-ui').each(function (index) {
      var prefix = fldname + "[" + index + "]";
      $(this).find("input").each(function () {
        esc = fldname.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        re = new RegExp(esc + "\\[\\d+\\]");
        this.name = this.name.replace(re, prefix);
      });
    });
  }
};
$.widget('ascent.ajaxuploadmulti', AjaxUploadMulti);
$.extend($.ascent.AjaxUploadMulti, {});
var AjaxUploadMultiFile = {
  _init: function _init() {
    console.log("INIT FILE");
    console.log('this', this.element);
    var self = this;
    $(this.element).find('.ajaxupload-reset').on('click', function () {
      $(self.element).remove();
    });
  },
  setValue: function setValue(value, text) {
    console.log(value, text);
    $(this.element).find('.ajaxuploadmulti-id').val(value);
    $(this.element).find('.ajaxuploadmulti-label').val(text);
    $(this.element).addClass('has-file');
    this.updateUI(text, 0); // fire a change event

    $(this.element).find('.ajaxuploadmulti-label').change();
  },
  updateUI: function updateUI(text) {
    var pct = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
    var bar = $(this.element).find('.ajaxupload-progress');
    console.log(bar);
    console.log(100 - pct + '%');
    bar.css('right', 100 - pct + '%');
    $(this.element).find('.ajaxupload-text').html(text);
  },
  upload: function upload(file) {
    var self = this;
    var formData = new FormData();
    formData.append('payload', file);
    formData.append('disk', 'public'); //self.options.disk);

    formData.append('path', 'ajaxuploads'); //self.options.path);

    formData.append('preserveFilename', 1); //self.options.preserveFilename?1:0);

    $.ajax({
      xhr: function xhr() {
        var xhr = new window.XMLHttpRequest(); //self.setUploadState();
        //Upload progress

        xhr.upload.addEventListener("progress", function (evt) {
          if (evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total * 100; //Do something with upload progress
            //prog.find('PROGRESS').attr('value', percentComplete);

            self.updateUI('Uploading...', percentComplete);
            console.log(percentComplete);
          }
        }, false);
        return xhr;
      },
      cache: false,
      contentType: false,
      processData: false,
      type: 'POST',
      url: "/cms/ajaxupload",
      data: formData
    }).done(function (data, xhr, request) {
      //Do something success-ish
      //$(obj).parents('FORM').unbind('submit', blocksubmit);
      //console.log(data);
      // $('INPUT[type=submit]').prop('disabled', false).val($('INPUT[type="submit"]').data('oldval')).css('opacity', 1);
      // prog.remove();
      // upl.remove();
      // self.updateUI(data.original_name + ' : Upload Complete', 0, 'value');
      //$(self.element).find('.ajaxupload-value').val(data.id);
      self.setValue(data.id, data.original_name);
      console.log(data);
      $(self.element).trigger('change'); //   var result = $.parseJSON(data);
      //   //console.log(result);
      //   if(result['result'] == 'OK') {
      //       obj.find('#' + self.fldName + '-filename').val(result['file']);
      //       self.setCompleteState();
      //   } else {
      //   }
    }).fail(function (data) {
      switch (data.status) {
        case 403:
          alert('You do not have permission to upload files'); //   self.updateUI('You do not have permission to upload files', 0, 'error');

          break;

        case 413:
          alert('The file is too large for the server to accept'); //self.updateUI('The file is too large for the server to accept', 0, 'error');

          break;

        default:
          alert('An unexpected error occurred'); //self.updateUI('An unexpected error occurred', 0, 'error');

          break;
      }
    });
  }
};
$.widget('ascent.ajaxuploadmultifile', AjaxUploadMultiFile);
$.extend($.ascent.AjaxUploadMultiFile, {}); // ******
// Custom form component to enter & edit bible refs
// Expects incoming data from Laravel Eloquent
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2021

$.ascent = $.ascent ? $.ascent : {};
var BibleRefList = {
  rowCount: 0,
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    var obj = this.element; // build the basic UI
    // wrap the main element in a new DIV, transfer the ID and remove initial element.

    var outer = $('<div class="biblereflist p-3 bg-light border" style="xbackground: #eee"></div>');
    obj.wrap(outer);
    outer = obj.closest('.biblereflist');
    outer.attr('id', obj.attr('id'));
    this.element = outer;
    obj.remove(); // read in options and process

    var opts = self.options;

    if (opts.width) {
      if (typeof opts.width === 'string' && opts.width.slice(-1) == '%') {
        outer.css('width', opts.width);
      } else {
        outer.css('width', opts.width + 'px');
      }
    } else {
      outer.css('width', '600px');
    }

    if (!opts.placeholder) {
      opts.placeholder = '';
    } // create the UL and autocomplete fields


    $(outer).append('<UL class="biblereflist-list list-group pb-2"></UL>');
    $(outer).find(".biblereflist-list").append('<LI class="emptyDisp list-group-item border-0 bg-transparent">No items selected</LI>');
    $(outer).append('<DIV class="inputbar d-flex align-items-center"><INPUT type="text" id="' + thisID + '-input" class="flex-fill mr-2 form-control" spellcheck="false" placeholder="' + opts.placeholder + '"/><A href="#" id="' + thisID + '-addlink" class="btn-sm btn-primary">Add</A></DIV>');
    $('#' + thisID + '-input').keyup(function (e) {
      if (e.keyCode == 13) {
        self.submitBlock(this);
      }
    });
    console.log(opts.data); // create items for incoming data 

    for (item in opts.data) {
      self.createBlock('', item, opts.data[item].label, opts.data[item]);
    } // Add button and events


    $("#" + thisID + "-addlink").button({}).click(function (event) {
      self.submitBlock($("#" + thisID + "-input"));
      return false;
    });

    if (opts.allowItemDrag) {
      $("#" + thisID + " .biblereflist-list").sortable({
        axis: "y",
        connectWith: '#' + thisID + ' ul',
        containment: '#' + thisID,
        update: function update(event, ui) {
          opts.widget.updateData();
        },
        stop: function stop(event, ui) {}
      });
    }

    opts.widget = this;
  },
  submitBlock: function submitBlock(fld) {
    var self = this; // enter pressed:
    // submit reference for parsing

    $.get('/cms/bibleref/parse/' + $(fld).val(), function (data) {
      console.log(data); //var result = $.parseJSON(data);

      if (data['result'] == 'error') {
        alert(data['message']);
      } else if (data['result'] == 'ok') {
        self.createBlock('', '', '', data['data']);
        $(fld).val('');
      }
    });
  },
  createBlock: function createBlock(idLink, idModel, display, item) {
    console.log(idModel);
    console.log(item);
    var thisID = this.element[0].id;
    var fldName = thisID; //.split('-')[1];

    var widget = this.widget;
    idx = $("#" + thisID + " .biblereflist-list LI.link").length; // + 1;

    console.log(item);
    liStr = '<div class="biblereflist-item-label flex-fill">' + item.ref + '</div>';
    liStr += '<INPUT type="hidden" class="id" name="' + fldName + '[' + idx + '][ref]" value="' + item.ref + '">';
    liStr += '<INPUT type="hidden" class="id" name="' + fldName + '[' + idx + '][book]" value="' + item.book + '">';
    liStr += '<INPUT type="hidden" class="id" name="' + fldName + '[' + idx + '][startChapter]" value="' + item.startChapter + '">';
    liStr += '<INPUT type="hidden" class="id" name="' + fldName + '[' + idx + '][startVerse]" value="' + item.startVerse + '">';
    liStr += '<INPUT type="hidden" class="id" name="' + fldName + '[' + idx + '][endChapter]" value="' + item.endChapter + '">';
    liStr += '<INPUT type="hidden" class="id" name="' + fldName + '[' + idx + '][endVerse]" value="' + item.endVerse + '">'; // create fields for the various elements of the bible ref:
    //	liStr += '<INPUT type="hidden" class="BREAKME" name="' + fldName + '[' + idModel + '][breakme]" value="' + idx + '">';
    // the delete link for the item

    liStr += '<A href="#" class="deleteLink text-danger" tabindex="-1"><i class="bi-x-square-fill text-danger fs-1"/></A>';
    safeid = item.id; //.replace('~', '_');
    // add the created LI to the List

    $("#" + thisID + " .biblereflist-list").append('<LI class="link list-group-item border mb-2 d-flex justify-content-between align-items-center" id="' + safeid + '">' + liStr + '</LI>'); // if not already hidden, hide the placeholder 'No Items' element

    $("#" + thisID + " .biblereflist-list LI.emptyDisp").hide(); // Code the operation of the delete link:

    $("#" + thisID + " LI#" + safeid + " A.deleteLink").click(function (event) {
      pSrc = $(this).parents(".linklist");
      $(this).parents("LI.link").remove();

      if (pSrc.find("LI.link").length > 0) {
        pSrc.find("LI.emptyDisp").hide();
      } else {
        pSrc.find("LI.emptyDisp").show();
      }

      widget.updateData(); // call method to update the data in the widget (i.e. update sort indeces etc)

      return false;
    });
  },
  updateData: function updateData() {
    thisID = this.widget.element[0].id; // show or hide the 'No Items' block as needed by the amount of data in the widget

    if ($(this.widget.element).find("LI.link").length > 0) {
      $(this.widget.element).find("LI.emptyDisp").hide();
    } else {
      $(this.widget.element).find("LI.emptyDisp").show();
    } // update the sortFields (if specified) so the posted data records the order of the items


    if (this.options.sortField) {
      $(this.widget.element).find('LI.link').each(function (i) {
        $(this).find('.sortField').val(i);
      });
    }
  }
};
$.widget('ascent.biblereflist', BibleRefList);
$.extend($.ascent.BibleRefList, {}); // ******
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2021

$.ascent = $.ascent ? $.ascent : {};
var BlockSelect = {
  _init: function _init() {
    var self = this;
    self.trackOrder = [];
    this.element.addClass('initialised');
    console.log('init BlockSelect');
    $(this.element).off('change', self.processChange);
    $(this.element).on('change', '.cms-blockselect-option INPUT', {
      widget: self
    }, self.processChange);
    $(this.element).find('INPUT:checked').each(function () {
      $(this).parents('.cms-blockselect-option').addClass('selected');
      self.trackOrder.push($(this).attr('id'));
    });
  },
  setOptions: function setOptions($opts) {// replace the existing options with the provided array
  },
  processChange: function processChange(evt) {
    var self = evt.data.widget;

    if ($(this).is(':checked')) {
      $(this).parents('.cms-blockselect-option').addClass('selected');
      self.trackOrder.push($(this).attr('id'));

      if (self.element.data('max-select') != -1 && self.trackOrder.length > self.element.data('max-select')) {
        elm = self.trackOrder.shift();
        $('.cms-blockselect-option INPUT#' + elm).prop('checked', false).parents('.cms-blockselect-option').removeClass('selected');
      }
    } else {
      $(this).parents('.cms-blockselect-option').removeClass('selected');
      self.trackOrder.splice(self.trackOrder.indexOf($(this).attr('id')), 1);
    }
  }
};
$.widget('ascent.blockselect', BlockSelect);
$.extend($.ascent.BlockSelect, {}); // init on document ready

$(document).ready(function () {
  // alert('init blockselect');
  $('.cms-blockselect').not('.initialised').blockselect();
}); // make livewire compatible (check for init after DOM update)

document.addEventListener("DOMContentLoaded", function () {
  Livewire.hook('message.processed', function (message, component) {
    $('.cms-blockselect').not('.initialised').blockselect();
  });
}); // ******
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022

$.ascent = $.ascent ? $.ascent : {};
var ForeignKeySelectAutoComplete = {
  // Default options.
  options: {
    source: ''
  },
  _init: function _init() {
    var self = this;
    console.log(this.options.source);

    $(this.element).find('.fksac-input').autocomplete({
      source: this.options.source,
      // source: this.options.source,
      select: function select(ui, item) {
        self.setValue(item.item);
      }
    }).autocomplete('instance')._renderItem = function (ul, item) {
      if (item.formattedlabel) {
        return $("<li>").append(item.formattedlabel).appendTo(ul);
      } else {
        return $("<li>").append('<div>' + item.label + '<div>').appendTo(ul);
      }
    };

    $(this.element).on('click', '.fksac-clear', function () {
      self.setValue(null);
      return false;
    });
  },
  setValue: function setValue(item) {
    if (item) {
      $(this.element).find('.fksac-value').val(item.id);
      $(this.element).find('.fksac-label').html(item.label);
      $(this.element).addClass("has-value");
    } else {
      $(this.element).find('.fksac-value').val('');
      $(this.element).find('.fksac-input').val('');
      $(this.element).find('.fksac-label').html('');
      $(this.element).removeClass("has-value");
    }
  }
};
$.widget('ascent.foreignkeyselectautocomplete', ForeignKeySelectAutoComplete);
$.extend($.ascent.ForeignKeySelectAutoComplete, {});
$(document).ready(function () {// $('.cms-relatedtokens').relatedtokens();
}); // ******
// Form component to work with Eloquent HasMany relationships. 
// Expects routes (in Web.php) to handle creation modal and items. 
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2021

$.ascent = $.ascent ? $.ascent : {};
var HasMany = {
  rowCount: 0,
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    var obj = this.element;
    /**
     * Add New button click:
     */

    $(this.element).on('click', '.hasmany-add', function () {
      // .hasmany-add is coded in the blade as a simple modal-link which already knows its URL. 
      // We just need to capture the event of data being returned and handle that data
      $(document).on('modal-link-response', {
        hasmany: self
      }, self.appendItem);
    });
    /**
     * Catches all the dialog close events and removes the handlers for this widget
     * (Doesn't matter if it fires inbetween)
     * (Tried using one(), but this means the handlers don't get removed if the modal is cancelled)
     */

    $(document).on('hidden.bs.modal', '#ajaxModal', self.clearHandlers);
    /**
     * Edit an item row
     */

    $(this.element).on('click', '.hasmany-edititem', function () {
      // to work with the modal-link setup, we should serialise the item's data
      data = $(this).parents('.hasmany-item').find('INPUT, TEXTAREA').serialize(); // pull in the base URL from the .hasmany-add button

      url = $(this).parents('.hasmany').find('.hasmany-add').attr('href'); // and append the serialised data to it.

      $(this).attr('href', url + "?" + data); // ensure it's a modal link so that the edit screen pops up in a dialog.
      // the modalLink widget will handle the actual flow and creation of the modals

      $(this).addClass('modal-link'); // when we get a positive response from the modalLink, add in returned data

      $(document).on('modal-link-response', {
        hasmany: self
      }, self.replaceItem);
    });
    /**
     * Custom action hook, allowing a modal to be displayed and the calling item to be replaced
     * 
     * Passing in a 'blade' parameter will divert the edit action to a different modal UI
     *  - that modal UI can submit to a different route than the base one to avoid generic proccessing
     *  - but the custom route must render a new copy of the item blade to replace the existing one. 
     * 
     *  - the 'blade' parameter should be in the data-blade attribute of the calling link/button
     *       - blade file assumed to be in same directory as the item and modal blades
     * 
     */

    $(this.element).on('click', '.hasmany-item-action', function (e) {
      // to work with the modal-link setup, we should serialise the item's data
      data = $(this).parents('.hasmany-item').find('INPUT, TEXTAREA').serialize();
      data += '&blade=' + $(this).attr('data-blade'); // console.log(data);
      // e.preventDefault();
      // return false;
      // pull in the base URL from the .hasmany-add button

      url = $(this).parents('.hasmany').find('.hasmany-add').attr('href'); // and append the serialised data to it.

      $(this).attr('href', url + "?" + data); // alert('ok : ' + $(this).attr('href'));
      // ensure it's a modal link so that the edit screen pops up in a dialog.
      // the modalLink widget will handle the actual flow and creation of the modals

      $(this).addClass('modal-link'); // when we get a positive response from the modalLink, add in returned data

      $(document).on('modal-link-response', {
        hasmany: self
      }, self.replaceItem);
    });
    /**
    * Removes an item block from the component
    */

    $(this.element).on('click', '.hasmany-removeitem', function (e) {
      e.preventDefault();

      if (confirm("Remove this item?")) {
        $(this).parents('.hasmany-item').remove();
        self.updateIndexes();
      }
    });
    this.updateIndexes();
  },

  /**
   * Create a new item in the field's item list (from the HTML returned in the event)
   * @param {*} e - The event
   */
  appendItem: function appendItem(e) {
    $(e.data.hasmany.element).find('.hasmany-items').append(e.response);
    e.data.hasmany.updateIndexes();
  },

  /**
   * Replace an item in the field's item list with the HTML returned in the event. 
   * The index of the item to replace should be in the HTML.
   * @param {*} e - The event
   */
  replaceItem: function replaceItem(e) {
    elm = $(e.response);
    idx = elm.data('idx');
    $($(e.data.hasmany.element).find('.hasmany-item')[idx]).replaceWith(elm);
    e.data.hasmany.updateIndexes();
  },

  /**
   * Remove the event handlers - the modal has closed, so we mustn't listen for events any longer
   * Any events received may have come from other fields.
   */
  clearHandlers: function clearHandlers() {
    $(document).off('modal-link-response', self.appendItem);
    $(document).off('modal-link-response', self.replaceItem);
  },
  updateIndexes: function updateIndexes() {
    // console.log('update');
    //  alert('update');
    fldname = $(this.element).data('fieldname');
    $(this.element).find('.hasmany-item').each(function (idx) {
      var prefix = fldname + "[" + idx + "]"; // console.log(prefix);

      $(this).find('INPUT, TEXTAREA').each(function (fldidx) {
        esc = fldname.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        re = new RegExp(esc + "\\[\\d+\\]");
        this.name = this.name.replace(re, prefix);
      });
    });
  }
};
$.widget('ascent.hasmany', HasMany);
$.extend($.ascent.HasMany, {}); // ******
// Custom form component to enter & edit pivot records
// Expects incoming Pivot Table data from Laravel Eloquent
// Allows for setting of fields on the Pivot Record:
// - AddToAll - A field name and fixed value. Used when a siingle pivot table differentiates between different types (i.e. a role type where a single pivot may record different roles)
// - PivotField - An editable field value to collect for each pivot row
// - SortField - Captures the sort order of the pivot rows
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2020

$.ascent = $.ascent ? $.ascent : {};
var PivotList = {
  rowCount: 0,
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    var obj = this.element; // build the basic UI
    // wrap the main element in a new DIV, transfer the ID and remove initial element.

    var outer = $('<div class="pivotlist p-3 bg-light border" style="xbackground: #eee"></div>');
    obj.wrap(outer);
    outer = obj.closest('.pivotlist');
    outer.attr('id', obj.attr('id'));
    outer.attr('name', obj.attr('name'));
    this.element = outer;
    obj.remove(); // read in options and process

    var opts = self.options;

    if (opts.width) {
      if (typeof opts.width === 'string' && opts.width.slice(-1) == '%') {
        outer.css('width', opts.width);
      } else {
        outer.css('width', opts.width + 'px');
      }
    } else {
      outer.css('max-width', '600px');
    }

    if (!opts.placeholder) {
      opts.placeholder = '';
    } // create the UL and autocomplete fields


    $(outer).append('<UL class="pivotlist-list list-group pb-2"></UL>');
    $(outer).find(".pivotlist-list").append('<LI class="emptyDisp list-group-item border-0 bg-transparent">No items selected</LI>'); // ** temp removal of 'add' button as it does nothing! ** //
    // $(outer).append('<DIV class="inputbar d-flex align-items-center"><INPUT type="text" id="' + thisID + '-input" class="flex-fill mr-2 form-control" spellcheck="false" placeholder="' + opts.placeholder + '"/><A href="#" id="' + thisID + '-addlink" class="btn-sm btn-primary">Add</A></DIV>');

    $(outer).append('<DIV class="inputbar d-flex align-items-center"><INPUT type="text" id="' + thisID + '-input" class="flex-fill mr-2 form-control" spellcheck="false" placeholder="' + opts.placeholder + '"/></DIV>'); // url building:

    var urlsep = '?';

    if (opts.optionRoute.indexOf('?') != -1) {
      urlsep = '&';
    } // autocomplete and events


    $("#" + thisID + "-input").autocomplete({
      source: opts.optionRoute + urlsep + 'return_field=' + self.options.labelField,
      //opts.autocompleteURL,
      minLength: 2,
      select: function select(event, ui) {
        // console.log(self);
        lblfld = self.options.labelField; // console.log(ui);

        if ($("#" + thisID + " #" + ui.item.id).length > 0) {
          // check for duplicates (across all source fields)
          alert("That item has already been added.");
        } else {
          if (ui.item.id == 'create' && opts.storeRoute) {
            // fire off a request to create the new term.
            // alert(ui.item.term);
            $.ajax({
              type: 'POST',
              url: opts.storeRoute,
              data: _defineProperty({}, lblfld, ui.item.term),
              headers: {
                'Accept': "application/json"
              }
            }).done(function (data, xhr, request) {
              //   console.log(data);  
              //  alert(data.id);
              ui.item.id = data.id;
              ui.item.label = data[self.options.labelField]; //theme;

              self.createBlock('', ui.item.id, ui.item.label, ui.item);
              $("#" + thisID + "-input").val('');
            });
          } else {
            self.createBlock('', ui.item.id, ui.item.label, ui.item);
            $("#" + thisID + "-input").val('');
          }
        }

        return false;
      }
    }).autocomplete('instance')._renderItem = function (ul, item) {
      // console.log(item);
      //return $( "<li>" ).append( renderItem(item) ).appendTo( ul );
      if (item.formattedlabel) {
        return $("<li>").append(item.formattedlabel).appendTo(ul);
      } else {
        return $("<li>").append('<div>' + item.label + '<div>').appendTo(ul);
      }
    };

    ;
    $("#" + thisID + "-input").keypress(function () {
      $("#" + thisID + "-input").removeData();
    }); // Add button and events

    $("#" + thisID + "-addlink").button({}).click(function (event) {
      var sel = $("#" + thisID + "-input").data();

      if (sel['display']) {
        if ($("#" + thisID + " #" + sel['idModel']).length > 0) {
          // check for duplicates (across all source fields)
          alert("That item has already been added.");
        } else {
          // add block to current source field
          self.createBlock('', sel['idModel'], sel['display']);
          $("#" + thisID + "-input").removeData();
          $("#" + thisID + "-input")[0].value = "";
        }
      } else {
        alert('Nothing Selected');
      }

      return false;
    }); // create items for incoming data 

    for (item in opts.data) {
      self.createBlock('', item, opts.data[item].label, opts.data[item]);
    }

    if (opts.allowItemDrag) {
      $("#" + thisID + " .pivotlist-list").sortable({
        axis: "y",
        connectWith: '#' + thisID + ' ul',
        containment: '#' + thisID,
        update: function update(event, ui) {
          opts.widget.updateData();
        },
        stop: function stop(event, ui) {}
      });
    }

    opts.widget = this;
  },
  createBlock: function createBlock(idLink, idModel, display, item) {
    // console.log(idModel);
    // console.log(item);
    var thisID = this.element[0].id;
    var thisName = this.element.attr('name'); // console.log(thisName);

    var fldName = thisID; //.split('-')[1];

    var widget = this.widget;
    idx = $("#" + thisID + " .pivotlist-list LI.link").length; // + 1;

    liStr = '<div class="pivotlist-item-label flex-fill">' + display + '</div>';
    liStr += '<INPUT type="hidden" class="id" name="' + thisName + '[' + item.id + ']" value="' + item.id + '">'; // write in any set values for the pivot table

    for (key in this.options.addToAll) {
      liStr += '<INPUT type="hidden" class="ata-' + key + '" name="' + thisName + '[' + item.id + '][' + key + ']" value="' + this.options.addToAll[key] + '">';
    } // if a pivot table sort field is set, create the field


    if (this.options.sortField) {
      liStr += '<INPUT type="hidden" class="sortField" name="' + thisName + '[' + item.id + '][' + this.options.sortField + ']" value="' + idx + '">';
    } //	liStr += '<INPUT type="hidden" class="BREAKME" name="' + fldName + '[' + idModel + '][breakme]" value="' + idx + '">';
    // pivotField is a user-editable field on the pivot table.
    // if set, this displays a text field on the pivot row which can be given a value. Also reads the incoming value from the data.


    if (this.options.pivotField) {
      var pivotval = item[this.options.pivotField] != null ? item[this.options.pivotField] : '';
      liStr += '<div class="pivotlist-pivotfieldwrap form-inline">';

      if (this.options.pivotFieldLabel) {
        liStr += '<label class="mr-2">' + this.options.pivotFieldLabel + '</label>';
      }

      liStr += '<INPUT type="text" class="pivotField form-control w-25" placeholder="' + this.options.pivotFieldPlaceholder + '" name="' + thisName + '[' + item.id + '][' + this.options.pivotField + ']" value="' + pivotval + '">';
      liStr += '</div>';
    } // the delete link for the item


    liStr += '<A href="#" class="deleteLink text-danger" tabindex="-1"><i class="bi-x-square-fill text-danger fs-1"/></A>';
    safeid = item.id; //.replace('~', '_');
    // add the created LI to the List

    $("#" + thisID + " .pivotlist-list").append('<LI class="link list-group-item border mb-2 d-flex justify-content-between align-items-center" id="' + safeid + '">' + liStr + '</LI>'); // if not already hidden, hide the placeholder 'No Items' element

    $("#" + thisID + " .pivotlist-list LI.emptyDisp").hide(); // Code the operation of the delete link:

    $("#" + thisID + " LI#" + safeid + " A.deleteLink").click(function (event) {
      pSrc = $(this).parents(".linklist");
      $(this).parents("LI.link").remove();

      if (pSrc.find("LI.link").length > 0) {
        pSrc.find("LI.emptyDisp").hide();
      } else {
        pSrc.find("LI.emptyDisp").show();
      }

      widget.updateData(); // call method to update the data in the widget (i.e. update sort indeces etc)

      return false;
    });
  },
  updateData: function updateData() {
    thisID = this.widget.element[0].id; // show or hide the 'No Items' block as needed by the amount of data in the widget

    if ($(this.widget.element).find("LI.link").length > 0) {
      $(this.widget.element).find("LI.emptyDisp").hide();
    } else {
      $(this.widget.element).find("LI.emptyDisp").show();
    } // update the sortFields (if specified) so the posted data records the order of the items


    if (this.options.sortField) {
      $(this.widget.element).find('LI.link').each(function (i) {
        $(this).find('.sortField').val(i);
      });
    }
  }
};
$.widget('ascent.pivotlist', PivotList);
$.extend($.ascent.PivotList, {}); // ******
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2021

$.ascent = $.ascent ? $.ascent : {};
var RelatedTokens = {
  // Default options.
  options: {
    fieldName: 'tags',
    tokenName: 'tag'
  },
  _init: function _init() {
    var self = this;
    console.log(this.element.data());
    val = this.element.data('tokens'); //this.element.val('');

    this.element.wrap('<DIV class="cms-relatedtokens"></DIV>');
    this.element = this.element.parents('.cms-relatedtokens');
    this.element.prepend('<div class="rt_tokens"></div>');

    for ($iTkn = 0; $iTkn < val.length; $iTkn++) {
      this.addToken(val[$iTkn][this.options.tokenName], val[$iTkn]['id']);
    }

    this.element.on('click', 'A.rt_remove', function () {
      $(this).parents('.rt_token').remove();
    });
    this.element.find("INPUT[type=text]").on('keydown', function (e) {
      console.log(e.which);
      var breaks = [9, 13, 188];

      if (breaks.includes(e.which)) {
        self.addToken($(this).val());
        $(this).val('');
        e.preventDefault();
      }
    }); // this.addToken('test new');
    // this.addToken('Tag 2', 2);
  },
  addToken: function addToken(label) {
    var id = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
    var idx = this.element.find('.rt_token').length; // this.element.find('.rt_tokens').append('<div class="rt_token">' + label + '<input type="text" name="tags[' + idx + '][tag]" value="' + label + '"><input type="text" name="tags[' + idx + '][id]" value="' + id + '"></div>');

    this.element.find('.rt_tokens').append('<div class="rt_token">' + label + '<input type="hidden" name="' + this.options.fieldName + '[][' + this.options.tokenName + ']" value="' + label + '"><A href="#delete-token" class="bi-x-square-fill text-danger rt_remove"></A></div>');
  }
};
$.widget('ascent.relatedtokens', RelatedTokens);
$.extend($.ascent.RelatedTokens, {});
$(document).ready(function () {// $('.cms-relatedtokens').relatedtokens();
}); // ******
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022

$.ascent = $.ascent ? $.ascent : {};
var RelationshipAutocomplete = {
  // Default options.
  options: {
    source: '',
    displayField: ''
  },
  _init: function _init() {
    var self = this; // console.log(this.options.source);

    $(this.element).find('.ra-input').autocomplete({
      source: this.options.source,
      select: function select(ui, item) {
        self.setValue(item.item);
      }
    }).autocomplete('instance')._renderItem = function (ul, item) {
      if (item.formattedlabel) {
        return $("<li>").append(item.formattedlabel).appendTo(ul);
      } else {
        return $("<li>").append('<div>' + item.label + '<div>').appendTo(ul);
      }
    };

    $(this.element).on('click', '.ra-clear', function () {
      self.setValue(null);
      return false;
    });
  },
  setValue: function setValue(item) {
    if (item) {
      var display = item[this.options.displayField];

      if (!display) {
        display = item.label;
      }

      $(this.element).find('.ra-value').val(item.id);
      $(this.element).find('.ra-label').html(display);
      $(this.element).addClass("has-value");
    } else {
      $(this.element).find('.ra-value').val('');
      $(this.element).find('.ra-input').val('');
      $(this.element).find('.ra-label').html('');
      $(this.element).removeClass("has-value");
    }
  }
};
$.widget('ascent.relationshipautocomplete', RelationshipAutocomplete);
$.extend($.ascent.RelationshipAutocomplete, {});
$(document).ready(function () {// $('.cms-relatedtokens').relatedtokens();
}); // ******
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2021

$.ascent = $.ascent ? $.ascent : {}; // fix for sometimes null sender... set in 'over', unset in 'stop'

var sender = null;
var StackBlockEdit = {
  itemCount: 0,
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    var obj = this.element; //console.log('block edit init');

    $(this.element).on('click', 'A.blockitem-delete', function () {
      if (confirm("Delete this item?")) {
        var row = $(this).parents('.items');
        $(this).parents('.blockitem').remove();
        $(row).trigger('change');
        self.updateBlockIndexes();
      }

      return false;
    });
    $(this.element).find('.items').sortable({
      connectWith: '.items',
      //containment: '.stack-edit',
      handle: '.blockitem-handle',
      // axis: 'x',
      forcePlaceholderSize: true,
      xevert: 100,
      start: function start(event, ui) {
        $(ui.placeholder).css('height', $(ui.item).height() + 'px');
        sender = this;
      },
      over: function over(event, ui) {
        console.log('over'); // will it fit? 

        empty = self.getEmptyCount();

        if (sender == this) {
          empty += parseInt($(ui.item).find('.item-col-count').val());
        }

        if (parseInt($(ui.item).find('.item-col-count').val()) <= empty) {
          // ok
          //self.updateBlockIndexes();
          $(ui.placeholder).show();
        } else {
          // alert('Too Big - No Space');
          $(this).addClass('drop-not-allowed');
          $(ui.placeholder).hide();
        }
      },
      out: function out(event, ui) {
        $(this).removeClass('drop-not-allowed');
      },
      receive: function receive(event, ui) {
        console.log('receive'); // receiving an item from another list:
        // will it fit? 

        empty = self.getEmptyCount(); // at this point, the size of the dropped element is included...

        empty += parseInt($(ui.item).find('.item-col-count').val());

        if (parseInt($(ui.item).find('.item-col-count').val()) <= empty) {
          // ok
          self.updateBlockIndexes();
        } else {
          // alert('Too Big - No Space');
          $(ui.sender).sortable('cancel');
        }
      },
      remove: function remove(event, ui) {
        console.log('remove');
        self.updateBlockIndexes();
      },
      update: function update(event, ui) {
        console.log('update');
        self.updateBlockIndexes();
      },
      stop: function stop(event, ui) {
        console.log('stop'); // if ($(ui.item).hasClass('number') && $(ui.placeholder).parent()[0] != this) {
        //  $(this).sortable('cancel');
        //}

        sender = null;
      }
    });
    $(this.element).find('.blockitem').each(function () {
      self.initBlockItem(this);
    }); // ITEM ADD buttons:

    $(this.element).on('click', 'A.block-add-item-text', function () {
      self.loadBlockTemplate('text');
      $(this).closest('.show').removeClass('show');
      return false;
    });
    $(this.element).on('click', 'A.block-add-item-image', function () {
      self.loadBlockTemplate('image');
      $(this).closest('.show').removeClass('show');
      return false;
    });
    $(this.element).on('click', 'A.block-add-item-video', function () {
      self.loadBlockTemplate('video');
      $(this).closest('.show').removeClass('show');
      return false;
    });
  },
  getEmptyCount: function getEmptyCount() {
    var empty = 12;
    $(this.element).find('.item-col-count').each(function () {
      empty -= parseInt($(this).val());
    });
    return empty;
  },
  loadBlockTemplate: function loadBlockTemplate(type) {
    // check there's room
    var empty = 12;
    $(this.element).find(".item-col-count").each(function () {
      empty -= parseInt($(this).val());
    });

    if (empty < 1) {
      alert('This row is full - resize the other elements to make room, or add a new row block');
      return false;
    }

    var self = this;
    stackname = $(this.element).parents('.stack-edit').attr('id');
    blockid = $(this.element).parent().children().index(this.element);
    itemid = $(this.element).find('.blockitem').length;
    blockname = stackname + "[" + blockid + "][items][" + itemid + "]";
    console.log(blockname);
    $.get('/admin/stackblock/newitem/' + type + "/" + blockname + "/" + empty, function (data) {
      // $(self.element).find('.stack-output').before(data);
      var newItem = $(data);
      $(self.element).find('.items').append(newItem);
      console.log(newItem);
      self.initBlockItem(newItem);
      self.updateBlockIndexes();
    });
  },
  updateBlockIndexes: function updateBlockIndexes() {
    // console.log('UBI - Block');
    if ($(this.element).find('.blockitem').length == 0) {
      $(this.element).find('.placeholder').show();
    } else {
      $(this.element).find('.placeholder').hide();
    }

    var self = this; // reapply field indexes to represent reordering

    $(this.element).find('.blockitem').each(function (idx) {
      $(this).find('INPUT:not([type=file]), SELECT, TEXTAREA').each(function (fldidx) {
        var ary = $(this).attr('name').split(/(\[|\])/); // console.log(ary);
        // we're allowing drops from other blocks, so need to update ary[2] also...

        blockidx = $(self.element).parent().children('.block-edit').index(self.element); // console.log('BLockIdx : ' + blockidx);

        ary[2] = blockidx;
        ary[10] = idx;
        $(this).attr('name', ary.join(''));
        $(this).change(); // $('#frm_edit').addClass('dirty'); //trigger('checkform.areYouSure');
      });
    });
  },
  initBlockItem: function initBlockItem(item) {
    $(item).resizable({
      handles: 'e',
      placeholder: 'ui-state-highlight',
      create: function create(event, ui) {
        // Prefers an another cursor with two arrows
        $(".ui-resizable-handle").css("cursor", "ew-resize");
      },
      start: function start(event, ui) {
        // sibTotalWidth = ui.originalSize.width + ui.originalElement.next().outerWidth();
        console.log(ui.size);
        var colcount = 12; // change this to alter the number of cols in the row.

        var colsize = $(ui.element).parents('.items').width() / colcount; // set the grid correctly - allows for window to be resized bewteen...

        $(ui.element).resizable('option', 'grid', [colsize, 0]); // min width = 3 cols

        $(ui.element).resizable('option', 'minWidth', colsize * 3 - 1);
        /**
         * old code - fixed items to a single row. 
         */
        // calc the max possible width for this item (to prevent dragging larger than the row)
        // get the col counts of items in the row

        var filled = 0;
        $(ui.element).parents('.items').find('.blockitem').each(function () {
          filled += parseInt($(this).find('.item-col-count').val());
          console.log(filled);
        }); // subtract the col count of this item

        filled -= $(ui.element).find('.item-col-count').val(); // the difference is the max number of cols this can fill

        empty = colcount - filled;
        console.log(empty); // multiply to get a total max width.

        $(ui.element).resizable('option', 'maxWidth', colsize * (colcount - filled));
        /** new code - just set max to row width. **/
        //$(ui.element).resizable('option', 'maxWidth', $(ui.element).parents('.items').width());
      },
      resize: function resize(event, ui) {
        console.log(ui.size.width + " :: " + $(ui.element).parents('.items').width()); // calculate the number of cols currently occupied and write to the col-count field

        cols = ui.size.width / $(ui.element).parents('.items').width() * 12; // need to pull this from the same parameter as in 'start' - should probably widgetise this code...

        console.log(Math.round(cols));
        $(ui.element).find('.item-col-count').val(Math.round(cols));
      },
      stop: function stop(event, ui) {
        //$(ui.element).css('width', $(ui.element).width() + 'px');
        var pct = $(ui.element).width() / $(ui.element).parents('.items').width() * 100;
        $(ui.element).css('width', pct + '%');
        $(ui.element).trigger('change');
      }
    });
  }
};
$.widget('ascent.stackblockedit', StackBlockEdit);
$.extend($.ascent.StackBlockEdit, {}); // ******
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2021

$.ascent = $.ascent ? $.ascent : {};
var StackEdit = {
  rowCount: 0,
  _init: function _init() {
    var self = this;
    this.widget = this;
    idAry = this.element[0].id.split('-');
    var thisID = this.element[0].id;
    var fldName = idAry[1];
    var obj = this.element; // make the stack sortable (drag & drop)

    $(this.element).find('.stack-blocks').sortable({
      axis: 'y',
      handle: '.block-handle',
      start: function start(event, ui) {
        $(ui.placeholder).css('height', $(ui.item).height() + 'px');
      },
      update: function update(event, ui) {
        self.updateBlockIndexes();
      }
    }); //capture the submit event of the form to serialise the stack data

    $(this.element).parents('form').on('submit', function () {
      self.serialise();
    });
    $(this.element).on('change', function () {
      self.serialise();
    });
    $(this.element).on('click', '.block-delete', function () {
      console.log('delete me');

      if (confirm("Delete this block?")) {
        $(this).parents('.block-edit').remove();
        self.updateBlockIndexes();
      }

      return false;
    }); // capture the click event of the add block button
    // (test for now - adds a new row block. Will need to be coded to ask user what block to add)

    $(this.element).find('.stack-add-block').on('click', function () {
      //var type = 'row';\
      var type = $(this).attr('data-block-type');
      var field = $(this).attr('data-block-field'); //'content';

      var idx = $(self.element).find('.block-edit').length; //    alert(idx);

      $.get('/admin/stackblock/make/' + type + '/' + field + '/' + idx, function (data) {
        // $(self.element).find('.stack-output').before(data);
        $(self.element).find('.stack-blocks').append(data);
        self.updateBlockIndexes();
      }); //   alert('hide...');

      $('.btn.dropdown-toggle').dropdown('hide');
      return false;
    });
    this.serialise();
  },
  serialise: function serialise() {
    var data = $(this.element).find('INPUT, SELECT, TEXTAREA').not('.stack-output').serializeJSON(); // console.log(data);
    //  return false;
    // remove the top level wrapper (which is just the field name):

    for (fld in data) {
      $(this.element).find('.stack-output').val(JSON.stringify(data[fld]));
    }
  },
  updateBlockIndexes: function updateBlockIndexes() {
    // console.log('UBI - Stack');
    // console.log($(this.element).find('.block-edit'));
    // reapply field indexes to represent reordering
    $(this.element).find('.block-edit').each(function (idx) {
      $(this).find('INPUT:not([type=file]), SELECT, TEXTAREA').each(function (fldidx) {
        //   console.log(idx + " vs " + fldidx);
        if ($(this).attr('name') != undefined && $(this).attr('name').indexOf('[')) {
          var ary = $(this).attr('name').split(/(\[|\])/);
          ary[2] = idx;
          $(this).attr('name', ary.join(''));
          $(this).change();
        } // $('#frm_edit').addClass('dirty'); //trigger('checkform.areYouSure');

      });
    });
  }
};
$.widget('ascent.stackedit', StackEdit);
$.extend($.ascent.StackEdit, {});
