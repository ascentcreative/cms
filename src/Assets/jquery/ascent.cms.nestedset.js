$.ascent = $.ascent?$.ascent:{};

var NestedSet = {
        
    self: null,
   
    _init: function () {
        
        var self = this;
        this.widget = this;
        var thisID = (this.element)[0].id;
        obj = this.element;

        //self = this;
        obj.addClass("nestedset");

       /// alert('init NS');
       
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
        $(obj).find('INPUT.ns_relationlabel').remove();

        // don't set any options in the relation field - scopeChange does that based on the selected scope.
        $(obj).find('.ns_relate').append('<SELECT style="flex: 0 0 77%" class="ns_relationselect form-control" name="' + this.options.relationFieldName + '"><OPTION value="">Please Select:</OPTION></SELECT>');


         // init scopes (need to do this after the relation fields so they're in place to receive values)
        $(obj).find(".ns_scope").append('<SELECT class="ns_scopeselect form-control" name="' + this.options.scopeFieldName + '"><OPTION value="">' + this.options.nullScopeLabel + '</OPTION></SELECT>');

        for(idx in this.options.scopeData) {
            item = this.options.scopeData[idx];
            $(obj).find('SELECT.ns_scopeselect').append('<OPTION value="' + item['id'] + '">' + item['title'] + '</OPTION>');
        }
        
        $(obj).find('SELECT.ns_scopeselect').val(this.options.scopeVal).on("change", this.scopeChange).trigger('change');
        $(obj).find('INPUT.ns_scopefield').remove();
  

        // init relations:
        // console.log('done INIT');
       
       
    },

    scopeChange: function() {

        console.log('scope change...');
        console.log(this);
        scope = $(this).val();
        widget = $(this).parents('.nestedset').nestedset('instance');
        obj = widget.element;
        console.log(widget);

        console.log(widget.options.relationFieldName);

       // console.log($(obj).nestedset());
        $(obj).find('.ns_relate SELECT.ns_relationselect OPTION[value!=""]').remove();

        //alert(scope);
        if (scope == '') {
            // no scope, so no values
            $(obj).find('.ns_relate').hide();
            $(obj).find('.ns_relate SELECT').val('');
         
        } else {
            $(obj).find('.ns_relate').show();
            // add in the options for the relation data 
            opts = widget.traverse(widget.options.nestedSetData , scope).join('');
            
            $(obj).find('SELECT.ns_relationselect').append( opts ); //widget.traverse(widget.options.nestedSetData , scope).join('') ) ;

            if (widget.options.relationVal != '') {
                $(obj).find('SELECT.ns_relationselect').val(widget.options.relationVal);
                widget.options.relationVal = '';
            } else {
                console.log('fwefe');
                $(obj).find('SELECT.ns_relationselect').val('');
            }
            //$(console.log(widget.traverse(widget.options.nestedSetData , scope));
        }

    }, 

    traverse: function(nodes, scope, depth=0) {

        var opts = [];
        for(node in nodes) {
            if(nodes[node].menu_id == scope) {
               // console.log(depth + ': ' + nodes[node]);
                label = ('-'.repeat(depth)) + " " + nodes[node][this.options.relationLabel];

                opts.push('<OPTION value="' + nodes[node]['id'] + '">' + label.trim() + '</OPTION>');
                children = this.traverse(nodes[node].children, scope, depth+1);
                for(var i = 0; i < children.length; i++) {
                    opts.push(children[i]);
                }
            }
        }
        return opts;
    }

}

$.widget('ascent.nestedset', NestedSet);
$.extend($.ascent.NestedSet, {
		 
		
}); 
