+function ($) { "use strict";
    var Base = $.oc.foundation.base,
        BaseProto = Base.prototype

    var OsmLocation = function (element, options) {
        this.$el = $(element)
        this.$wrapper = $(element).parent('.location-input-wrapper');
        this.$n = this.$wrapper.data('n');
        this.options = options || {}

        $.oc.foundation.controlUtils.markDisposable(element)
        Base.call(this)
        this.init()
    }

    OsmLocation.prototype = Object.create(BaseProto)
    OsmLocation.prototype.constructor = OsmLocation

    OsmLocation.prototype.init = function() {
        this.$el.on('input', this.proxy(this.onInput))
        this.$el.one('dispose-control', this.proxy(this.dispose))
    }


    OsmLocation.prototype.dispose = function() {
        this.$el.off('input', this.proxy(this.onInput))
        this.$el.off('dispose-control', this.proxy(this.dispose))
        this.$el.removeData('oc.osmLocation')

        this.$el = null

        // In some cases options could contain callbacks, 
        // so it's better to clean them up too.
        this.options = null

        BaseProto.dispose.call(this)
    }

    OsmLocation.prototype.onInput = function() {
        if (this.dataTrackInputTimer !== undefined)
            window.clearTimeout(this.dataTrackInputTimer)

        var self = this
        this.dataTrackInputTimer = window.setTimeout(function() {

            if (self.lastDataTrackInputRequest) {
                self.lastDataTrackInputRequest.abort();
            }

            self.lastDataTrackInputRequest = $(self).request(self.$el.data('js-request'), {
                data: { currentLocation: $(self.$el).val() },
                success: function(data) {
                    self.$wrapper.find('#location-output').html(data);
                    self.$wrapper.find('#location-output input').on('change', function(e) {
                        self.$wrapper.find('#location-fields').html('');
                        var attrs = $(e.target).data();
                        for(const attr in attrs) {
                            self.$wrapper.find('#location-fields').append(`<input type="hidden" name="${self.$n}[${attr}]" value="${attrs[attr]}">`);
                        }

                        self.$el.val($(e.target).next('span').html());
                        self.$wrapper.find('#location-output').html('');
                    });
                }
            });
        }, 600)
    };

    OsmLocation.DEFAULTS = {
        someParam: null
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.osmLocation

    $.fn.osmLocation = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), items, result

        items = this.each(function () {
            var $this   = $(this)
            var data    = $this.data('oc.osmLocation')
            var options = $.extend({}, OsmLocation.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('oc.osmLocation', (data = new OsmLocation(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : items
    }

    $.fn.osmLocation.Constructor = OsmLocation

    $.fn.osmLocation.noConflict = function () {
        $.fn.osmLocation = old
        return this
    }

    // Add this only if required
    $(document).render(function (){
        $('[data-load-location]').osmLocation()
    })

}(window.jQuery);
