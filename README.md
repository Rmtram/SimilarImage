# SimilarImage

類似画像の抽出ライブラリです。

## 使用方法について

```php

// 判定手法の選定(histogram compare, hash compare など)
$strategy = new HashStrategy(); 

$similar = new SimilarImage($strategy);

// 許容値の設定
$similar->tolerance(80);

// 実行
// arg1 => base image.
// arg2 => target image.
$result = $similar->run('p001_01.jpg', ['p001_01.jpg', 'p001_02.jpg']);

// result
array(3) {
  [0]=>
  array(1) {
    ["p001_01.jpg"]=> float(1)
  }
  [1]=>
  array(1) {
    ["p001_02.JPG"]=> float(0.8)
  }
}
```