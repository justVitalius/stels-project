{include file='header.tpl' menu='blog'}


<script language="JavaScript" type="text/javascript">
var COMPANY_PATH = '{cfg name="module.company.url"}';
</script>

{literal}
<script language="JavaScript" type="text/javascript">
function submitTags(sTag) {		
	window.location=COMPANY_PATH+'tag/'+sTag+'/';
	return false;
}
</script>
{/literal}


	&nbsp;&nbsp;
	<form action="" method="GET" onsubmit="return submitTags(this.tag.value);">
		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
		<input type="text" name="tag" value="{$sTag|escape:'html'}" class="tags-input" >
	</form>

<br>


{include file='../plugins/company/templates/skin/default/company_list.tpl'}


{include file='footer.tpl'}

