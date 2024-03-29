# Movable Type (r) Open Source (C) 2005-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: reCaptcha.pl 1174 2008-01-08 21:02:50Z bchoate $

# reCaptcha plugin for Movable Type
# Author: Six Apart (http://www.sixapart.com)
# Released under the Artistic and GPLv2 License

package MT::Plugin::reCaptcha;

use strict;
use warnings;

use MT;
use base qw(MT::Plugin);

my $plugin = MT::Plugin::reCaptcha->new({
    description => 'CAPTCHA plugin powered by reCaptcha.  Follow the instruction specified in README to use reCaptcha on your published blog.',
    name => 'reCaptcha',
    author_name => 'Six Apart, Ltd.',
    author_link => 'http://www.movabletype.com/',
	blog_config_template => <<TMPL,
<dl>
<dt>reCaptcha public key</dt>
<dd><input name="recaptcha_publickey" size="40" value="<mt:var name="recaptcha_publickey">" /></dd>
<dt>reCaptcha private key</dt>
<dd><input name="recaptcha_privatekey" size="40" value="<mt:var name="recaptcha_privatekey">" /></dd>
</dl>
TMPL
    settings => new MT::PluginSettings([
        ['recaptcha_publickey', { Scope   => 'blog' }],
        ['recaptcha_privatekey', { Scope   => 'blog' }],
    ]),
    version => '0.2',
});

MT->add_plugin($plugin);
sub instance { $plugin }

sub init_registry {
    my $plugin = shift;
    $plugin->registry({
        'captcha_providers' => {
            'sixapart_rc' => {
                'label' => 'reCaptcha',
				'class' => 'reCaptcha',
            },
        },
    });
}

1;
