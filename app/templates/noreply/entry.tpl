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



<form class="form-horizontal" method="post" action="/<%$BaseDir%>/<%$Dir%>/proc/">
<p>※ <span class="label label-important">必須</span> は入力必須項目です。</p>
<hr />

<div class="control-group">
  <label class="control-label" for="title">投稿内容 <span class="label label-important">必須</span></label>
  <div class="controls">
    <div class="input-prepend">
      <span class="add-on">表題：</span>
      <select id="title" name="title">
	<%html_options values=$title_values selected=$title output=$title_output%>
     </select>
    </div>
<%if isset($err_title)%>
  <%section name=counter loop=$err_title%>
  <br><span class="text-error"><%$err_title[counter]%></span>
  <%/section%>
<%/if%>
    <br>
    <textarea id="comment" name="comment" class="span6 mt10" rows="6"><%$comment%></textarea>
    <span class="help-inline">※ 半角カタカナ、特殊文字の使用は避けてください。</span>
  </div>
<%if isset($err_comment)%>
  <div class="controls">
  <%section name=counter loop=$err_comment%>
    <p class="text-error"><%$err_comment[counter]%></p>
  <%/section%>
  </div>
<%/if%>
</div>

<div class="well form-noreply text-center">
  <button type="submit" name="submit" value="confirm" class="btn btn-primary">確認画面へ進む</button>
</div>
</form>

<ul class="small">
<li>ブラウザの戻るボタンはクリックしないでください。</li>
</ul>

<%include file="_common/footer.tpl"%>
