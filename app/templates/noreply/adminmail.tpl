投稿フォーム（返信不要）
------------------------------------------------------------------------
表題：<%$h__title%>

内容：
<%$h__comment%>
------------------------------------------------------------------------

<%if isset($warn_comment)%>
<%section name=counter loop=$warn_comment%>
※<%$warn_comment[counter]%>
<%/section%>
<%/if%>
