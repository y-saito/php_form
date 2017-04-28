<%include file="_common/header.tpl"%>

<div class="page-header">
  <h2>投稿画面&nbsp;<small><span class="glyphicon glyphicon-asterisk text-danger" aria-hidden="true"></span>は入力必須項目です。</small></h2>
</div> 

<form class="form-horizontal" method="post" action="/<%$appConf.baseDirName%>/<%$appConf.controller%>/confirm/">
<div class="row">
  <div class="form-group">
    <label for="title" class="col-sm-2 control-label">ご職業</label>
    <div class="col-sm-10">
    <select id="title" class="form-control" name="title">
      <%html_options output=$controllerConf.titleArray values=$controllerConf.titleValueArray selected=$inputValue.title%>
    </select>
    </div>
  </div>

  <div class="form-group">
    <label for="mail" class="col-sm-2 control-label">メールアドレス<span class="glyphicon glyphicon-asterisk text-danger" aria-hidden="true"></span></label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="mail" name="mail" placeholder="hoge@hoge.hoge" value="<%$inputValue.mail|escape%>">
      <%if isset($errorArr.mail)%>
        <p class="text-danger" role="alert"><%$errorArr.mail|escape%></p>
      <%/if%>
    </div>
  </div>

  <div class="form-group">
    <label for="comment" class="col-sm-2 control-label">投稿欄<span class="glyphicon glyphicon-asterisk text-danger" aria-hidden="true"></span></label>
    <div class="col-sm-10">
      <textarea id="comment" name="comment" class="form-control" rows="6"><%$inputValue.comment|escape%></textarea>
      <span class="help-block">半角カタカナ、特殊文字の使用は避けてください。</span>
      <%if isset($errorArr.comment)%>
        <p class="text-danger" role="alert"><%$errorArr.comment|escape%></p>
      <%/if%>
    </div>
</div>

<div class="btn-group btn-group-justified" role="group">
  <div class="btn-group" role="group">
    <button type="submit" name="submit" value="confirm" class="btn btn-primary">確認画面へ進む</button>
  </div>
</div>
</form>

<%include file="_common/footer.tpl"%>
