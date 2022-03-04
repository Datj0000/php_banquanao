"use strict";

tinyMCEPopup.requireLangPack();
var EmotionsDialog = {
  init: function init(ed) {
    tinyMCEPopup.resizeToInnerSize();
  },
  insert: function insert(file, title) {
    var ed = tinyMCEPopup.editor,
        dom = ed.dom;
    tinyMCEPopup.execCommand('mceInsertContent', false, dom.createHTML('img', {
      src: tinyMCEPopup.getWindowArg('plugin_url') + '/img/' + file,
      alt: ed.getLang(title),
      title: ed.getLang(title),
      border: 0
    }));
    tinyMCEPopup.close();
  }
};
tinyMCEPopup.onInit.add(EmotionsDialog.init, EmotionsDialog);