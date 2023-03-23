//--Film Info
jQuery(document).ready(function () {
    // rating
    var filmId = jQuery("#film_id").val();

    function scorehint(score) {
        var text = "";
        switch (parseInt(score)) {
            case 1:
                text = "1/10";
                break;
            case 2:
                text = "1/10";
                break;
            case 3:
                text = "3/10";
                break;
            case 4:
                text = "4/10";
                break;
            case 5:
                text = "5/10";
                break;
            case 6:
                text = "6/10";
                break;
            case 7:
                text = "7/10";
                break;
            case 8:
                text = "8/10";
                break;
            case 9:
                text = "9/10";
                break;
            default:
                text = "10/10";
        }
        return text;
    }
    jQuery('#star').raty({
        half: false,
        noRatedMsg: "You have already rated this movies",
        score: function () {
            return jQuery(this).attr('data-score');
        },

        mouseover: function (score, evt) {
            jQuery("#hint").html(scorehint(score));
        },
        mouseout: function (score, evt) {
            jQuery("#hint").html("");
        },
        click: function (score, evt) {
            jQuery.ajax({
                'url': URL_POST_RATING,
                xhrFields: {
                    withCredentials: true
                },
                headers: {
                    "Content-Type": "application/json",
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]')
                        .getAttribute(
                            'content')
                },
                'type': 'POST',
                'dataType': 'JSON',
                'data': JSON.stringify({
                    rating: score
                })
            }).done(function (data) {
                if (data.status) {
                    if (typeof data.rating_star != 'undefined') {
                        jQuery('.box-rating .average').html(data.rating_star);
                        jQuery('.box-rating #rate_count').html(data.rating_count);
                        jQuery('.box-rating #average').html(data.rating_star);
                        jQuery('.box-rating #div_average').show();
                        $('#star').raty('score', data.rating_star);
                        jQuery("#hint").html("");
                        $('#star').raty('readOnly', true);
                    }
                } else {
                    $('#star').raty('readOnly', true);
                }
            });

        }
    });
});
