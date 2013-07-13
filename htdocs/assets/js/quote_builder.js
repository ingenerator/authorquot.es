/**
 * Integrates with jwplayer to create quote clips from a longer audio file
 *
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 *
 */

!function ($) {

    var QuoteBuilder = function(player, widget, toggle_button) {
        this.player = player;
        this.widget = widget;
        this.toggle_button = toggle_button;
    };

    QuoteBuilder.prototype = {

        constructor: QuoteBuilder

        , player: null

        , widget: null

        , toggle_button: null

        , start_field : null

        , end_field: null

        , _active: null

        , on_toggle: function QuoteBuilder_on_toggle() {
            switch (this._active) {
                case null:
                    this.start_quote();
                    break;
                case true:
                    this.stop_quote();
                    break;
                case false:
                    throw "didn't expect to be clicked when stopped";
                default:
                    throw "unexpected state";
            }
        }

        , start_quote: function QuoteBuilder_start_quote() {
            // Mark the start time and format as hours, minutes and seconds
            var position = this.player.getPosition();

            this.start_field = this.widget.find('input[name=start]');
            this.end_field = this.widget.find('input[name=end]');
            this.start_field.val(this._formatTime(position));

            // Show the edit form and store class state
            this.widget.addClass('in');
            this._active = true;

            // Toggle the button and set the text
            this.toggle_button.button('toggle');
            this.toggle_button.button('active');
            this.toggle_button.addClass('btn-success');

            // Attach the timestamp handler to the end-time field
            this.player.onTime(this.on_player_time.bind(this));
        }

        , on_player_time: function QuoteBuilder_on_player_time(event) {

            if (this._active == true) {
                // If active = true we're waiting to mark the end - update the end time field
                this.end_field.val(this._formatTime(event.position));
            } else if (this._active == false) {
                // If active = false the end is marked - don't play past it
                var end_time = this._parseTime(this.end_field.val());
                if (event.position > end_time) {
                    this.player.pause();
                }
            }
        }

        , stop_quote: function QuoteBuilder_on_stop_quote() {

            // Update state
            this._active = false;

            // Hide the toggle button for now - nasty UI but it works at the moment
            this.toggle_button.hide();

            // Stop the player and seek back to the start
            this.player.pause();
            this.player.seek(this._parseTime(this.start_field.val()));

            // Focus the start time field
            this.start_field.focus();
        }

        , play_preview: function QuoteBuilder_on_preview_quote() {
            // If waiting to mark, stop the marker, otherwise just seek to the start
            if (this._active == true) {
                this.stop_quote();
                this.player.play();
            } else {
                this.player.seek(this._parseTime(this.start_field.val()));
            }
        }

        , move_marker: function QuoteBuilder_on_move_marker(marker, dir) {
            if (this._active == true)
            {
                this.stop_quote();
            }

            var increment = (dir == 'fwd') ? 1 : -1;

            // Update the position marker
            var field = (marker == 'start') ? this.start_field : this.end_field;
            var current_psn = this._parseTime(field.val());
            var new_psn = current_psn + increment;
            field.val(this._formatTime(new_psn));

            if (marker === 'start') {
                // Play from the start marker
                this.player.seek(new_psn);
            } else {
                // Play the last 5 seconds
                this.player.seek(new_psn - 3);
            }
        }

        , _formatTime: function QuoteBuilder_format_time(seconds) {
            var date = new Date(seconds * 1000);

            var hh = date.getHours();
            var mm = date.getMinutes();
            var ss = date.getSeconds();

            if (mm < 10) {mm = "0"+mm;}
            if (ss < 10) {ss = "0"+ss;}
            return hh+':'+mm+':'+ss;
        }

        , _parseTime: function QuoteBuilder_parse_time(hms) {
            var parts = hms.split(':');
            return (+parts[0] * 3600) + (+parts[1] * 60) + (+parts[2]);
        }



    };

    /**
     * Attach the click handler for clicking on the start button
     */
    $(document).on('click.quotebuilder.start', '#new-quote-toggle', function qb_on_toggle(e) {
       var new_quote = $('#new-quote').first();

       if ( ! window.quote_builder) {
           window.quote_builder = new QuoteBuilder(jwplayer(), new_quote, $(this));
       }

       window.quote_builder.on_toggle();
       e.preventDefault();
    });

    /**
     * Attach the click handlers for the seek buttons
     */
    $(document).on('click.quotebuilder.seek', '.btn.quote-seek', function qb_on_seek(e) {
        var $this = $(this);

        var marker = $this.data('quote-seek');
        var dir = $this.data('quote-seek-dir');

        window.quote_builder.move_marker(marker, dir);
    });

    /**
     * Attach the click handler for the quote preview play button
     */
    $(document).on('click.quotebuilder.preview', '.btn.quote-preview', function qb_on_preview(e) {
        window.quote_builder.play_preview();
    });


}(window.jQuery);
