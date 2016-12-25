<%include file="_common/header.tpl"%>

<header class="pagetitle form-noreply">
<h1><i class="icon-envelope"></i>投稿フォーム（返信の不要な方）</h1>
</header>

<h2 class="text-center">確認画面</h2>

<section class="well">
<ul>
<li>以下の内容で送信します。内容をご確認頂き「送信する」ボタンを押してください。</li>
<li>内容を修正される場合は「戻る」ボタンを押してください。</li>
</ul>
</section>



<form class="form-horizontal" method="post" action="/inquiry/form/noreply/proc/">

<div class="control-group">
  <label class="control-label" for="title">投稿内容 <span class="label label-important">必須</span></label>
  <div class="controls">
    表題：<%$title%>
    <br>
    <%$comment|nl2br%>
  </div>
</div>

<div class="well form-noreply text-center">
  <input type="hidden" name="title" value="<%$title%>">
  <input type="hidden" name="comment" value="<%$comment%>">
  <button type="submit" name="submit" value="thanks" class="btn btn-primary">送信する</button>
  <button type="submit" name="submit" value="entry" class="btn">戻る</button>
</div>
</form>

<ul class="small">
<li>ブラウザの戻るボタンはクリックしないでください。</li>
</ul>


<%include file="_common/footer.tpl"%>
