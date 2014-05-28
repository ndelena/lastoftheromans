function hideDocumentElement(id) {
    var el = document.getElementById(id);
    if (el) el.style.display = 'none';
}

function showDocumentElement(id) {
    var el = document.getElementById(id);
    if (el) el.style.display = 'block';
}

function showAnonymousForm() {
    showDocumentElement('comments-form');

}


var commenter_name;
var commenter_blog_ids;
var is_preview;
var mtcmtmail;
var mtcmtauth;
var mtcmthome;

function individualArchivesOnLoad(commenter_name) {





    
    if ( commenter_name &&
         ( !commenter_id
        || commenter_blog_ids.indexOf("'1'") > -1))
    {
        hideDocumentElement('comment-form-name');
        hideDocumentElement('comment-form-email');
        showDocumentElement('comments-open-text');
        showDocumentElement('comments-open-footer');
    } else {
        hideDocumentElement('comments-open-data');
        hideDocumentElement('comments-open-text');
        hideDocumentElement('comments-open-footer');
    }
    


    if (document.comments_form) {
        if (!commenter_name && (document.comments_form.email != undefined) &&
            (mtcmtmail = getCookie("mtcmtmail")))
            document.comments_form.email.value = mtcmtmail;
        if (!commenter_name && (document.comments_form.author != undefined) &&
            (mtcmtauth = getCookie("mtcmtauth")))
            document.comments_form.author.value = mtcmtauth;
        if (document.comments_form.url != undefined &&
            (mtcmthome = getCookie("mtcmthome")))
            document.comments_form.url.value = mtcmthome;
        if (document.comments_form["bakecookie"]) {
            if (mtcmtauth || mtcmthome) {
                document.comments_form.bakecookie.checked = true;
            } else {
                document.comments_form.bakecookie.checked = false;
            }
        }
    }
}

function writeCommenterGreeting(commenter_name, entry_id, blog_id, commenter_id, commenter_url) {

    if ( commenter_name &&
         ( !commenter_id
        || commenter_blog_ids.indexOf("'" + blog_id + "'") > -1))
    {
        var url;
        if (commenter_id) {
            url = 'http://lastoftheromans.org/cgi-bin/mt-comments.cgi?__mode=edit_profile&commenter=' + commenter_id + '&blog_id=' + blog_id;
            if (entry_id) {
                url += '&entry_id=' + entry_id;
            } else {
                url += '&static=1';
            }
        } else if (commenter_url) {
            url = commenter_url;
        } else {
            url = null;
        }
        var content = 'Thanks for signing in, ';
        if (url) {
            content += '<a href="' + url + '">' + commenter_name + '</a>';
        } else {
            content += commenter_name;
        }
        content += '. Now you can comment. (<a href="http://lastoftheromans.org/cgi-bin/mt-comments.cgi?__mode=handle_sign_in&amp;static=1&amp;logout=1&entry_id=' + entry_id + '">sign out</a>)';
        document.write(content);
    } else if (commenter_name) {
            document.write('You do not have permission to comment on this blog. (<a href="http://lastoftheromans.org/cgi-bin/mt-comments.cgi?__mode=handle_sign_in&amp;static=1&amp;logout=1&entry_id=' + entry_id + '">sign out</a>)');
    } else {

        document.write('<a href="http://lastoftheromans.org/cgi-bin/mt-comments.cgi?__mode=login&entry_id=' + entry_id + '&blog_id=' + blog_id + '&static=1">Sign in' + '</a>' + ' to comment on this entry.');

    }

}


if ('lastoftheromans.org' != 'lastoftheromans.org') {
    document.write('<script src="http://lastoftheromans.org/cgi-bin/mt-comments.cgi?__mode=cmtr_name_js&blog_id=1"></script>');
} else {
    commenter_name = getCookie('commenter_name');
    ids = getCookie('commenter_id').split(':');
    commenter_id = ids[0];
    commenter_blog_ids = ids[1];
    commenter_url = getCookie('commenter_url');
}



// Copyright (c) 1996-1997 Athenia Associates.
// http://www.webreference.com/js/
// License is granted if and only if this entire
// copyright notice is included. By Tomer Shiran.

    function setCookie (name, value, expires, path, domain, secure) {
        var curCookie = name + "=" + escape(value) + (expires ? "; expires=" + expires.toGMTString() : "") +
            (path ? "; path=" + path : "") + (domain ? "; domain=" + domain : "") + (secure ? "secure" : "");
        document.cookie = curCookie;
    }

    function getCookie (name) {
        var prefix = name + '=';
        var c = document.cookie;
        var nullstring = '';
        var cookieStartIndex = c.indexOf(prefix);
        if (cookieStartIndex == -1)
            return nullstring;
        var cookieEndIndex = c.indexOf(";", cookieStartIndex + prefix.length);
        if (cookieEndIndex == -1)
            cookieEndIndex = c.length;
        return unescape(c.substring(cookieStartIndex + prefix.length, cookieEndIndex));
    }

    function deleteCookie (name, path, domain) {
        if (getCookie(name))
            document.cookie = name + "=" + ((path) ? "; path=" + path : "") +
                ((domain) ? "; domain=" + domain : "") + "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }

    function fixDate (date) {
        var base = new Date(0);
        var skew = base.getTime();
        if (skew > 0)
            date.setTime(date.getTime() - skew);
    }

    function rememberMe (f) {
        var now = new Date();
        fixDate(now);
        now.setTime(now.getTime() + 365 * 24 * 60 * 60 * 1000);
        now = now.toGMTString();
        if (f.author != undefined)
           setCookie('mtcmtauth', f.author.value, now, '/', '', '');
        if (f.email != undefined)
           setCookie('mtcmtmail', f.email.value, now, '/', '', '');
        if (f.url != undefined)
           setCookie('mtcmthome', f.url.value, now, '/', '', '');
    }

    function forgetMe (f) {
        deleteCookie('mtcmtmail', '/', '');
        deleteCookie('mtcmthome', '/', '');
        deleteCookie('mtcmtauth', '/', '');
        f.email.value = '';
        f.author.value = '';
        f.url.value = '';
    }

