<?php
/*******************************************************************************
   Формирование результатов поиска
   Вызывает bg_bibrefs_printVerses() - см. ниже
*******************************************************************************/  
function bg_bibrefs_search_result($context, $type, $lang, $prll='') {
	global $bg_bibrefs_option;
	global $bg_bibrefs_chapter, $bg_bibrefs_ch, $bg_bibrefs_psalm, $bg_bibrefs_ps;
	global $bg_bibrefs_url, $bg_bibrefs_bookTitle, $bg_bibrefs_shortTitle, $bg_bibrefs_bookFile;

	$lang = include_books($lang);
	bg_bibrefs_get_options ();
	$verses = "";
	$bkr = "";

/*******************************************************************************
   Построение паттерна

*******************************************************************************/  
//	echo "context=". $context. "<br>";					// Отладка
	$pattern = trim($context);									// убираем пробелы по краям
	$pattern  = preg_replace("/\s+/ui", ' ', $pattern);			// удаляем двойные пробелы
	
	$pattern  = preg_replace("/\\\/ui", '\\', $pattern);		// переобразуем спецсимвол в обычный \
	$pattern  = preg_replace("/\//ui", '\/', $pattern);			// переобразуем спецсимвол в обычный /
	$pattern  = preg_replace("/\^/ui", '\^', $pattern);			// переобразуем спецсимвол в обычный ^
	$pattern  = preg_replace("/\?/ui", '\?', $pattern);			// переобразуем спецсимвол в обычный ?
	$pattern  = preg_replace("/\./ui", '\.', $pattern);			// переобразуем спецсимвол в обычный .
	$pattern  = preg_replace("/\+/ui", '\+', $pattern);			// переобразуем спецсимвол в обычный +
	$pattern  = preg_replace("/\{/ui", '\{', $pattern);			// переобразуем спецсимвол в обычный {
	$pattern  = preg_replace("/\}/ui", '\}', $pattern);			// переобразуем спецсимвол в обычный }
	$pattern  = preg_replace("/\(/ui", '\(', $pattern);			// переобразуем спецсимвол в обычный (
	$pattern  = preg_replace("/\)/ui", '\)', $pattern);			// переобразуем спецсимвол в обычный )
	$pattern  = preg_replace("/\[/ui", '\[', $pattern);			// переобразуем спецсимвол в обычный [
	$pattern  = preg_replace("/\]/ui", '\]', $pattern);			// переобразуем спецсимвол в обычный ]
	
	$pattern  = preg_replace("/\\$/ui", '\w',  $pattern);		// $ - строго 1 любая буква
	$pattern  = preg_replace("/\%/ui", '\w?',  $pattern);		// % - 0 или 1 любая буква
	$pattern  = preg_replace("/\*/ui", '\w*',  $pattern);		// * - 0 или несколько любых букв
	
	$pattern  = preg_replace("/\s/ui", '\s*', $pattern);		// пробельные символы в тексте Библии могут быть любыми
	$pattern = "/\b".$pattern."\b/ui";			// Только целое слово
	
//	echo "pattern=". $pattern. "<br>";					// Отладка
	
/*******************************************************************************
   Организуем просмотр всех книг Библии

*******************************************************************************/  
	foreach ($bg_bibrefs_bookFile as $book => $bookFile) {
/*******************************************************************************
   Чтение и преобразование файла книги
   
*******************************************************************************/  
		$jsons = bg_bibrefs_get_file ($book, $lang);
		$json = $jsons[$lang];
		$json = $json['data'];
		if (empty($json)) continue;
/*		
		$book_file = 'bible/'.$bookFile;						// Имя файла книги
		$path = dirname(dirname(__FILE__ )).'/'.$book_file;										// Локальный URL файла
		$url = plugins_url( $book_file , dirname(__FILE__ ) );									// URL файла
		if (!file_exists($path)) {
			$upload_dir = wp_upload_dir();
			$path = $upload_dir['basedir'].'/'.$book_file;
			$url = $upload_dir['baseurl'].'/'.$book_file;
		}

	// Получаем данные из файла	
		$code = false;
		if ($bg_bibrefs_option['fgc'] == 'on' && function_exists('file_get_contents')) {		// Попытка1. Если данные не получены попробуем применить file_get_contents()
			$code = file_get_contents($path);		
		}

		if ($bg_bibrefs_option['fopen'] == 'on' && !$code) {									// Попытка 2. Если данные опять не получены попробуем применить fopen() 
			$ch=fopen($path, "r" );																	// Открываем файл для чтения
			if($ch)	{
				while (!feof($ch))	{
					$code .= fread($ch, 2097152);													// загрузка текста (не более 2097152 байт)
				}
				fclose($ch);																		// Закрываем файл
			}
		}
		if ($bg_bibrefs_option['curl'] == 'on' && function_exists('curl_init') && !$code) {		// Попытка3. Если установлен cURL				
			$ch = curl_init($url);																	// создание нового ресурса cURL
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);											// возврат результата передачи в качестве строки из curl_exec() вместо прямого вывода в браузер
			$code = curl_exec($ch);																	// загрузка текста
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);										
			if ($httpCode != '200') $code = false;													// Проверка на код http 200
			curl_close($ch);																		// завершение сеанса и освобождение ресурсов
		} 

		if (!$code) return "";																	// Увы. Паранойя хостера достигла апогея. Файл не прочитан или ошибка

// Преобразовать json в массив
		$json = json_decode($code, true);
*/
/*******************************************************************************
   Поиск вхождения в текст стиха Библии
   и формирование результатов поиска
*******************************************************************************/  
		$cn_json = count($json);
		$chr = 0;
		for ($i=0; $i < $cn_json; $i++) {

			if (!preg_match ( $pattern, $json[$i]['text'] )) continue;		// Если нет вхождений ищем в следующем стихе

			if ($bkr != $book) {
				if ($type == "book") $verses = $verses."<h3>".bg_bibrefs_getTitle($book)."</h3>";
				else if ($type == "t_verses") $verses = $verses."<strong>".bg_bibrefs_getTitle($book)."</strong><br>";
				$bkr = $book;
			}
			$ch = (int)$json[$i]['part'];
			$vr = (int)$json[$i]['stix'];
			$verses = $verses.bg_bibrefs_printVerses ($jsons, $book, $chr, $ch, $ch, $vr, $vr, $type, $lang, $prll);
			$chr = $ch;
			
		}
	}
	$verses  = preg_replace($pattern, '<strong class="search-excerpt">\0</strong>',  $verses);
	if (!$verses) $verses = '<p>&laquo;<strong class="search-excerpt">'.$context.'</strong>&raquo; &mdash; '.__( 'sorry, but nothing matched your search terms. Please try again with some different keywords.', 'bg_bibrefs' ).'</p>';
	return $verses;
}
