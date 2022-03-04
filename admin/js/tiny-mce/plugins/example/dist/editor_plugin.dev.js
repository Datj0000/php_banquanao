"use strict";

(function () {
  tinymce.PluginManager.requireLangPack("example");
  tinymce.create("tinymce.plugins.ExamplePlugin", {
    init: function init(a, b) {
      a.addCommand("mceExample", function () {
        a.windowManager.open({
          file: b + "/dialog.htm",
          width: 320 + parseInt(a.getLang("example.delta_width", 0)),
          height: 120 + parseInt(a.getLang("example.delta_height", 0)),
          inline: 1
        }, {
          plugin_url: b,
          some_custom_arg: "custom arg"
        });
      });
      a.addButton("example", {
        title: "example.desc",
        cmd: "mceExample",
        image: b + "/img/example.gif"
      });
      a.onNodeChange.add(function (d, c, e) {
        c.setActive("example", e.nodeName == "IMG");
      });
    },
    createControl: function createControl(b, a) {
      return null;
    },
    getInfo: function getInfo() {
      return {
        longname: "Example plugin",
        author: "Some author",
        authorurl: "http://tinymce.moxiecode.com",
        infourl: "http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example",
        version: "1.0"
      };
    }
  });
  tinymce.PluginManager.add("example", tinymce.plugins.ExamplePlugin);
})();