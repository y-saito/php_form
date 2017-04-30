<%include file="_common/header.tpl"%>

<div class="page-header">
  <h2>確認画面</h2>
</div> 

<div class="alert alert-info" role="alert">
<ul class="list-unstyled">
<li>以下の内容で送信します。内容をご確認頂き「送信する」ボタンを押してください。</li>
<li>内容を修正される場合は「戻る」ボタンを押してください。</li>
</ul>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">投稿内容</h3>
  </div>
  <div class="panel-body">
    <ul class="list-unstyled">
      <li>ご職業：<%$inputValue.title%></li>
      <li>メールアドレス：<%$inputValue.mail|escape%></li>
      <li>投稿欄：<%$inputValue.comment%></li>
    </ul>
  </div>
</div>

<form class="form-horizontal" method="post" action="<%$sendUri%>">
<div class="btn-group btn-group-justified" role="group">
  <div class="btn-group" role="group">
    <button type="submit" name="process" value="-1" class="btn btn-default">戻る</button>
  </div>
  <div class="btn-group" role="group">
    <button type="submit" name="process" value="1" class="btn btn-primary">送信する</button>
  </div>
</div>
</form>

<%include file="_common/footer.tpl"%>
