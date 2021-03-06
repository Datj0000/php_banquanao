"use strict";

(function () {
  tinymce.create("tinymce.plugins.ExampleDependencyPlugin", {
    init: function init(a, b) {},
    getInfo: function getInfo() {
      return {
        longname: "Example Dependency plugin",
        author: "Some author",
        authorurl: "http://tinymce.moxiecode.com",
        infourl: "http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example_dependency",
        version: "1.0"
      };
    }
  });
  tinymce.PluginManager.add("example_dependency", tinymce.plugins.ExampleDependencyPlugin, ["example"]);
})();