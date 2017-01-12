<%include file="_common/header.tpl"%>

<header class="pagetitle form-noreply">
<h1><i class="icon-envelope"></i> 投稿フォーム（返信の不要な方）</h1>
</header>

<section class="well">
<ul>
<li>お客様からいただいたご意見は、弊社のサービスの改善に役立たせていただきます。</li>
<li>こちらは、<span class="text-error">返信が不要な方</span>の投稿フォームです。</li>
<li>投稿いただいた内容につきましては、弊社のサイトなどに掲載させていただくことがございます。</li>
</ul>
</section>

<form class="form-horizontal" method="post" action="/<%$appConf.baseDirName%>/<%$appConf.controller%>/confirm/">
<p>※ <span class="label label-important">必須</span> は入力必須項目です。</p>
<hr />

<div class="control-group">
  <label class="control-label" for="title">投稿内容 </label>
  <div class="controls">
    <div class="input-prepend">
      <span class="add-on">ご職業：</span>
      <select id="title" name="title">
        <%html_options output=$controllerConf.titleArray values=$controllerConf.titleValueArray selected=$inputValue.title%>
      </select>
    </div>
 <%if isset($errorArr.mail)%>
  <%section name=counter loop=$errorArr.mail%>
  <br><span class="text-error"><%$errorArr.mail[counter]|escape%></span>
  <%/section%>
<%/if%>
    <br>
    メールアドレス：<input id="mail" name="mail" class="" value="<%$inputValue.mail|escape%>">
  <%if isset($errorArr.comment)%>
    <%section name=counter loop=$errorArr.comment%>
    <br><span class="text-error"><%$errorArr.comment[counter]|escape%></span>
    <%/section%>
  <%/if%>
    <br>
    コメント<span class="label label-important">*必須</span>：<br>
    <textarea id="comment" name="comment" class="span6 mt10" rows="6"><%$inputValue.comment|escape%></textarea>
    <br>
    <span class="help-inline">※ 半角カタカナ、特殊文字の使用は避けてください。</span>
  </div>
</div>

<div class="well form-noreply text-center">
  <button type="submit" name="submit" value="confirm" class="btn btn-primary">確認画面へ進む</button>
</div>
</form>

<ul class="small">
<li>ブラウザの戻るボタンはクリックしないでください。</li>
</ul>

<%include file="_common/footer.tpl"%>
