/*!
 * Facebook Wall Plugin
 *
 * COMMENTS:
 * Accepts a facebook user ID and app token to display the wall and public comments
 * for a facebook user.
 *
 * REQUISITES:
 * -- jQuery 1.4.4
 *
 * ADDITIONAL REQUIREMENTS:
 * -- Valid app token must be generated. Default is to have it rendered on page and accessed via #fbToken but it can be passed directly to the options argument
 * -- See echelonrace/docroot/css/global.css for sample CSS provisioning
 *
 * Authored by Spencer Gray
 */

(function ($) {
    var settings = {
        userID: 193361797343222,
        token: $('#fbToken').text(), // as of 5/27/11 facebook's graph api requires a valid app token: http://goo.gl/20eqw
        loadingGif: 'img/fb_loader.gif'
    };

    $.fn.fbFeed = function (options) {
        root = $(this),
        options = $.extend({}, settings, options);

    if (root.length) {
        loadFeed();
    }

    function loadFeed() {
        showLoadingGif();

        $.ajax({
            type : 'get',
            url : 'https://graph.facebook.com/'+options.userID+'/feed?access_token='+options.token+'&callback',
            dataType : 'jsonp',
            success : function(json) {

                for (var i in json.data) {
                    renderPost(buildPostObj(json.data[i]), i);
                }

                removeLoadingGif();
                handleClicks();
            }
        });
    }

    function buildPostObj(post) {
        return {
            user : post.from.name,
            userId : post.from.id,
            link : buildLink(post.link, post.name),
            icon : buildIcon(post.icon),
            message : post.message,
            time : parseTime(post.created_time),
            commentCount : commentCount(post),
            comments : post.comments,
            thumb : 'http://graph.facebook.com/'+post.from.id+'/picture'
        };
    }

    function commentCount(post) {
        post.comments && post.comments.count ? comments = post.comments.count : comments = 0;

        return comments;
    }

    function renderCommentCount(postObj) {
        if (postObj.commentCount > 0) {
            var comments = {};
            
            postObj.commentCount > 1 ? commentsTitle = 'comments' : commentsTitle = 'comment';
            comments.count = ' - <a class="comments" href="">'+ postObj.commentCount + ' ' + commentsTitle + '</a>';
            comments.comments = renderComments(postObj.comments.data);
        } else {
            var comments = '';
        }

        return comments;
    }

    function renderComments(comments) {
        var commentsArr = [];

        for (var i in comments) {
            var id = comments[i].id,
                user = comments[i].from.name,
                userId = comments[i].from.id,
                thumb = 'http://graph.facebook.com/'+userId+'/picture',
                message = comments[i].message,
                time = parseTime(comments[i].created_time);

            commentsArr.push('<li><img src="'+thumb+'" alt="'+user+'" /><div><p><a target="_blank" class="username" href="http://www.facebook.com/profile.php?id='+userId+'">' + user + '</a> '+message+'</p><p class="postDetails">'+time+'</p></div></li>');
        }

        return '<ul class="comments">'+commentsArr.join('')+'</ul>';
    }

    function buildIcon(postIcon) {
        !postIcon ? icon = '' : icon = '<img src="'+postIcon+'" alt="postIcon" /> ';

        return icon;
    }

    function buildLink(href, name) {
        !name ? name = 'View Photo' : name;

        if (href) {
            return '<p class="postLink"><a href="'+href+'">'+name+'</a></p>';
        } else {
            return '';
        }
    }

    function buildMessage(postObj) {
        if (postObj.message) {
            return '<p>' + postObj.message + '</p>';
        } else {
            return '';
        }
    }

    function renderPost(postObj, i) {
        var comments = renderCommentCount(postObj);
        
        if (typeof(comments) == 'object') {
            comments = comments.count + comments.comments;
        }

        var message = buildMessage(postObj),
            content = '<li id="fbPost'+i+'"><img src="'+postObj.thumb+'" alt="'+postObj.user+'" /><div><p><a target="_blank" class="username" href="http://www.facebook.com/profile.php?id='+postObj.userId+'">' + postObj.user + '</a></p>' + message + postObj.link+ '<p class="postDetails">'+postObj.icon+postObj.time + comments+'</p></div></li>';

        root.append(content);
    }

    function parseTime(time) {
        //Format: 2010-08-09T14:58:03+0000

        var date = time.split('T')[0].split('-'),
            year = date[0],
            month = handleZeroes(date[1]),
            day = date[2];

        return month + '/' + day  + '/' + year;
    }

    function handleZeroes(month) {
        if (month.charAt(0) == 0) {
            month = month.charAt(1);
        }
        return month;
    }

    function showLoadingGif() {
        root.before('<img id="fbLoadingGif" src="'+options.loadingGif+'" alt="loading" />');
    }

    function removeLoadingGif() {
        $('#fbLoadingGif').remove();
    }

    function handleClicks() {
        root.delegate('.comments','click', function(e) {
            e.preventDefault();

            var thisEl = $(this),
                comments = thisEl.parent().next();

            comments.fadeToggle(250);
        });
    }

    };
})(jQuery);