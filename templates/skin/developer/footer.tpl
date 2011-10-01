		{hook run='content_end'}
		</div><!-- /content -->

	</div><!-- /wrapper -->
	<div id="wrapper-foot">&nbsp;</div>
</div><!-- /container -->
<div id="footer-img" class="footer-img" ></div>
	<div id="footer">
	  
	  <div class="container">
  	    <div id="footer-nav">
           <ul class="pages">
            <li {if $sAction=='index'}class="active"{/if}><a href="{cfg name='path.root.web'}" style="margin-left:5px">Главная</a></li>
            <li {if $sAction=='blogs' and $sEvent=='good'}class="active"{/if}><a href="{router page='blogs'}">Блоги</a></li>
            <li {if $sEvent=='qa'}class="active"{/if}><a href="{cfg name='path.root.web'}/blog/qa/">Q&A</a></li>
            <li {if $sAction=='people'}class="active"{/if}><a href="{router page='people'}">Пользователи</a></li>
            <li {if $sAction=='companies'}class="active"{/if}><a href="{cfg name='path.root.web'}/#">Компании</a></li>
            <li {if $sEvent=='events'}class="active"{/if}><a href="{cfg name='path.root.web'}/blog/events/">События</a></li>
            <li {if $sEvent=='competitions'}class="active"{/if}><a href="{cfg name='path.root.web'}/blog/competitions/"  style="margin-right:5px">Конкурсы</a></li>
            {hook run='main_menu'}
          </ul>
        </div>
        <div id="logo_studio">
          <a href="http://www.avatech.in/">Дизайн струдия Avatech</a>
        </div>
		</div>
	</div>



{hook run='body_end'}

</body>
</html>