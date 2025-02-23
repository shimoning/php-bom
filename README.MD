# BOM

BOM の文字を取得するためのライブラリ。

![license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat)
![license](https://img.shields.io/badge/-PHP8-777BB4.svg?style=flat&logo=php&labelColor=777BB4&logoColor=FFF)
![license](https://img.shields.io/badge/-PHP7-777BB4.svg?style=flat&logo=php&labelColor=777BB4&logoColor=FFF)

## Install

利用するプロジェクトの `composer.json` に以下を追加する。

```composer.json
"repositories": {
    "bom": {
        "type": "vcs",
        "url": "https://github.com/shimoning/bom.git"
    }
},
```

その後以下でインストールする。

```bash
composer require shimoning/bom
```

## Usage

PHP 8.1 以降と、それ未満で使用するクラスが異なる。
(enum が使えるかどうか)

### PHP 8.1 以上

```php
use Shimoning\Bom\Bom;

// UTF-8 用の BOM を取得する
Bom::UTF8->get();
// UTF-16 BE 用の BOM を取得する
Bom::UTF16_BE->get();
// UTF-16 LE 用の BOM を取得する
Bom::UTF16_LE->get();
// UTF-32 BE 用の BOM を取得する
Bom::UTF32_BE->get();
// UTF-32 LE 用の BOM を取得する
Bom::UTF32_LE->get();
```

### PHP 8.0 以下

```php
use Shimoning\Bom\BC\Bom;

// UTF-8 用の BOM を取得する
Bom::get('UTF-8');
// UTF-16 BE 用の BOM を取得する
Bom::get('UTF-16BE');
// UTF-16 LE 用の BOM を取得する
Bom::get('UTF-16LE');
// UTF-32 BE 用の BOM を取得する
Bom::get('UTF-32BE');
// UTF-32 LE 用の BOM を取得する
Bom::get('UTF-32LE');
```

#### 文字コードの揺らぎ対策
入力の揺らぎをある程度吸収する。

##### UTF-8 とみなされる文字列
* UTF-8
* UTF8

及び、上記の大文字小文字混在。

##### UTF-16BE とみなされる文字列
* UTF-16BE
* UTF-16_BE
* UTF16BE

及び、上記の大文字小文字混在。

##### UTF-16LE とみなされる文字列
* UTF-16LE
* UTF-16_LE
* UTF16LE
* UTF-16
* UTF16

及び、上記の大文字小文字混在。

エイディアン表記がない場合は、リトルエイディアンとみなしている。
(将来的にはエラーにするかもしれない)

##### UTF-32BE とみなされる文字列
* UTF-32BE
* UTF-32_BE
* UTF32BE

及び、上記の大文字小文字混在。

##### UTF-32LE とみなされる文字列
* UTF-32LE
* UTF-32_LE
* UTF32LE
* UTF-32
* UTF32

及び、上記の大文字小文字混在。

エイディアン表記がない場合は、リトルエイディアンとみなしている。
(将来的にはエラーにするかもしれない)

## UTF-7 について
UTF-7 にも BOM が存在するが、後続文字によって変わるらしいので、現時点でサポートしていない。
