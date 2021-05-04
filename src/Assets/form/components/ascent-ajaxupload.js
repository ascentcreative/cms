// ******
// Custom form component to enter & edit bible refs
// Expects incoming data from Laravel Eloquent
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2021


$.ascent = $.ascent?$.ascent:{};

var AjaxUpload = {
        
    
    _init: function () {
        
        var self = this;
        this.widget = this;
        
        idAry = (this.element)[0].id.split('-');
        
        var thisID = (this.element)[0].id;
        
        var fldName = idAry[1];
        
        var obj = this.element;
        
        
        upl = $(this.element).find('input[type="file"]');

        console.log(upl);

        upl.on('change', function() {
           
            var formData = new FormData(); 
            formData.append('payload', this.files[0]); 

            $.ajax({
                xhr: function()
                {
                    
                  var xhr = new window.XMLHttpRequest();
                  
                  //self.setUploadState();
                  //Upload progress
                  xhr.upload.addEventListener("progress", function(evt){
                
                    if (evt.lengthComputable) {
                      var percentComplete = (evt.loaded / evt.total) * 100;
                      //Do something with upload progress
                      //prog.find('PROGRESS').attr('value', percentComplete);
                      self.updateProgress(percentComplete);
                      console.log(percentComplete);

                    }
                  }, false);
                  return xhr;
                },cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                url: "/cms/ajaxupload",
                data: formData
              }).done(function(data, xhr, requesr){

                    
                    //Do something success-ish
                      //$(obj).parents('FORM').unbind('submit', blocksubmit);
                      //console.log(data);
                     // $('INPUT[type=submit]').prop('disabled', false).val($('INPUT[type="submit"]').data('oldval')).css('opacity', 1);
                     // prog.remove();
                     // upl.remove();

                    self.updateUI(data.original_name + ' : Upload Complete', 0, false);
                    $(self.element).find('.ajaxupload-value').val(data.id);

                    console.log(data);

                    //   var result = $.parseJSON(data);
                    //   //console.log(result);
                    //   if(result['result'] == 'OK') {
                    //       obj.find('#' + self.fldName + '-filename').val(result['file']);
                    //       self.setCompleteState();
                    //   } else {
                          
                    //   }

                      
                      
                  
              }).fail(function (data) {

                switch(data.status) {
                    case 403:
                       // alert('You do not have permission to upload files');

                        self.updateUI('You do not have permission to upload files', 0, true);

                        break;

                    case 413:
                        //alert('The file is too large for the server to accept');
                        self.updateUI('The file is too large for the server to accept', 0, true);
                        break;

                    default:
                        //alert('An unexpected error occurred');
                        self.updateUI('An unexpected error occurred', 0, true);
                        break;
                }

              });
          

        });
        
        

    },

    updateUI: function(text, pct=0, error=false) {

        if(error) {
            $(this.element).addClass('alert-danger');
        } else {
            $(this.element).removeClass('alert-danger');
        }

        var bar = $(this.element).find('.ajaxupload-progress');
        console.log(bar);
        console.log( (100 - pct) + '%');
        bar.css('right', (100 - pct) + '%');

        $(this.element).find('.ajaxupload-text').html(text);

    },

    updateProgress: function(pct) {

        var bar = $(this.element).find('.ajaxupload-progress');
        console.log(bar);
        console.log( (100 - pct) + '%');
        bar.css('right', (100 - pct) + '%');

    }

}

$.widget('ascent.ajaxupload', AjaxUpload);
$.extend($.ascent.AjaxUpload, {
		 
		
}); 