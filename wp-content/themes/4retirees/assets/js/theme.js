!(function($) {

    $(function() {

        var compat_check_modal= $('#compatability-check-modal');

        var CC = {

            // active test results...
            checklist_results: {},

            set_question_values: function(data, modal, next) {
                if (typeof data == 'undefined') {
                    return false;
                }

                var left  = {};
                var right = {};

                next = parseInt(next, 10);

                left[data.hash] = data.values.left;
                right[data.hash] = data.values.right;

                modal.find('.modal-body').attr(
                    'data-question-args',
                    JSON.stringify(data)
                );

                modal.find('.question').text(
                    data.question
                );

                modal.find('.action-left').attr('data-key', data.hash);
                modal.find('.action-left').attr('data-value', data.values.left);

                modal.find('.action-left').attr(
                    'data-action-left',
                    JSON.stringify( left )
                ).text(data.values.left);

                modal.find('.action-right').attr(
                    'data-key',
                    data.hash
                );

                modal.find('.action-right').attr(
                    'data-value',
                    data.values.right
                );

                modal.find('.action-right').attr(
                    'data-action-right',
                    JSON.stringify( right )
                ).text(data.values.right);

                modal.find('.action-back').attr(
                    'data-prev-question',
                    next == 0 ? next : next -1
                );

                modal.find('.action-next').attr(
                    'data-next-question',
                    next == 0 ? next + 1 : next
                );

                modal.find('.questions-progress span').text(next == 0 ? 1 : next);
            },

            disable_pagination: function() {
                compat_check_modal.find('.action-next').prop('disabled', true);
                compat_check_modal.find('.action-back').prop('disabled', true);
            },

            enable_pagination: function() {
                compat_check_modal.find('.action-next').prop('disabled', '');
                compat_check_modal.find('.action-back').prop('disabled', '');
            },

            next_question: function(context) {

                var position = parseInt( context.attr('data-next-question'), 10 );

                if ( position > theme_vars.questions.length ) {
                    return false;
                }

                CC.set_question_values(
                    theme_vars.questions[position],
                    compat_check_modal, position + 1
                );

                CC.maybe_preselect_answer();
            },

            prev_question: function(context) {

                var position = parseInt( context.attr('data-prev-question'), 10 );

                if ( position < 0 ) {
                    return;
                }

                position = position > 0 ? position - 1 : 0;

                CC.set_question_values(
                    theme_vars.questions[position],
                    compat_check_modal, position
                );

                CC.maybe_preselect_answer();
            },

            reset_answer_controls: function() {
                var cols = compat_check_modal.find('.question-actions .col');
                cols.removeClass('selected');
                cols.find('span').remove();
            },

            // when user pages prev/next pre-select questions already answered
            maybe_preselect_answer: function() {

                $.each(CC.checklist_results, function(key, value) {

                    var selector = '[data-key="'+ key + '"][data-value="'+ value + '"]';

                    if ( compat_check_modal.find(selector).length > 0 ) {
                        compat_check_modal.find(selector).trigger('click');
                    }

                });

            },

            adjust_progress_meter: function() {
                compat_check_modal.find('.question-progress-advanced').css(
                    'width',
                    ((CC.count_completed_questions() / theme_vars.questions_total) * 100) + '%'
                );
            },

            has_completed_questions: function() {
                return CC.count_completed_questions() === parseInt( theme_vars.questions_total, 10 );
            },

            count_completed_questions: function() {
                var length = 0;

                for( var key in CC.checklist_results ) {
                    if( CC.checklist_results.hasOwnProperty(key) ) {
                        ++length;
                    }
                }

                return length;
            }

        };

        compat_check_modal.on('show.bs.modal', function (event) {

            var invoker = $(event.relatedTarget);

            CC.set_question_values(theme_vars.questions[0], compat_check_modal, 0);

        });

        compat_check_modal.on('click', '.action-left', function(event) {
            var col = $(this).closest('.col');

            CC.reset_answer_controls();
            col.addClass('selected');
            col.append('<span>SELECTED <i class="fa fa-check"></i></span>');

            $.extend(CC.checklist_results, JSON.parse( $(this).attr('data-action-left') ) );

            $(document).trigger('checklist_results_added');
        });

        compat_check_modal.on('click', '.action-right', function(event) {
            var col = $(this).closest('.col');

            CC.reset_answer_controls();
            col.addClass('selected');
            col.append('<span>SELECTED <i class="fa fa-check"></i></span>');

            $.extend(CC.checklist_results, JSON.parse( $(this).attr('data-action-right') ) );

            $(document).trigger('checklist_results_added');
        });

        compat_check_modal.on('click', '.action-next', function(event) {

            if ( CC.has_completed_questions() ) {

                compat_check_modal.find('.modal-hideable').hide();
                compat_check_modal.find('.check-complete').show();
                return false;
            }

            CC.reset_answer_controls();

            CC.disable_pagination();

            CC.next_question($(this));

            CC.enable_pagination();

            CC.adjust_progress_meter();

        });

        compat_check_modal.on('click', '.action-back', function(event) {

            CC.reset_answer_controls();

            CC.disable_pagination();

            CC.prev_question($(this));

            CC.enable_pagination();

            CC.adjust_progress_meter();

        });

        $(document).on('checklist_results_added', function (event) {
            CC.adjust_progress_meter();
        });

        $('form#get-results').on('click', 'button', function (event) {
            event.preventDefault();

            var form = $(this).closest('form');

            $.ajax({
                type: "post",
                url: theme_vars.ajax_url,
                data: {
                    action: 'cc_get_results',
                    check: CC.checklist_results,
                    questions: theme_vars.questions,
                    form: form.serialize(),
                },
            }).done(function(response) {

                if ( response.hasOwnProperty('success') && response.success ) {

                    if ( response.data.response_count > 0 ) {

                        var buy_screen = compat_check_modal.find('.check-buy');

                        // hide check complete screen
                        compat_check_modal.find('.check-complete').hide();

                        // add matches
                        buy_screen.find('.count-row .count').text( response.data.response_count );
                        buy_screen.find('.target-count').text( response.data.response_count );

                        // add value
                        buy_screen.find('.estimated').text( '$' + response.data.response_value );
                        buy_screen.find('.target-amount').text( response.data.response_value );

                        // show buy screen
                        buy_screen.show();

                    } else {

                        compat_check_modal.find('.check-complete').hide();
                        compat_check_modal.find('.check-noop').show();

                    }

                }
            }).fail(function(message) {

            }).always(function(message) {

            })
        });

    });

})(jQuery);