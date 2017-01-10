jQuery(document).ready(function($) {
  if ($('.rav_custom_css').has('#rev_code_editor')) {
	var textarea = jQuery('#rev_css_editor');
   var editor = ace.edit("rev_code_editor");
   editor.setTheme("ace/theme/monokai");
   editor.setFontSize(20);
   editor.getSession().setMode("ace/mode/css");
   editor.getSession().setUseWorker(true);
   editor.getSession().on('change', function () {
       textarea.val(editor.getSession().getValue());
   });
   textarea.val(editor.getSession().getValue());
 };
});
