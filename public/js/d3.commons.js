$(function() {
	
	$.d3POST = function(path,params,callback,async){

        var _async = async==undefined?true:false;

        NProgress.start();

        $.ajax({
            async: _async,
            url: path,
            data: params,
            type: "post",
            cache: true,
            dataType: "json",
            success: function (data) {
                NProgress.done();
                callback(data);
            }
        });
    };

    $.d3pdPOST = function(path,params,callback,async){

        var _async = async==undefined?true:false;

        NProgress.start();

        $.ajax({
            async: _async,
            url: path,
            data: params,
            type: "post",
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (data) {
                NProgress.done();
                callback(data);
            }
        });
    };

    $.d3GET = function(path,params,callback,async){

        var _async = async==undefined?true:false;

        NProgress.start();

        $.ajax({
            async: _async,
            url: path,
            data: params,
            type: "get",
            cache: true,
            dataType: "json",
            success: function (data) {
                NProgress.done();
                callback(data);
            }
        });
    };

    // Similar al str_replace de php
    $.str_replace = function(busca, repla, orig) {
        str     = new String(orig);

        rExp    = "/"+busca+"/g";
        rExp    = eval(rExp);
        newS    = String(repla);

        str = new String(str.replace(rExp, newS));

        return str;
    };

    $.validateEmail = function(email) { 
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    $.ucwords = function(str) {
      return (str + '')
        .replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1) {
          return $1.toUpperCase();
        });
    }

    // Carga de categorias
    $.loadCategories = function(options, selected, _default) {

        var _data = undefined;

        if(options==undefined) {
            console.log('No se a proporcionado un selector');
            return false;
        }

        $.d3POST('/products/category/load',{},function(data){
            if(data.status==true) _data = data;
        }, false);

        if(_data!=undefined) {
            if(options instanceof Array) {
                $.each(options, function(i, item){
                    $.loadCatHandler(_data, item, selected, _default);
                });
            } else $.loadCatHandler(_data, options, selected, _default);
        }

    };
    $.loadCatHandler = function(data, options, selected, _default) {

        options.empty();

        if(data.categories.length > 0) {
            var _select = '';
            if(_default!=undefined) _select += '<option value="0">Seleccionar</option>';
            $.each(data.categories, function(i, item) {
                _select += '<option value="' + item.id + '" ' + (selected!=undefined && selected==item.id?'selected':'') + '>' + item.name + '</option>';
            });
            options.append(_select);
        }

    };

    // Carga de sub categorias
    $.loadSubCategories = function(options, category_id, selected) {

        if(options==undefined) {
            console.log('No se a proporcionado un selector');
            return false;
        }

        if(category_id==undefined) {
            console.log('No se a proporcionado un id de categoria');
            return false;
        }

        options.empty();

        $.d3POST('/products/sub_categories/load',{id:category_id},function(data){
            if(data.status==true) {
                if(data.sub_categories.length > 0) {
                    var _select = '';
                    $.each(data.sub_categories, function(i, item) {
                        _select += '<option value="' + item.id + '" ' + (selected!=undefined && selected==item.id?'selected':'') + '>' + item.name + '</option>';
                    });
                    options.append(_select);
                }
            }
        });

    };

    // Carga de categorias con sub-categorias
    $.loadComplexCategories = function(options) {

        var _data = undefined;

        if(options==undefined) {
            console.log('No se a proporcionado un selector');
            return false;
        }

        $.d3POST('/products/complex_categories/load',{},function(data){
            if(data.status==true) _data = data;
        }, false);

        if(_data!=undefined) {
            if(options instanceof Array) {
                $.each(options, function(i, item){
                    $.loadComplexCatHandler(_data, item);
                });
            } else $.loadComplexCatHandler(_data, options);
        }

    };
    $.loadComplexCatHandler = function(data, options) {

        options.empty();

        if(data.complex_categories.length > 0) {
            var _select = '';
            $.each(data.complex_categories, function(i, item) {
                if(item.subs.length > 0) {
                    _select += '<optgroup label="' + item.name + '">';
                    $.each(item.subs, function(y, ytem) {
                        _select += '<option value="' + ytem.id + '">' + ytem.name + '</option>';
                    });
                    _select += '<optgroup>';
                }
            });
            options.append(_select);
        }

    };

    // Carga de materiales
    $.loadMaterials = function(options, selected) {

        var _data = undefined;

        if(options==undefined) {
            console.log('No se a proporcionado un selector');
            return false;
        }

        $.d3POST('/products/materials/load',{},function(data){
            if(data.status==true) _data = data;
        }, false);

        if(_data!=undefined) {
            if(options instanceof Array) {
                $.each(options, function(i, item){
                    $.loadMatHandler(_data, item);
                });
            } else $.loadMatHandler(_data, options, selected);
        }

    };
    $.loadMatHandler = function(data, options, selected) {

        options.empty();

        if(data.items.length > 0) {
            var _select = '';
            $.each(data.items, function(i, item) {
                _select += '<option value="' + item.id + '" ' + (selected!=undefined && selected==item.id?'selected':'') + '>' + item.name + '</option>';
            });
            options.append(_select);
        }

    };

    // Carga de tallas
    $.loadSizes = function(options, selected) {

        var _data = undefined;

        if(options==undefined) {
            console.log('No se a proporcionado un selector');
            return false;
        }

        $.d3POST('/products/sizes/load',{},function(data){
            if(data.status==true) _data = data;
        }, false);

        if(_data!=undefined) {
            if(options instanceof Array) {
                $.each(options, function(i, item){
                    $.loadSizesHandler(_data, item);
                });
            } else $.loadSizesHandler(_data, options, selected);
        }

    };
    $.loadSizesHandler = function(data, options, selected) {

        options.empty();

        if(data.items.length > 0) {
            var _select = '';
            $.each(data.items, function(i, item) {
                _select += '<option value="' + item.id + '" ' + (selected!=undefined && selected==item.id?'selected':'') + '>' + item.size + '</option>';
            });
            options.append(_select);
        }

    };

    // Carga de colores
    $.loadColors = function(options, selected) {

        var _data = undefined;

        if(options==undefined) {
            console.log('No se a proporcionado un selector');
            return false;
        }

        $.d3POST('/products/colors/load',{},function(data){
            if(data.status==true) _data = data;
        }, false);

        if(_data!=undefined) {
            if(options instanceof Array) {
                $.each(options, function(i, item){
                    $.loadColorsHandler(_data, item);
                });
            } else $.loadColorsHandler(_data, options, selected);
        }

    };
    $.loadColorsHandler = function(data, options, selected) {

        options.empty();

        if(data.items.length > 0) {
            var _select = '';
            $.each(data.items, function(i, item) {
                _select += '<option value="' + item.id + '" ' + (selected!=undefined && selected==item.id?'selected':'') + '>' + item.name + '</option>';
            });
            options.append(_select);
        }

    };
});

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    },
    iPhone: function() {
        return navigator.userAgent.match(/iPhone/i);
    }
};

// Create Base64 Object
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}