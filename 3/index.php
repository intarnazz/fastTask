<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <style></style>
</head>

<body>
  <?php
  // Загрузка оригинального изображения
  $originalImage = imagecreatefrompng('img.png');

  // Создание водяного знака
  $watermarkImage = imagecreatefrompng('waterMark.png');

  // Находим самую темную точку на изображении
  $darkestPixel = findDarkestPixel($originalImage);
  $darkestX = $darkestPixel['x'] - 60;
  $darkestY = $darkestPixel['y'] - 60;

  // Наложение водяного знака на самую темную область
  imagecopy($originalImage, $watermarkImage, $darkestX, $darkestY, 0, 0, imagesx($watermarkImage), imagesy($watermarkImage));

  // Сохранение изображения с водяным знаком
  $outputFilename = 'output_' . time() . '.jpg';
  imagejpeg($originalImage, $outputFilename);

  // Вывод HTML-кода с изображением
  echo '<img src="' . $outputFilename . '" alt="Watermarked Image">';

  // Освобождение ресурсов
  imagedestroy($originalImage);
  imagedestroy($watermarkImage);

  // Функция для поиска самой темной точки на изображении
  function findDarkestPixel($image)
  {
    $width = imagesx($image);
    $height = imagesy($image);
    $darkestPixel = ['x' => 0, 'y' => 0, 'brightness' => 255]; // Начальные значения яркости самой темной точки
    for ($x = 0; $x < $width; $x++) {
      for ($y = 0; $y < $height; $y++) {
        $rgb = imagecolorat($image, $x, $y);
        $colors = imagecolorsforindex($image, $rgb);
        $brightness = ($colors['red'] + $colors['green'] + $colors['blue']) / 3; // Вычисление яркости пикселя
        if ($brightness < $darkestPixel['brightness']) {
          $darkestPixel['x'] = $x;
          $darkestPixel['y'] = $y;
          $darkestPixel['brightness'] = $brightness;
        }
      }
    }
    return $darkestPixel;
  }
  ?>
</body>

</html>
