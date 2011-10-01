var ls = ls || {};

ls.category = (function ($) {

    this.edit = function (sId, sParentId, sTitle, sUrl) {
	$('#e_category_id').val(sId);
	$('#edit-category').val(sParentId);
	$('#e_category_title').val(sTitle);
	$('#e_category_url').val(sUrl);
	$('#window_edit_form_null').show();
    }
    
    this.hide = function () {
	$('#window_edit_form_null').hide(); 
    }
    
//    this.del = function (id) {
//	ls.ajax(aRouter['settings']+'adunits/ajaxdeleteadunits/',{
//	    adunitsid:id
//	},function(result) {
//	    if (result.bStateError) {
//		ls.msg.error(null, result.sMsg);
//	    } else {
//		ls.msg.notice(null, result.sMsg);
//		document.getElementById('au_'+id).innerHTML = 'Удалено';
//		document.getElementById('au_'+id).style.backgroundColor = '#FFC6C6';
//	    }
//	});
//    }
    
    this.save = function (sType) {
	thisObj = this;
	formObj = $('#form_category');
	thisObj.showProgress($('#block-category'));
	ls.ajax(aRouter['settings']+'category/ajaxaddcategory/',formObj.serializeJSON(),function(result) {
	    if (result.bStateError) {
		ls.msg.error(null, result.sMsg);
	    } else {
		ls.msg.notice(null, result.sMsg);		
		thisObj.toggleBlock('block',sType);
		thisObj.toggleBlock('option',sType);
		thisObj.toggleBlock('edit',sType);
		thisObj.hide();
	    }
	});
    }
    
    this.upd = function (sTypeCategory) {
	thisObj = this;
	formObj = $('#form_edit');
	thisObj.showProgress($('#block-category'));
	ls.ajax(aRouter['settings']+'category/ajaxeditcategory/',formObj.serializeJSON(),function(result) {
	    if (result.bStateError) {
		ls.msg.error(null, result.sMsg);
	    } else {
		ls.msg.notice(null, result.sMsg);		
		thisObj.toggleBlock('block',sTypeCategory);
		thisObj.toggleBlock('option',sTypeCategory);
		thisObj.toggleBlock('edit',sTypeCategory);
		thisObj.hide();
	    }
	});
    }
    
    this.del = function (sId, sType) {
	thisObj = this;
	thisObj.showProgress($('#block-category'));
	ls.ajax(aRouter['settings']+'category/ajaxdellcategory/',{sId:sId, sType:sType},function(result) {
	    if (result.bStateError) {
		ls.msg.error(null, result.sMsg);
	    } else {
		ls.msg.notice(null, result.sMsg);
		thisObj.toggleBlock('block',sType);
		thisObj.toggleBlock('option',sType);
		thisObj.toggleBlock('edit',sType);
	    }
	});
    }
    
    this.toggleBlock = function (sType, sTypeCategory) {
	ls.ajax(aRouter['settings']+'category/ajaxtogglecategory/',{sType:sType, sTypeCategory:sTypeCategory},function(result) {
	    if (result.bStateError) {
		ls.msg.error(null, result.sMsg);
	    } else {
		$('#'+sType+'-category').html(result.sHtml);
	    }
	});
    }
    
    this.showProgress = function(content) {
	  thisObj = this;
	  content.html($('<div />').css('text-align','center').append($('<img>', {src: thisObj.options.loader})));
    }

    this.options = {
	    loader: DIR_STATIC_SKIN + '/images/loader.gif'
    }
    
    return this;
}).call(ls.category || {},jQuery);

