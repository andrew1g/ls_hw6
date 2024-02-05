<?php

require '../vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

$image_resized = Image::make('images/carw.jpg')->resize(200, null, function (Intervention\Image\Constraint $constraint) {
    $constraint->aspectRatio();
});

$image_resized->text('Super car', $image_resized->width()-10, $image_resized->height()-10, function (\Intervention\Image\AbstractFont $font) {
    $font->size(50);
    $font->color('#fff');
    $font->align('right');
    $font->valign('bottom');
});

$image_resized->save('images/carw_resized.jpg');

echo $image_resized->response('jpg');

