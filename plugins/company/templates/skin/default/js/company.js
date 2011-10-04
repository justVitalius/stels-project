
function ajaxJoinLeaveCompany(obj,idBlog) {   
	obj=$(obj);
	JsHttpRequest.query(
    	'POST '+DIR_WEB_ROOT+'/plugins/company/include/ajax/joinLeaveCompanyBlog.php',
        { idBlog: idBlog, security_ls_key: LIVESTREET_SECURITY_KEY },
        function(result, errors) {
        	if (!result) {
                msgErrorBox.alert('Error','Please try again later');
        	}
            if (result.bStateError) {
            	msgErrorBox.alert(result.sMsgTitle,result.sMsg);
            } else {
            	msgNoticeBox.alert(result.sMsgTitle,result.sMsg);
            	if (obj)  {
            		obj.getParent().removeClass('active');
            		obj.innerHTML="подписаться";
            		if (result.bState) {
            			obj.getParent().addClass('active');
            			obj.innerHTML="отписаться";
            		}
            	}
            }
        },
        true
    );
}

