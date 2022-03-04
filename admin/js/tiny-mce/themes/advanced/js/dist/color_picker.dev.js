"use strict";

var _named;

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

tinyMCEPopup.requireLangPack();
var detail = 50,
    strhex = "0123456789ABCDEF",
    i,
    isMouseDown = false,
    isMouseOver = false;
var colors = ["#000000", "#000033", "#000066", "#000099", "#0000cc", "#0000ff", "#330000", "#330033", "#330066", "#330099", "#3300cc", "#3300ff", "#660000", "#660033", "#660066", "#660099", "#6600cc", "#6600ff", "#990000", "#990033", "#990066", "#990099", "#9900cc", "#9900ff", "#cc0000", "#cc0033", "#cc0066", "#cc0099", "#cc00cc", "#cc00ff", "#ff0000", "#ff0033", "#ff0066", "#ff0099", "#ff00cc", "#ff00ff", "#003300", "#003333", "#003366", "#003399", "#0033cc", "#0033ff", "#333300", "#333333", "#333366", "#333399", "#3333cc", "#3333ff", "#663300", "#663333", "#663366", "#663399", "#6633cc", "#6633ff", "#993300", "#993333", "#993366", "#993399", "#9933cc", "#9933ff", "#cc3300", "#cc3333", "#cc3366", "#cc3399", "#cc33cc", "#cc33ff", "#ff3300", "#ff3333", "#ff3366", "#ff3399", "#ff33cc", "#ff33ff", "#006600", "#006633", "#006666", "#006699", "#0066cc", "#0066ff", "#336600", "#336633", "#336666", "#336699", "#3366cc", "#3366ff", "#666600", "#666633", "#666666", "#666699", "#6666cc", "#6666ff", "#996600", "#996633", "#996666", "#996699", "#9966cc", "#9966ff", "#cc6600", "#cc6633", "#cc6666", "#cc6699", "#cc66cc", "#cc66ff", "#ff6600", "#ff6633", "#ff6666", "#ff6699", "#ff66cc", "#ff66ff", "#009900", "#009933", "#009966", "#009999", "#0099cc", "#0099ff", "#339900", "#339933", "#339966", "#339999", "#3399cc", "#3399ff", "#669900", "#669933", "#669966", "#669999", "#6699cc", "#6699ff", "#999900", "#999933", "#999966", "#999999", "#9999cc", "#9999ff", "#cc9900", "#cc9933", "#cc9966", "#cc9999", "#cc99cc", "#cc99ff", "#ff9900", "#ff9933", "#ff9966", "#ff9999", "#ff99cc", "#ff99ff", "#00cc00", "#00cc33", "#00cc66", "#00cc99", "#00cccc", "#00ccff", "#33cc00", "#33cc33", "#33cc66", "#33cc99", "#33cccc", "#33ccff", "#66cc00", "#66cc33", "#66cc66", "#66cc99", "#66cccc", "#66ccff", "#99cc00", "#99cc33", "#99cc66", "#99cc99", "#99cccc", "#99ccff", "#cccc00", "#cccc33", "#cccc66", "#cccc99", "#cccccc", "#ccccff", "#ffcc00", "#ffcc33", "#ffcc66", "#ffcc99", "#ffcccc", "#ffccff", "#00ff00", "#00ff33", "#00ff66", "#00ff99", "#00ffcc", "#00ffff", "#33ff00", "#33ff33", "#33ff66", "#33ff99", "#33ffcc", "#33ffff", "#66ff00", "#66ff33", "#66ff66", "#66ff99", "#66ffcc", "#66ffff", "#99ff00", "#99ff33", "#99ff66", "#99ff99", "#99ffcc", "#99ffff", "#ccff00", "#ccff33", "#ccff66", "#ccff99", "#ccffcc", "#ccffff", "#ffff00", "#ffff33", "#ffff66", "#ffff99", "#ffffcc", "#ffffff"];
var named = (_named = {
  '#F0F8FF': 'Alice Blue',
  '#FAEBD7': 'Antique White',
  '#00FFFF': 'Aqua',
  '#7FFFD4': 'Aquamarine',
  '#F0FFFF': 'Azure',
  '#F5F5DC': 'Beige',
  '#FFE4C4': 'Bisque',
  '#000000': 'Black',
  '#FFEBCD': 'Blanched Almond',
  '#0000FF': 'Blue',
  '#8A2BE2': 'Blue Violet',
  '#A52A2A': 'Brown',
  '#DEB887': 'Burly Wood',
  '#5F9EA0': 'Cadet Blue',
  '#7FFF00': 'Chartreuse',
  '#D2691E': 'Chocolate',
  '#FF7F50': 'Coral',
  '#6495ED': 'Cornflower Blue',
  '#FFF8DC': 'Cornsilk',
  '#DC143C': 'Crimson'
}, _defineProperty(_named, "#00FFFF", 'Cyan'), _defineProperty(_named, '#00008B', 'Dark Blue'), _defineProperty(_named, '#008B8B', 'Dark Cyan'), _defineProperty(_named, '#B8860B', 'Dark Golden Rod'), _defineProperty(_named, '#A9A9A9', 'Dark Gray'), _defineProperty(_named, "#A9A9A9", 'Dark Grey'), _defineProperty(_named, '#006400', 'Dark Green'), _defineProperty(_named, '#BDB76B', 'Dark Khaki'), _defineProperty(_named, '#8B008B', 'Dark Magenta'), _defineProperty(_named, '#556B2F', 'Dark Olive Green'), _defineProperty(_named, '#FF8C00', 'Darkorange'), _defineProperty(_named, '#9932CC', 'Dark Orchid'), _defineProperty(_named, '#8B0000', 'Dark Red'), _defineProperty(_named, '#E9967A', 'Dark Salmon'), _defineProperty(_named, '#8FBC8F', 'Dark Sea Green'), _defineProperty(_named, '#483D8B', 'Dark Slate Blue'), _defineProperty(_named, '#2F4F4F', 'Dark Slate Gray'), _defineProperty(_named, "#2F4F4F", 'Dark Slate Grey'), _defineProperty(_named, '#00CED1', 'Dark Turquoise'), _defineProperty(_named, '#9400D3', 'Dark Violet'), _defineProperty(_named, '#FF1493', 'Deep Pink'), _defineProperty(_named, '#00BFFF', 'Deep Sky Blue'), _defineProperty(_named, '#696969', 'Dim Gray'), _defineProperty(_named, "#696969", 'Dim Grey'), _defineProperty(_named, '#1E90FF', 'Dodger Blue'), _defineProperty(_named, '#B22222', 'Fire Brick'), _defineProperty(_named, '#FFFAF0', 'Floral White'), _defineProperty(_named, '#228B22', 'Forest Green'), _defineProperty(_named, '#FF00FF', 'Fuchsia'), _defineProperty(_named, '#DCDCDC', 'Gainsboro'), _defineProperty(_named, '#F8F8FF', 'Ghost White'), _defineProperty(_named, '#FFD700', 'Gold'), _defineProperty(_named, '#DAA520', 'Golden Rod'), _defineProperty(_named, '#808080', 'Gray'), _defineProperty(_named, "#808080", 'Grey'), _defineProperty(_named, '#008000', 'Green'), _defineProperty(_named, '#ADFF2F', 'Green Yellow'), _defineProperty(_named, '#F0FFF0', 'Honey Dew'), _defineProperty(_named, '#FF69B4', 'Hot Pink'), _defineProperty(_named, '#CD5C5C', 'Indian Red'), _defineProperty(_named, '#4B0082', 'Indigo'), _defineProperty(_named, '#FFFFF0', 'Ivory'), _defineProperty(_named, '#F0E68C', 'Khaki'), _defineProperty(_named, '#E6E6FA', 'Lavender'), _defineProperty(_named, '#FFF0F5', 'Lavender Blush'), _defineProperty(_named, '#7CFC00', 'Lawn Green'), _defineProperty(_named, '#FFFACD', 'Lemon Chiffon'), _defineProperty(_named, '#ADD8E6', 'Light Blue'), _defineProperty(_named, '#F08080', 'Light Coral'), _defineProperty(_named, '#E0FFFF', 'Light Cyan'), _defineProperty(_named, '#FAFAD2', 'Light Golden Rod Yellow'), _defineProperty(_named, '#D3D3D3', 'Light Gray'), _defineProperty(_named, "#D3D3D3", 'Light Grey'), _defineProperty(_named, '#90EE90', 'Light Green'), _defineProperty(_named, '#FFB6C1', 'Light Pink'), _defineProperty(_named, '#FFA07A', 'Light Salmon'), _defineProperty(_named, '#20B2AA', 'Light Sea Green'), _defineProperty(_named, '#87CEFA', 'Light Sky Blue'), _defineProperty(_named, '#778899', 'Light Slate Gray'), _defineProperty(_named, "#778899", 'Light Slate Grey'), _defineProperty(_named, '#B0C4DE', 'Light Steel Blue'), _defineProperty(_named, '#FFFFE0', 'Light Yellow'), _defineProperty(_named, '#00FF00', 'Lime'), _defineProperty(_named, '#32CD32', 'Lime Green'), _defineProperty(_named, '#FAF0E6', 'Linen'), _defineProperty(_named, "#FF00FF", 'Magenta'), _defineProperty(_named, '#800000', 'Maroon'), _defineProperty(_named, '#66CDAA', 'Medium Aqua Marine'), _defineProperty(_named, '#0000CD', 'Medium Blue'), _defineProperty(_named, '#BA55D3', 'Medium Orchid'), _defineProperty(_named, '#9370D8', 'Medium Purple'), _defineProperty(_named, '#3CB371', 'Medium Sea Green'), _defineProperty(_named, '#7B68EE', 'Medium Slate Blue'), _defineProperty(_named, '#00FA9A', 'Medium Spring Green'), _defineProperty(_named, '#48D1CC', 'Medium Turquoise'), _defineProperty(_named, '#C71585', 'Medium Violet Red'), _defineProperty(_named, '#191970', 'Midnight Blue'), _defineProperty(_named, '#F5FFFA', 'Mint Cream'), _defineProperty(_named, '#FFE4E1', 'Misty Rose'), _defineProperty(_named, '#FFE4B5', 'Moccasin'), _defineProperty(_named, '#FFDEAD', 'Navajo White'), _defineProperty(_named, '#000080', 'Navy'), _defineProperty(_named, '#FDF5E6', 'Old Lace'), _defineProperty(_named, '#808000', 'Olive'), _defineProperty(_named, '#6B8E23', 'Olive Drab'), _defineProperty(_named, '#FFA500', 'Orange'), _defineProperty(_named, '#FF4500', 'Orange Red'), _defineProperty(_named, '#DA70D6', 'Orchid'), _defineProperty(_named, '#EEE8AA', 'Pale Golden Rod'), _defineProperty(_named, '#98FB98', 'Pale Green'), _defineProperty(_named, '#AFEEEE', 'Pale Turquoise'), _defineProperty(_named, '#D87093', 'Pale Violet Red'), _defineProperty(_named, '#FFEFD5', 'Papaya Whip'), _defineProperty(_named, '#FFDAB9', 'Peach Puff'), _defineProperty(_named, '#CD853F', 'Peru'), _defineProperty(_named, '#FFC0CB', 'Pink'), _defineProperty(_named, '#DDA0DD', 'Plum'), _defineProperty(_named, '#B0E0E6', 'Powder Blue'), _defineProperty(_named, '#800080', 'Purple'), _defineProperty(_named, '#FF0000', 'Red'), _defineProperty(_named, '#BC8F8F', 'Rosy Brown'), _defineProperty(_named, '#4169E1', 'Royal Blue'), _defineProperty(_named, '#8B4513', 'Saddle Brown'), _defineProperty(_named, '#FA8072', 'Salmon'), _defineProperty(_named, '#F4A460', 'Sandy Brown'), _defineProperty(_named, '#2E8B57', 'Sea Green'), _defineProperty(_named, '#FFF5EE', 'Sea Shell'), _defineProperty(_named, '#A0522D', 'Sienna'), _defineProperty(_named, '#C0C0C0', 'Silver'), _defineProperty(_named, '#87CEEB', 'Sky Blue'), _defineProperty(_named, '#6A5ACD', 'Slate Blue'), _defineProperty(_named, '#708090', 'Slate Gray'), _defineProperty(_named, "#708090", 'Slate Grey'), _defineProperty(_named, '#FFFAFA', 'Snow'), _defineProperty(_named, '#00FF7F', 'Spring Green'), _defineProperty(_named, '#4682B4', 'Steel Blue'), _defineProperty(_named, '#D2B48C', 'Tan'), _defineProperty(_named, '#008080', 'Teal'), _defineProperty(_named, '#D8BFD8', 'Thistle'), _defineProperty(_named, '#FF6347', 'Tomato'), _defineProperty(_named, '#40E0D0', 'Turquoise'), _defineProperty(_named, '#EE82EE', 'Violet'), _defineProperty(_named, '#F5DEB3', 'Wheat'), _defineProperty(_named, '#FFFFFF', 'White'), _defineProperty(_named, '#F5F5F5', 'White Smoke'), _defineProperty(_named, '#FFFF00', 'Yellow'), _defineProperty(_named, '#9ACD32', 'Yellow Green'), _named);
var namedLookup = {};

function init() {
  var inputColor = convertRGBToHex(tinyMCEPopup.getWindowArg('input_color')),
      key,
      value;
  tinyMCEPopup.resizeToInnerSize();
  generatePicker();
  generateWebColors();
  generateNamedColors();

  if (inputColor) {
    changeFinalColor(inputColor);
    col = convertHexToRGB(inputColor);
    if (col) updateLight(col.r, col.g, col.b);
  }

  for (key in named) {
    value = named[key];
    namedLookup[value.replace(/\s+/, '').toLowerCase()] = key.replace(/#/, '').toLowerCase();
  }
}

function toHexColor(color) {
  var matches,
      red,
      green,
      blue,
      toInt = parseInt;

  function hex(value) {
    value = parseInt(value).toString(16);
    return value.length > 1 ? value : '0' + value; // Padd with leading zero
  }

  ;
  color = color.replace(/[\s#]+/g, '').toLowerCase();
  color = namedLookup[color] || color;
  matches = /^rgb\((\d{1,3}),(\d{1,3}),(\d{1,3})\)|([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})|([a-f0-9])([a-f0-9])([a-f0-9])$/.exec(color);

  if (matches) {
    if (matches[1]) {
      red = toInt(matches[1]);
      green = toInt(matches[2]);
      blue = toInt(matches[3]);
    } else if (matches[4]) {
      red = toInt(matches[4], 16);
      green = toInt(matches[5], 16);
      blue = toInt(matches[6], 16);
    } else if (matches[7]) {
      red = toInt(matches[7] + matches[7], 16);
      green = toInt(matches[8] + matches[8], 16);
      blue = toInt(matches[9] + matches[9], 16);
    }

    return '#' + hex(red) + hex(green) + hex(blue);
  }

  return '';
}

function insertAction() {
  var color = document.getElementById("color").value,
      f = tinyMCEPopup.getWindowArg('func');
  tinyMCEPopup.restoreSelection();
  if (f) f(toHexColor(color));
  tinyMCEPopup.close();
}

function showColor(color, name) {
  if (name) document.getElementById("colorname").innerHTML = name;
  document.getElementById("preview").style.backgroundColor = color;
  document.getElementById("color").value = color.toUpperCase();
}

function convertRGBToHex(col) {
  var re = new RegExp("rgb\\s*\\(\\s*([0-9]+).*,\\s*([0-9]+).*,\\s*([0-9]+).*\\)", "gi");
  if (!col) return col;
  var rgb = col.replace(re, "$1,$2,$3").split(',');

  if (rgb.length == 3) {
    r = parseInt(rgb[0]).toString(16);
    g = parseInt(rgb[1]).toString(16);
    b = parseInt(rgb[2]).toString(16);
    r = r.length == 1 ? '0' + r : r;
    g = g.length == 1 ? '0' + g : g;
    b = b.length == 1 ? '0' + b : b;
    return "#" + r + g + b;
  }

  return col;
}

function convertHexToRGB(col) {
  if (col.indexOf('#') != -1) {
    col = col.replace(new RegExp('[^0-9A-F]', 'gi'), '');
    r = parseInt(col.substring(0, 2), 16);
    g = parseInt(col.substring(2, 4), 16);
    b = parseInt(col.substring(4, 6), 16);
    return {
      r: r,
      g: g,
      b: b
    };
  }

  return null;
}

function generatePicker() {
  var el = document.getElementById('light'),
      h = '',
      i;

  for (i = 0; i < detail; i++) {
    h += '<div id="gs' + i + '" style="background-color:#000000; width:15px; height:3px; border-style:none; border-width:0px;"' + ' onclick="changeFinalColor(this.style.backgroundColor)"' + ' onmousedown="isMouseDown = true; return false;"' + ' onmouseup="isMouseDown = false;"' + ' onmousemove="if (isMouseDown && isMouseOver) changeFinalColor(this.style.backgroundColor); return false;"' + ' onmouseover="isMouseOver = true;"' + ' onmouseout="isMouseOver = false;"' + '></div>';
  }

  el.innerHTML = h;
}

function generateWebColors() {
  var el = document.getElementById('webcolors'),
      h = '',
      i;
  if (el.className == 'generated') return; // TODO: VoiceOver doesn't seem to support legend as a label referenced by labelledby.

  h += '<div role="listbox" aria-labelledby="webcolors_title" tabindex="0"><table role="presentation" border="0" cellspacing="1" cellpadding="0">' + '<tr>';

  for (i = 0; i < colors.length; i++) {
    h += '<td bgcolor="' + colors[i] + '" width="10" height="10">' + '<a href="javascript:insertAction();" role="option" tabindex="-1" aria-labelledby="web_colors_' + i + '" onfocus="showColor(\'' + colors[i] + '\');" onmouseover="showColor(\'' + colors[i] + '\');" style="display:block;width:10px;height:10px;overflow:hidden;">';

    if (tinyMCEPopup.editor.forcedHighContrastMode) {
      h += '<canvas class="mceColorSwatch" height="10" width="10" data-color="' + colors[i] + '"></canvas>';
    }

    h += '<span class="mceVoiceLabel" style="display:none;" id="web_colors_' + i + '">' + colors[i].toUpperCase() + '</span>';
    h += '</a></td>';
    if ((i + 1) % 18 == 0) h += '</tr><tr>';
  }

  h += '</table></div>';
  el.innerHTML = h;
  el.className = 'generated';
  paintCanvas(el);
  enableKeyboardNavigation(el.firstChild);
}

function paintCanvas(el) {
  tinyMCEPopup.getWin().tinymce.each(tinyMCEPopup.dom.select('canvas.mceColorSwatch', el), function (canvas) {
    var context;

    if (canvas.getContext && (context = canvas.getContext("2d"))) {
      context.fillStyle = canvas.getAttribute('data-color');
      context.fillRect(0, 0, 10, 10);
    }
  });
}

function generateNamedColors() {
  var el = document.getElementById('namedcolors'),
      h = '',
      n,
      v,
      i = 0;
  if (el.className == 'generated') return;

  for (n in named) {
    v = named[n];
    h += '<a href="javascript:insertAction();" role="option" tabindex="-1" aria-labelledby="named_colors_' + i + '" onfocus="showColor(\'' + n + '\',\'' + v + '\');" onmouseover="showColor(\'' + n + '\',\'' + v + '\');" style="background-color: ' + n + '">';

    if (tinyMCEPopup.editor.forcedHighContrastMode) {
      h += '<canvas class="mceColorSwatch" height="10" width="10" data-color="' + colors[i] + '"></canvas>';
    }

    h += '<span class="mceVoiceLabel" style="display:none;" id="named_colors_' + i + '">' + v + '</span>';
    h += '</a>';
    i++;
  }

  el.innerHTML = h;
  el.className = 'generated';
  paintCanvas(el);
  enableKeyboardNavigation(el);
}

function enableKeyboardNavigation(el) {
  tinyMCEPopup.editor.windowManager.createInstance('tinymce.ui.KeyboardNavigation', {
    root: el,
    items: tinyMCEPopup.dom.select('a', el)
  }, tinyMCEPopup.dom);
}

function dechex(n) {
  return strhex.charAt(Math.floor(n / 16)) + strhex.charAt(n % 16);
}

function computeColor(e) {
  var x, y, partWidth, partDetail, imHeight, r, g, b, coef, i, finalCoef, finalR, finalG, finalB;
  x = e.offsetX ? e.offsetX : e.target ? e.clientX - e.target.x : 0;
  y = e.offsetY ? e.offsetY : e.target ? e.clientY - e.target.y : 0;
  partWidth = document.getElementById('colors').width / 6;
  partDetail = detail / 2;
  imHeight = document.getElementById('colors').height;
  r = (x >= 0) * (x < partWidth) * 255 + (x >= partWidth) * (x < 2 * partWidth) * (2 * 255 - x * 255 / partWidth) + (x >= 4 * partWidth) * (x < 5 * partWidth) * (-4 * 255 + x * 255 / partWidth) + (x >= 5 * partWidth) * (x < 6 * partWidth) * 255;
  g = (x >= 0) * (x < partWidth) * (x * 255 / partWidth) + (x >= partWidth) * (x < 3 * partWidth) * 255 + (x >= 3 * partWidth) * (x < 4 * partWidth) * (4 * 255 - x * 255 / partWidth);
  b = (x >= 2 * partWidth) * (x < 3 * partWidth) * (-2 * 255 + x * 255 / partWidth) + (x >= 3 * partWidth) * (x < 5 * partWidth) * 255 + (x >= 5 * partWidth) * (x < 6 * partWidth) * (6 * 255 - x * 255 / partWidth);
  coef = (imHeight - y) / imHeight;
  r = 128 + (r - 128) * coef;
  g = 128 + (g - 128) * coef;
  b = 128 + (b - 128) * coef;
  changeFinalColor('#' + dechex(r) + dechex(g) + dechex(b));
  updateLight(r, g, b);
}

function updateLight(r, g, b) {
  var i,
      partDetail = detail / 2,
      finalCoef,
      finalR,
      finalG,
      finalB,
      color;

  for (i = 0; i < detail; i++) {
    if (i >= 0 && i < partDetail) {
      finalCoef = i / partDetail;
      finalR = dechex(255 - (255 - r) * finalCoef);
      finalG = dechex(255 - (255 - g) * finalCoef);
      finalB = dechex(255 - (255 - b) * finalCoef);
    } else {
      finalCoef = 2 - i / partDetail;
      finalR = dechex(r * finalCoef);
      finalG = dechex(g * finalCoef);
      finalB = dechex(b * finalCoef);
    }

    color = finalR + finalG + finalB;
    setCol('gs' + i, '#' + color);
  }
}

function changeFinalColor(color) {
  if (color.indexOf('#') == -1) color = convertRGBToHex(color);
  setCol('preview', color);
  document.getElementById('color').value = color;
}

function setCol(e, c) {
  try {
    document.getElementById(e).style.backgroundColor = c;
  } catch (ex) {// Ignore IE warning
  }
}

tinyMCEPopup.onInit.add(init);