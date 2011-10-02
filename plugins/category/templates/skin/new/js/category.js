var lsCategoryClass = new Class({
    Implements: Options,
  
    options: {

    },

    initialize: function(options){

    },

    ShowHideForm:function (id) {
	var obj=$(id);
	var slideObj = new Fx.Slide(obj);
	obj.setStyle('margin','0 auto');
	if (obj.getStyle('display')=='none') {
	    slideObj.hide();
	    obj.setStyle('display','block');
	}
	slideObj.toggle();
    },

    toggleBlock:function(sType,sTypeCategory){
	$('block-category').set('html','');
	this.showStatus($('block-category'));

	new Request.JSON({
	    url: aRouter['settings']+'category/ajaxtogglecategory/',
	    noCache: true,
	    data: {
		sType:sType, 
		sTypeCategory:sTypeCategory, 
		security_ls_key: LIVESTREET_SECURITY_KEY
	    },
	    onSuccess: function(result){
		if (!result) {
		    msgErrorBox.alert('Error','Please try again later');
		}
		if (result.bStateError) {
		    msgErrorBox.alert(result.sMsgTitle,result.sMsg);
		} else {
		    //msgNoticeBox.alert(result.sMsgTitle,result.sMsg);
		    $(sType+'-category').set('html',result.sHtml);
		}

	    },
	    onFailure: function(){
		msgErrorBox.alert('Error','Please try again later');
	    }
	}).send();
    },

    Add:function (obj,sTypeCategory) {
	var thisObj=this;

	formObj=$(obj);		
	var params=formObj.toQueryString();
	params=params+'&security_ls_key='+LIVESTREET_SECURITY_KEY;

	new Request.JSON({
	    url: aRouter['settings']+'category/ajaxaddcategory/',
	    noCache: true,
	    data: params,
	    onSuccess: function(result){
		if (!result) {
		    msgErrorBox.alert('Error','Please try again later');
		}
		if (result.bStateError) {
		    msgErrorBox.alert(result.sMsgTitle,result.sMsg);
		} else {
		    thisObj.toggleBlock('block',sTypeCategory);
		    thisObj.toggleBlock('option',sTypeCategory);
		    thisObj.toggleBlock('edit',sTypeCategory);
		}

	    },
	    onFailure: function(){
		msgErrorBox.alert('Error','Please try again later');
	    }
	}).send();

    },

    Upd:function (obj,sTypeCategory) {
	var thisObj=this;
	formObj=$(obj);		
	var params=formObj.toQueryString();
	params=params+'&security_ls_key='+LIVESTREET_SECURITY_KEY;

	new Request.JSON({
	    url: aRouter['settings']+'category/ajaxeditcategory/',
	    noCache: true,
	    data: params,
	    onSuccess: function(result){
		if (!result) {
		    msgErrorBox.alert('Error','Please try again later');
		}
		if (result.bStateError) {
		    msgErrorBox.alert(result.sMsgTitle,result.sMsg);
		} else {
		    thisObj.toggleBlock('block',sTypeCategory);
		    thisObj.toggleBlock('option',sTypeCategory);
		    thisObj.toggleBlock('edit',sTypeCategory);
		    thisObj.hideFormEdit();
		}

	    },
	    onFailure: function(){
		msgErrorBox.alert('Error','Please try again later');
	    }
	}).send();

    },

    Dell:function (sId,sTypeCategory) {
	var thisObj=this;

	new Request.JSON({
	    url: aRouter['settings']+'category/ajaxdellcategory/',
	    noCache: true,
	    data: {
		sId:sId, 
		sType:sTypeCategory, 
		security_ls_key: LIVESTREET_SECURITY_KEY
	    },
	    onSuccess: function(result){
		if (!result) {
		    msgErrorBox.alert('Error','Please try again later');
		}
		if (result.bStateError) {
		    msgErrorBox.alert(result.sMsgTitle,result.sMsg);
		} else {
		    thisObj.toggleBlock('block',sTypeCategory);
		    thisObj.toggleBlock('option',sTypeCategory);
		    thisObj.toggleBlock('edit',sTypeCategory);
		    thisObj.hideFormEdit();
		}

	    },
	    onFailure: function(){
		msgErrorBox.alert('Error','Please try again later');
	    }
	}).send();
    },

    Edit:function (sId, sParentId, sTitle, sUrl) {

	if (Browser.Engine.trident) {
	//return true;
	}
	if (!winFormEdit) {
	    winFormEdit=new StickyWin.Modal(
	    {
		content: $('window_edit_form'),
		closeClassName: 'close-block',
		useIframeShim: false,
		modalOptions: {
		    modalStyle:{
			'z-index':900
		    }
		}
	    }
	    );
	}
	$('window_edit_form').setStyles({
	    'top': '150px', 
	    'position': 'fixed'
	});
	winFormEdit.show();
	winFormEdit.pin(true);
	$('e_category_id').set('value',sId);
	$('edit-category').set('value',sParentId);
	$('e_category_title').set('value',sTitle);
	$('e_category_url').set('value',sUrl);

    },

    hideFormEdit:function () {
	winFormEdit.hide();
    },

    showStatus: function(obj) {
	var newDiv = new Element('div');
	newDiv.setStyle('text-align','center');
	newDiv.set('html','<img src="'+DIR_STATIC_SKIN+'/images/loader.gif" >');

	newDiv.inject(obj);
    }


});

var winFormEdit;
var lsCategoryTree;

window.addEvent('domready', function() {  	
    lsCategoryTree = new lsCategoryClass();
});
