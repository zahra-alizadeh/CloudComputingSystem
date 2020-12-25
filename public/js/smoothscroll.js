/**
 * SmoothScroll
 * This helper script created by DWUser.com.  Copyright 2013 DWUser.com.  
 * Dual-licensed under the GPL and MIT licenses.  
 * All individual scripts remain property of their copyrighters.
 * Date: 10-Sep-2013
 * Version: 1.0.1
 */
if (!window['jQuery']) alert('The jQuery library must be included before the smoothscroll.js file.  The plugin will not work propery.');

/**
 * jQuery.ScrollTo - Easy element scrolling using jQuery.
 * Copyright (c) 2007-2013 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * @author Ariel Flesler
 * @version 1.4.3.1
 */
;
(function($) { var h = $.scrollTo = function(a, b, c) { $(window).scrollTo(a, b, c) };
    h.defaults = { axis: 'xy', duration: parseFloat($.fn.jquery) >= 1.3 ? 0 : 1, limit: true };
    h.window = function(a) { return $(window)._scrollable() };
    $.fn._scrollable = function() { return this.map(function() { var a = this,
                isWin = !a.nodeName || $.inArray(a.nodeName.toLowerCase(), ['iframe', '#document', 'html', 'body']) != -1; if (!isWin) return a; var b = (a.contentWindow || a).document || a.ownerDocument || a; return /webkit/i.test(navigator.userAgent) || b.compatMode == 'BackCompat' ? b.body : b.documentElement }) };
    $.fn.scrollTo = function(e, f, g) { if (typeof f == 'object') { g = f;
            f = 0 } if (typeof g == 'function') g = { onAfter: g }; if (e == 'max') e = 9e9;
        g = $.extend({}, h.defaults, g);
        f = f || g.duration;
        g.queue = g.queue && g.axis.length > 1; if (g.queue) f /= 2;
        g.offset = both(g.offset);
        g.over = both(g.over); return this._scrollable().each(function() { if (e == null) return; var d = this,
                $elem = $(d),
                targ = e,
                toff, attr = {},
                win = $elem.is('html,body'); switch (typeof targ) {
                case 'number':
                case 'string':
                    if (/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(targ)) { targ = both(targ); break }
                    targ = $(targ, this); if (!targ.length) return;
                case 'object':
                    if (targ.is || targ.style) toff = (targ = $(targ)).offset() }
            $.each(g.axis.split(''), function(i, a) { var b = a == 'x' ? 'Left' : 'Top',
                    pos = b.toLowerCase(),
                    key = 'scroll' + b,
                    old = d[key],
                    max = h.max(d, a); if (toff) { attr[key] = toff[pos] + (win ? 0 : old - $elem.offset()[pos]); if (g.margin) { attr[key] -= parseInt(targ.css('margin' + b)) || 0;
                        attr[key] -= parseInt(targ.css('border' + b + 'Width')) || 0 }
                    attr[key] += g.offset[pos] || 0; if (g.over[pos]) attr[key] += targ[a == 'x' ? 'width' : 'height']() * g.over[pos] } else { var c = targ[pos];
                    attr[key] = c.slice && c.slice(-1) == '%' ? parseFloat(c) / 100 * max : c } if (g.limit && /^\d+$/.test(attr[key])) attr[key] = attr[key] <= 0 ? 0 : Math.min(attr[key], max); if (!i && g.queue) { if (old != attr[key]) animate(g.onAfterFirst);
                    delete attr[key] } });
            animate(g.onAfter);

            function animate(a) { $elem.animate(attr, f, g.easing, a && function() { a.call(this, e, g) }) } }).end() };
    h.max = function(a, b) { var c = b == 'x' ? 'Width' : 'Height',
            scroll = 'scroll' + c; if (!$(a).is('html,body')) return a[scroll] - $(a)[c.toLowerCase()](); var d = 'client' + c,
            html = a.ownerDocument.documentElement,
            body = a.ownerDocument.body; return Math.max(html[scroll], body[scroll]) - Math.min(html[d], body[d]) };

    function both(a) { return typeof a == 'object' ? a : { top: a, left: a } } })(jQuery);

/**
 * jQuery.LocalScroll
 * Copyright (c) 2007-2010 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 05/31/2010
 * @author Ariel Flesler
 * @version 1.2.8b
 **/
;
(function(b) {
    function g(a, e, d) {
        var h = e.hash.slice(1),
            f = document.getElementById(h) || document.getElementsByName(h)[0];
        if (f) {
            a && a.preventDefault();
            var c = b(d.target);
            if (!(d.lock && c.is(":animated") || d.onBefore && !1 === d.onBefore(a, f, c))) {
                d.stop && c._scrollable().stop(!0);
                if (d.hash) { var a = f.id == h ? "id" : "name",
                        g = b("<a> </a>").attr(a, h).css({ position: "absolute", top: b(window).scrollTop(), left: b(window).scrollLeft() });
                    f[a] = "";
                    b("body").prepend(g);
                    location = e.hash;
                    g.remove();
                    f[a] = h }
                c.scrollTo(f, d).trigger("notify.serialScroll", [f])
            }
        }
    }
    var i = location.href.replace(/#.*/, ""),
        c = b.localScroll = function(a) { b("body").localScroll(a) };
    c.defaults = { duration: 1E3, axis: "y", event: "click", stop: !0, target: window, reset: !0 };
    c.hash = function(a) { if (location.hash) { a = b.extend({}, c.defaults, a);
            a.hash = !1; if (a.reset) { var e = a.duration;
                delete a.duration;
                b(a.target).scrollTo(0, a);
                a.duration = e }
            g(0, location, a) } };
    b.fn.localScroll = function(a) {
        function e() { return !!this.href && !!this.hash && this.href.replace(this.hash, "") == i && (!a.filter || b(this).is(a.filter)) }
        a = b.extend({}, c.defaults, a);
        return a.lazy ? this.bind(a.event, function(d) { var c = b([d.target, d.target.parentNode]).filter(e)[0];
            c && g(d, c, a) }) : this.find("a,area").filter(e).bind(a.event, function(b) { g(b, this, a) }).end().end()
    }
})(jQuery);

// Initialize all .smoothScroll links
jQuery(function($) { $.localScroll({ filter: '.smoothScroll' }); });

// File Upload
// 
function ekUpload() {
    function Init() {

        console.log("Upload Initialised");

        var fileSelect = document.getElementById('file-upload'),
            fileDrag = document.getElementById('file-drag'),
            submitButton = document.getElementById('submit-button');

        fileSelect.addEventListener('change', fileSelectHandler, false);

        // Is XHR2 available?
        var xhr = new XMLHttpRequest();
        if (xhr.upload) {
            // File Drop
            fileDrag.addEventListener('dragover', fileDragHover, false);
            fileDrag.addEventListener('dragleave', fileDragHover, false);
            fileDrag.addEventListener('drop', fileSelectHandler, false);
        }
    }

    function fileDragHover(e) {
        var fileDrag = document.getElementById('file-drag');

        e.stopPropagation();
        e.preventDefault();

        fileDrag.className = (e.type === 'dragover' ? 'hover' : 'modal-body file-upload');
    }

    function fileSelectHandler(e) {
        // Fetch FileList object
        var files = e.target.files || e.dataTransfer.files;

        // Cancel event and hover styling
        fileDragHover(e);

        // Process all File objects
        for (var i = 0, f; f = files[i]; i++) {
            parseFile(f);
            uploadFile(f);
        }
    }

    // Output
    function output(msg) {
        // Response
        var m = document.getElementById('messages');
        m.innerHTML = msg;
    }

    function parseFile(file) {

        console.log(file.name);
        output(
            '<strong>' + encodeURI(file.name) + '</strong>'
        );

        // var fileType = file.type;
        // console.log(fileType);
        var imageName = file.name;

        var isGood = (/\.(?=gif|jpg|png|jpeg)/gi).test(imageName);
        if (isGood) {
            document.getElementById('start').classList.add("hidden");
            document.getElementById('response').classList.remove("hidden");
            document.getElementById('notimage').classList.add("hidden");
            // Thumbnail Preview
            document.getElementById('file-image').classList.remove("hidden");
            document.getElementById('file-image').src = URL.createObjectURL(file);
        } else {
            document.getElementById('file-image').classList.add("hidden");
            document.getElementById('notimage').classList.remove("hidden");
            document.getElementById('start').classList.remove("hidden");
            document.getElementById('response').classList.add("hidden");
            document.getElementById("file-upload-form").reset();
        }
    }

    function setProgressMaxValue(e) {
        var pBar = document.getElementById('file-progress');

        if (e.lengthComputable) {
            pBar.max = e.total;
        }
    }

    function updateFileProgress(e) {
        var pBar = document.getElementById('file-progress');

        if (e.lengthComputable) {
            pBar.value = e.loaded;
        }
    }

    function uploadFile(file) {

        var xhr = new XMLHttpRequest(),
            fileInput = document.getElementById('class-roster-file'),
            pBar = document.getElementById('file-progress'),
            fileSizeLimit = 1024; // In MB
        if (xhr.upload) {
            // Check if file is less than x MB
            if (file.size <= fileSizeLimit * 1024 * 1024) {
                // Progress bar
                pBar.style.display = 'inline';
                xhr.upload.addEventListener('loadstart', setProgressMaxValue, false);
                xhr.upload.addEventListener('progress', updateFileProgress, false);

                // File received / failed
                xhr.onreadystatechange = function(e) {
                    if (xhr.readyState == 4) {
                        // Everything is good!

                        // progress.className = (xhr.status == 200 ? "success" : "failure");
                        // document.location.reload(true);
                    }
                };

                // Start upload
                xhr.open('POST', document.getElementById('file-upload-form').action, true);
                xhr.setRequestHeader('X-File-Name', file.name);
                xhr.setRequestHeader('X-File-Size', file.size);
                xhr.setRequestHeader('Content-Type', 'multipart/form-data');
                xhr.send(file);
            } else {
                output('Please upload a smaller file (< ' + fileSizeLimit + ' MB).');
            }
        }
    }

    // Check for the various File API support.
    if (window.File && window.FileList && window.FileReader) {
        Init();
    } else {
        document.getElementById('file-drag').style.display = 'none';
    }
}
ekUpload();