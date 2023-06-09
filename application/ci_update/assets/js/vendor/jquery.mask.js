(function ($) {
    "use strict";
    var Mask = function (el, mask, options) {
        var jMask = this,
            el = $(el),
            old_value;
        
        mask = typeof mask == "function" ? mask(el.val(), options) : mask;

        jMask.init = function() {
            options = options || {};
            
            jMask.byPassKeys = [8, 9, 37, 38, 39, 40, 46];
            jMask.translation = {
                '0': {pattern: /\d/}, 
                '9': {pattern: /\d/, optional: true}, 
                '#': {pattern: /\d/, recursive: true}, 
                'A': {pattern: /[a-zA-Z0-9]/}, 
                'S': {pattern: /[a-zA-Z]/}
            };

            jMask.translation = $.extend({}, jMask.translation, options.translation);
            jMask = $.extend(true, {}, jMask, options);

            el.each(function() {
                if (options.maxlength !== false)
                    el.attr('maxlength', mask.length);
                
                el.attr('autocomplete', 'off');
                p.destroyEvents();
                p.events();
                p.val(p.getMasked()); 
            });
        };

        var p = {
            events: function() {
                el.on('keydown.mask', function() {
                    old_value = p.val();
                });
                el.on('keyup.mask', p.behaviour);
                el.on("paste.mask", function() {
                    setTimeout(function() {
                        el.keydown().keyup();
                    }, 100);
                });
            },
            destroyEvents: function() {
                el.off('keydown.mask').off("keyup.mask").off("paste.mask");
            },
            val: function(v) {
                var isInput = el.get(0).tagName.toLowerCase() === "input";
                return arguments.length > 0 ? (isInput ? el.val(v) : el.text(v)) : (isInput ? el.val() : el.text());
            },
            behaviour: function(e) {
                e = e || window.event;
                if ($.inArray(e.keyCode || e.which, jMask.byPassKeys) === -1) {
                    p.val(p.getMasked());
                    return p.callbacks(e);
                }
            },
            getMasked: function () {
                var buf = [],
                    value = p.val(),
                    m = 0, maskLen = mask.length,
                    v = 0, valLen = value.length,
                    offset = 1, addMethod = "push",
                    resetPos = -1,
                    lastMaskChar,
                    check;

                if (options.reverse) {
                    addMethod = "unshift";
                    offset = -1;
                    lastMaskChar = 0;
                    m = maskLen - 1;
                    v = valLen - 1;
                    check = function () {
                        return m > -1 && v > -1;
                    };
                } else {
                    lastMaskChar = maskLen - 1;
                    check = function () {
                        return m < maskLen && v < valLen;
                    };
                }

                while (check()) { 
                    var maskDigit = mask.charAt(m),
                        valDigit = value.charAt(v),
                        translation = jMask.translation[maskDigit];

                    if (translation) {
                        if (valDigit.match(translation.pattern)) {
                            buf[addMethod](valDigit);
                             if (translation.recursive) {
                                if (resetPos == -1) {
                                    resetPos = m;   
                                } else if (m == lastMaskChar) {
                                    m = resetPos - offset;
                                }
                                if (lastMaskChar == resetPos) 
                                    m -= offset;
                            }
                            m += offset;
                        } else if (translation.optional) {
                            m += offset;
                            v -= offset;
                        }
                        v += offset;
                    } else {
                        buf[addMethod](maskDigit);
                        if (valDigit == maskDigit)
                            v += offset;
                        m += offset;
                    }
                }
                return buf.join("");
            },
            callbacks: function (e) {
                var val = p.val(),
                    changed = p.val() !== old_value;
                if (changed === true){
                    if (typeof options.onChange == "function")
                        options.onChange(val, e, el, options);
                } 
                         
                if (changed === true && typeof options.onKeyPress == "function")
                    options.onKeyPress(val, e, el, options);

                if (typeof options.onComplete === "function" && val.length === mask.length)
                    options.onComplete(val, e, el, options);
            }
        };

        // public methods
        jMask.remove = function() {
          p.destroyEvents();
          p.val(jMask.getCleanVal()).removeAttr('maxlength');
        };
        
        // get value without mask
        jMask.getCleanVal = function() {
            var buf = [],
                string = p.val();
            for (var m = 0, mLen = mask.length; m < mLen; m++) {
                if (jMask.translation[mask.charAt(m)])
                    buf["push"](string.charAt(m));
            }
            return buf.join("");
        };

        jMask.init();
    };

    $.fn.mask = function(mask, options) {
        return this.each(function() {
            $(this).data('mask', new Mask(this, mask, options));
        });
    };

    $.fn.unmask = function() {
        return this.each(function() {
            $(this).data('mask').remove();
        });
    };

    // looking for inputs with data-mask attribute
    $('input[data-mask]').each(function() {
        $(this).mask($(this).attr('data-mask'));
    });
   
})(window.jQuery || window.Zepto);