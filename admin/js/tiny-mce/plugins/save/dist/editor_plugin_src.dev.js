"use strict";

/**
 * editor_plugin_src.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */
(function () {
  tinymce.create('tinymce.plugins.Save', {
    init: function init(ed, url) {
      var t = this;
      t.editor = ed; // Register commands

      ed.addCommand('mceSave', t._save, t);
      ed.addCommand('mceCancel', t._cancel, t); // Register buttons

      ed.addButton('save', {
        title: 'save.save_desc',
        cmd: 'mceSave'
      });
      ed.addButton('cancel', {
        title: 'save.cancel_desc',
        cmd: 'mceCancel'
      });
      ed.onNodeChange.add(t._nodeChange, t);
      ed.addShortcut('ctrl+s', ed.getLang('save.save_desc'), 'mceSave');
    },
    getInfo: function getInfo() {
      return {
        longname: 'Save',
        author: 'Moxiecode Systems AB',
        authorurl: 'http://tinymce.moxiecode.com',
        infourl: 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/save',
        version: tinymce.majorVersion + "." + tinymce.minorVersion
      };
    },
    // Private methods
    _nodeChange: function _nodeChange(ed, cm, n) {
      var ed = this.editor;

      if (ed.getParam('save_enablewhendirty')) {
        cm.setDisabled('save', !ed.isDirty());
        cm.setDisabled('cancel', !ed.isDirty());
      }
    },
    // Private methods
    _save: function _save() {
      var ed = this.editor,
          formObj,
          os,
          i,
          elementId;
      formObj = tinymce.DOM.get(ed.id).form || tinymce.DOM.getParent(ed.id, 'form');
      if (ed.getParam("save_enablewhendirty") && !ed.isDirty()) return;
      tinyMCE.triggerSave(); // Use callback instead

      if (os = ed.getParam("save_onsavecallback")) {
        if (ed.execCallback('save_onsavecallback', ed)) {
          ed.startContent = tinymce.trim(ed.getContent({
            format: 'raw'
          }));
          ed.nodeChanged();
        }

        return;
      }

      if (formObj) {
        ed.isNotDirty = true;
        if (formObj.onsubmit == null || formObj.onsubmit() != false) formObj.submit();
        ed.nodeChanged();
      } else ed.windowManager.alert("Error: No form element found.");
    },
    _cancel: function _cancel() {
      var ed = this.editor,
          os,
          h = tinymce.trim(ed.startContent); // Use callback instead

      if (os = ed.getParam("save_oncancelcallback")) {
        ed.execCallback('save_oncancelcallback', ed);
        return;
      }

      ed.setContent(h);
      ed.undoManager.clear();
      ed.nodeChanged();
    }
  }); // Register plugin

  tinymce.PluginManager.add('save', tinymce.plugins.Save);
})();