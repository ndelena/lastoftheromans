# Movable Type (r) Open Source (C) 2001-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: ja.pm 1174 2008-01-08 21:02:50Z bchoate $

package l10nsample::L10N::ja;

use strict;
use base 'l10nsample::L10N::en_us';
use vars qw( %Lexicon );

## The following is the translation table.

%Lexicon = (
    'This description can be localized if there is l10n_class set.' => 'l10n_classを設定すればこの説明はローカライズできます。',
    'Fumiaki Yoshimatsu' => '吉松史彰',
    'l10nsample' => 'ローカライズサンプル',
    'This is localizable' => 'ここもローカライズ可能',
    'This is localized in perl module' => 'これはPerl Module内でローカライズされました。',
    'This phrase is processed in template.' => 'これはテンプレートでローカライズされました。',
);

1;

