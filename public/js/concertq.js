(function($) {

    if (jQuery().isotope) {
        $.Isotope.prototype._masonryColumnShiftReset = function() {
            // layout-specific props
            var props = this.masonryColumnShift = {
                columnBricks: []
            };
            // FIXME shouldn't have to call this again
            this._getSegments();
            var i = props.cols;
            props.colYs = [];
            while (i--) {
                props.colYs.push(0);
                // push an array, for bricks in each column
                props.columnBricks.push([]);
            }
        };

        $.Isotope.prototype._masonryColumnShiftLayout = function($elems) {
            var
            instance = this,
                props = instance.masonryColumnShift;
            $elems.each(function() {
                var $brick = $(this);
                var setY = props.colYs;
                // get the minimum Y value from the columns
                var minimumY = Math.min.apply(Math, setY),
                    shortCol = 0;
                // Find index of short column, the first from the left
                for (var i = 0, len = setY.length; i < len; i++) {
                    if (setY[i] === minimumY) {
                        shortCol = i;
                        break;
                    }
                }

                // position the brick
                var x = props.columnWidth * shortCol,
                    y = minimumY;
                instance._pushPosition($brick, x, y);
                // keep track of columnIndex
                jQuery.data(this, 'masonryColumnIndex', i);
                props.columnBricks[i].push(this);
                // apply setHeight to necessary columns
                var setHeight = minimumY + $brick.outerHeight(true),
                    setSpan = props.cols + 1 - len;
                for (i = 0; i < setSpan; i++) {
                    props.colYs[shortCol + i] = setHeight;
                }

            });
        };

        $.Isotope.prototype._masonryColumnShiftGetContainerSize = function() {
            var containerHeight = Math.max.apply(Math, this.masonryColumnShift.colYs);
            return {
                height: containerHeight
            };
        };

        $.Isotope.prototype._masonryColumnShiftResizeChanged = function() {
            return this._checkIfSegmentsChanged();
        };

        $.Isotope.prototype.shiftColumnOfItem = function(itemElem, callback) {

            var columnIndex = jQuery.data(itemElem, 'masonryColumnIndex');
            // don't proceed if no columnIndex
            if (!isFinite(columnIndex)) {
                return;
            }

            var props = this.masonryColumnShift;
            var columnBricks = props.columnBricks[columnIndex];
            var $brick;
            var x = props.columnWidth * columnIndex;
            var y = 0;
            for (var i = 0, len = columnBricks.length; i < len; i++) {
                $brick = $(columnBricks[i]);
                this._pushPosition($brick, x, y);
                y += $brick.outerHeight(true);
            }

            // set the size of the container
            if (this.options.resizesContainer) {
                var containerStyle = this._masonryColumnShiftGetContainerSize();
                containerStyle.height = Math.max(y, containerStyle.height);
                this.styleQueue.push({
                    $el: this.element,
                    style: containerStyle
                });
            }

            this._processStyleQueue($(columnBricks), callback);
        };
    }


    $.fn.reIsotope = function(_element) {
        this.isotope('shiftColumnOfItem', _element);
    };

    $.fn.exists = String.prototype.exists = function() {
        return this.length > 0;
    };
})(jQuery);

$(function() {
    var Qpp = {
        body: $('body'),
        window: $(window),
        document: $(document),
        istp_elements: $('#performers-listing')
    };

    /*var adaptHeight = function() {
        if (Qpp.window.innerWidth() >= 979) {
            var $h = Qpp.window.innerHeight();
            $('#ticket-concertq-container').css('height', ($h - 70) + 'px');
            $('#concertq-listing-container').css('height', ($h - 70) + 'px');
        } else {
            $('#ticket-concertq-container,#concertq-listing-container').removeAttr('style');
        }
    };

    Qpp.window.on('debouncedresize', function() {
        adaptHeight();
    });

    adaptHeight();*/

    Qpp.document.on('click', function(e) {
        var $target = $('.tooltip');

        if (!$target.is(e.target) && $target.has(e.target).length === 0) {
            $target.hide();
        }
    });

    Qpp.body.on('click', '#filter-sections,#filter-brokers,#filter-cities,#filter-venues', function() {
        var $$ = $(this);

        $('.filter-list,.filter-home').children('a').not($$).removeClass('showed').next().hide();

        if ($$.hasClass('showed')) {
            $$.removeClass('showed').next().hide();
        } else {
            $$.addClass('showed').next().show();
            if ($$.next().find('ul').hasClass('jscroll')) {
                $$.next().find('ul').jScrollPane();
            }
        }

        return false;
    })

    .on('click', '.note-ticket > em', function(event) {
        event.preventDefault();

        var $$ = $(this);

        $('.note-ticket').children('em').not($$).removeClass('showed').next().hide();

        if ($$.hasClass('showed')) {
            $$.removeClass('showed').next().hide();
        } else {
            $$.addClass('showed').next().show();
        }
    })

    .on('click', '#affected-filters span', function(e) {
        e.preventDefault();
        var $$ = $(this);

        $$.remove();
    })

    .on('mouseenter mouseleave', '.performer-box', function(event) {
        var $$ = $(this);

        if (event.type === 'mouseenter') {
            $$.find('footer').stop(true, true).delay(100).slideDown('fast', function() {
                //Qpp.istp_elements.reIsotope($$.get(0));
                //$('#performers-listing').masonry( 'layout' );
                

            });
        } else {
            $$.find('footer').stop(true, true).delay(100).slideUp('fast', function() {
                //Qpp.istp_elements.reIsotope($$.get(0));
                //$('#performers-listing').masonry( 'layout' );
            });
        }

    });

    $range_price = $('#range-price');
    if ($range_price.exists()) {
        $range_price.noUiSlider({
            range: [$range_price.data('minprice'), $range_price.data('maxprice')],
            start: [0, $range_price.data('maxprice')],
            handles: 2,
            step: 1,
            margin: 20,
            connect: true,
            direction: 'ltr',
            orientation: 'horizontal',
            behaviour: 'tap-drag',
            serialization: {
                mark: '',
                resolution: 0.1,
                to: [$('#min-price-tickets'), $('#max-price-tickets')]
            }
        });
    }

    if ($('#zoom-range').exists()) {
        $('#zoom-range').noUiSlider({
            range: [1, 10],
            start: 0,
            step: 1,
            margin: 20,
            handles: 1,
            direction: 'rtl',
            orientation: 'vertical',
            behaviour: 'tap-drag'
        });
    }

    Qpp.window
    /*.on('scroll', function() {
            var $$ = $(this),
                $parent = $('#parent-header');

            if ($$.scrollTop() > 56) {
                $('body').css('padding-top', $parent.innerHeight() + 'px');
                $parent.addClass('fixed-scroll');
            } else {
                $('body').css('padding-top', 0);
                $parent.removeClass('fixed-scroll');
            }
        })*/
    .load(function() {
        if (jQuery().isotope) {
            Qpp.istp_elements.isotope({
                itemSelector: '.performer-box',
                layoutMode: 'masonrysqdfqs',
                transformsEnabled: false,
                resizable: true,
                masonry: {
                    columnWidth: 225
                }
            });
        }


        /*Qpp.istp_elements.infinitescroll({
                itemSelector: 'div.product',
                nextSelector: '#navigation-scroll a:first',
                navSelector: '#navigation-scroll',
                loading: {
                    finishedMsg: '',
                    img: 'assets/imgs/loading.gif'
                }
            },
            function($elements) {
                app.isotope_containers.isotope('appended', $($elements));
            });*/
    });
});