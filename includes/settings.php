<?php 
/******************************************************************************************
	Страница настроек
    отображает содержимое страницы для подменю Bible References
*******************************************************************************************/
function bg_bibrefs_options_page() {
// https://azbyka.ru/biblia/?Lk.4:25-5:13,6:1-13&crgli&rus&num=cr

	$active_tab = 'links';
	if( isset( $_GET[ 'tab' ] ) ) $active_tab = $_GET[ 'tab' ];
	
    // имена опций и полей
	$bg_bibrefs_site = 'bg_bibrefs_site';				// Имя ссылки
	
    $c_lang_name = 'bg_bibrefs_c_lang';					// Церковно-славянский
    $c_font_name = 'bg_bibrefs_c_font';					// Шрифт для церковно-славянского текста
    $r_lang_name = 'bg_bibrefs_r_lang';					// Русский
    $k_lang_name = 'bg_bibrefs_k_lang';					// Украинский
    $v_lang_name = 'bg_bibrefs_v_lang';					// Белорусский
    $z_lang_name = 'bg_bibrefs_z_lang';					// Сербский
    $a_lang_name = 'bg_bibrefs_a_lang';					// Английский
    $h_lang_name = 'bg_bibrefs_h_lang';					// Французский
    $g_lang_name = 'bg_bibrefs_g_lang';					// Греческий
    $l_lang_name = 'bg_bibrefs_l_lang';					// Латинский
    $i_lang_name = 'bg_bibrefs_i_lang';					// Иврит

	$bg_bibrefs_page = 'bg_bibrefs_page';				// Ссылка на предварительно созданную страницу для вывода текста Библии

	$bg_verses_lang = 'bg_bibrefs_verses_lang';			// Язык стихов из Библии во всплывающей подсказке
    $bg_show_fn = 'bg_bibrefs_show_fn';					// Отображать оригинальные номера стихов

    $target_window = 'bg_bibrefs_target';				// Где открыть страницу с текстом Библии
	$bg_headers = 'bg_bibrefs_headers';					// Подсвечивать ссылки в заголовках H1-H6
	$bg_interpret = 'bg_bibrefs_interpret';				// Включить ссылки на толкование Священного Писания
	$bg_parallel = 'bg_bibrefs_parallel';				// Включить ссылки на паралельные места Священного Писания

	$bg_norm_refs = 'bg_bibrefs_norm_refs';				// Преобразовывать ссылки к нормализованному виду
	$bg_verses_name = 'bg_bibrefs_show_verses';			// Отображать стихи из Библии во всплывающей подсказке

    $bg_perm_dot = 'bg_bibrefs_dot';					// Разрешить отсутствие точки после обозначения книги
    $bg_perm_romeh = 'bg_bibrefs_romeh';				// Разрешить Римские цифры
    $bg_perm_sepc = 'bg_bibrefs_sepc';					// Разрешить запятую, как разделитеть между главой и стихами (западная традиция)
	$bg_strip_space = 'bg_bibrefs_strip_space';			// Удалять пробелы в обозначениях книг, начинающихся с цифр
	$bg_perm_exceptions = 'bg_bibrefs_exceptions';		// Словосочетания, не являющиеся ссылками на Библию
	
	$bg_curl_name = 'bg_bibrefs_curl';					// Чтение файлов Библии с помощью cURL
	$bg_fgc_name = 'bg_bibrefs_fgc';					// Чтение файлов Библии с помощью file_get_contents()
	$bg_fopen_name = 'bg_bibrefs_fopen';				// Чтение файлов Библии с помощью fopen()
	
	$bg_bibrefs_pload = 'bg_bibrefs_preload';			// Предварительно загружать стихи из Библии в всплывающие подсказки - до создания строницы (php)
	$bg_bibrefs_preq = 'bg_bibrefs_prereq';				// Предварительно загружать стихи из Библии в всплывающие подсказки - после создания страницы (ajax)
	
	$bg_bibrefs_maxtime = "bg_bibrefs_maxtime";			// Максимальное время работы скрипта

    $bg_bibrefs_ajaxurl = "bg_bibrefs_ajaxurl";			// Внешний AJAX Proxy
	$bg_content = 'bg_bibrefs_content';					// Контейнер, внутри которого будут отображаться подсказки
	$links_class = 'bg_bibrefs_class';					// CSS класс для ссылок на Библию
	$bg_refs_file = 'bg_bibrefs_refs_file';				// Пользовательский файл цитат из Библии
	
	$bg_bibrefs_debug_name = 'bg_bibrefs_debug';		// Включить запись в лог
	
    $hidden_field_name = 'bg_bibrefs_submit_hidden';	// Скрытое поле для проверки обновления информацции в форме
	
	bg_bibrefs_options_ini (); 			// Параметры по умолчанию
	
    // Читаем существующие значения опций из базы данных
    $bg_bibrefs_site_val = get_option( $bg_bibrefs_site );
	
    $c_lang_val = get_option( $c_lang_name );
    $r_lang_val = get_option( $r_lang_name );
    $k_lang_val = get_option( $k_lang_name );
    $v_lang_val = get_option( $v_lang_name );
    $z_lang_val = get_option( $z_lang_name );
    $a_lang_val = get_option( $a_lang_name );
    $h_lang_val = get_option( $h_lang_name );
    $g_lang_val = get_option( $g_lang_name );
    $l_lang_val = get_option( $l_lang_name );
    $i_lang_val = get_option( $i_lang_name );
    $font_val = get_option( $c_font_name );

    $bg_bibrefs_page_val = get_option( $bg_bibrefs_page );
	
    $bg_verses_lang_val = get_option( $bg_verses_lang );
    $bg_show_fn_val = get_option( $bg_show_fn );

    $target_val = get_option( $target_window );
    $bg_headers_val = get_option( $bg_headers );
    $bg_interpret_val = get_option( $bg_interpret );
    $bg_parallel_val = get_option( $bg_parallel );

    $bg_norm_refs_val = get_option( $bg_norm_refs );
    $bg_verses_val = get_option( $bg_verses_name );

    $bg_perm_dot_val = get_option( $bg_perm_dot );
    $bg_perm_romeh_val = get_option( $bg_perm_romeh );
    $bg_perm_sepc_val = get_option( $bg_perm_sepc );
    $bg_strip_space_val = get_option( $bg_strip_space );
    $bg_perm_exceptions_val = get_option( $bg_perm_exceptions );

    $bg_curl_val = get_option( $bg_curl_name );
    $bg_fgc_val = get_option( $bg_fgc_name );
    $bg_fopen_val = get_option( $bg_fopen_name );

    $bg_bibrefs_pload_val = get_option( $bg_bibrefs_pload );
	$bg_bibrefs_preq_val = get_option( $bg_bibrefs_preq );
	
	$bg_bibrefs_maxtime_val = (int) get_option($bg_bibrefs_maxtime);

	$bg_bibrefs_ajaxurl_val = get_option($bg_bibrefs_ajaxurl);
    $bg_content_val = get_option( $bg_content );
    $class_val = get_option( $links_class );
    $bg_refs_file_val = get_option( $bg_refs_file );
	
    $bg_bibrefs_debug_val = get_option( $bg_bibrefs_debug_name );
	
// Проверяем, отправил ли пользователь нам некоторую информацию
// Если "Да", в это скрытое поле будет установлено значение 'Y'
    if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {

	// Сохраняем отправленное значение в БД
		$bg_bibrefs_site_val = sanitize_text_field(( isset( $_POST[$bg_bibrefs_site] ) && $_POST[$bg_bibrefs_site] ) ? $_POST[$bg_bibrefs_site] : '') ;
		update_option( $bg_bibrefs_site, $bg_bibrefs_site_val );

		$c_lang_val = sanitize_text_field(( isset( $_POST[$c_lang_name] ) && $_POST[$c_lang_name] ) ? $_POST[$c_lang_name] : '') ;
		update_option( $c_lang_name, $c_lang_val );

		$r_lang_val = sanitize_text_field(( isset( $_POST[$r_lang_name] ) && $_POST[$r_lang_name] ) ? $_POST[$r_lang_name] : '') ;
		update_option( $r_lang_name, $r_lang_val );

		$k_lang_val = sanitize_text_field(( isset( $_POST[$k_lang_name] ) && $_POST[$k_lang_name] ) ? $_POST[$k_lang_name] : '') ;
		update_option( $k_lang_name, $k_lang_val );

		$v_lang_val = sanitize_text_field(( isset( $_POST[$v_lang_name] ) && $_POST[$v_lang_name] ) ? $_POST[$v_lang_name] : '') ;
		update_option( $v_lang_name, $v_lang_val );

		$z_lang_val = sanitize_text_field(( isset( $_POST[$z_lang_name] ) && $_POST[$z_lang_name] ) ? $_POST[$z_lang_name] : '') ;
		update_option( $z_lang_name, $z_lang_val );

		$a_lang_val = sanitize_text_field(( isset( $_POST[$a_lang_name] ) && $_POST[$a_lang_name] ) ? $_POST[$a_lang_name] : '') ;
		update_option( $a_lang_name, $a_lang_val );		
		
		$h_lang_val = sanitize_text_field(( isset( $_POST[$h_lang_name] ) && $_POST[$h_lang_name] ) ? $_POST[$h_lang_name] : '') ;
		update_option( $h_lang_name, $h_lang_val );		
		
		$g_lang_val = sanitize_text_field(( isset( $_POST[$g_lang_name] ) && $_POST[$g_lang_name] ) ? $_POST[$g_lang_name] : '') ;
		update_option( $g_lang_name, $g_lang_val );

		$l_lang_val = sanitize_text_field(( isset( $_POST[$l_lang_name] ) && $_POST[$l_lang_name] ) ? $_POST[$l_lang_name] : '') ;
		update_option( $l_lang_name, $l_lang_val );

		$i_lang_val = sanitize_text_field(( isset( $_POST[$i_lang_name] ) && $_POST[$i_lang_name] ) ? $_POST[$i_lang_name] : '') ;
		update_option( $i_lang_name, $i_lang_val );

		$font_val = sanitize_text_field(( isset( $_POST[$c_font_name] ) && $_POST[$c_font_name] ) ? $_POST[$c_font_name] : '') ;
		update_option( $c_font_name, $font_val );

		$bg_bibrefs_page_val = esc_url(( isset( $_POST[$bg_bibrefs_page] ) && $_POST[$bg_bibrefs_page] ) ? $_POST[$bg_bibrefs_page] : '') ;
		update_option( $bg_bibrefs_page, $bg_bibrefs_page_val );

		$bg_verses_lang_val = sanitize_text_field(( isset( $_POST[$bg_verses_lang] ) && $_POST[$bg_verses_lang] ) ? $_POST[$bg_verses_lang] : '') ;
		update_option( $bg_verses_lang, $bg_verses_lang_val );

		$bg_show_fn_val = sanitize_text_field(( isset( $_POST[$bg_show_fn] ) && $_POST[$bg_show_fn] ) ? $_POST[$bg_show_fn] : '') ;
		update_option( $bg_show_fn, $bg_show_fn_val );

		$target_val = sanitize_text_field(( isset( $_POST[$target_window] ) && $_POST[$target_window] ) ? $_POST[$target_window] : '') ;
		update_option( $target_window, $target_val );

		$bg_headers_val = sanitize_text_field(( isset( $_POST[$bg_headers] ) && $_POST[$bg_headers] ) ? $_POST[$bg_headers] : '') ;
		update_option( $bg_headers, $bg_headers_val );

		$bg_interpret_val = sanitize_text_field(( isset( $_POST[$bg_interpret] ) && $_POST[$bg_interpret] ) ? $_POST[$bg_interpret] : '') ;
		update_option( $bg_interpret, $bg_interpret_val );

		$bg_parallel_val = sanitize_text_field(( isset( $_POST[$bg_parallel] ) && $_POST[$bg_parallel] ) ? $_POST[$bg_parallel] : '') ;
		update_option( $bg_parallel, $bg_parallel_val );

		$bg_norm_refs_val = sanitize_text_field(( isset( $_POST[$bg_norm_refs] ) && $_POST[$bg_norm_refs] ) ? $_POST[$bg_norm_refs] : '') ;
		update_option( $bg_norm_refs, $bg_norm_refs_val );

		$bg_verses_val = sanitize_text_field(( isset( $_POST[$bg_verses_name] ) && $_POST[$bg_verses_name] ) ? $_POST[$bg_verses_name] : '') ;
		update_option( $bg_verses_name, $bg_verses_val );

		$bg_perm_dot_val = sanitize_text_field(( isset( $_POST[$bg_perm_dot] ) && $_POST[$bg_perm_dot] ) ? $_POST[$bg_perm_dot] : '') ;
		update_option( $bg_perm_dot, $bg_perm_dot_val );

		$bg_perm_romeh_val = sanitize_text_field(( isset( $_POST[$bg_perm_romeh] ) && $_POST[$bg_perm_romeh] ) ? $_POST[$bg_perm_romeh] : '') ;
		update_option( $bg_perm_romeh, $bg_perm_romeh_val );

		$bg_perm_sepc_val = sanitize_text_field(( isset( $_POST[$bg_perm_sepc] ) && $_POST[$bg_perm_sepc] ) ? $_POST[$bg_perm_sepc] : '') ;
		update_option( $bg_perm_sepc, $bg_perm_sepc_val );

		$bg_strip_space_val = sanitize_text_field(( isset( $_POST[$bg_strip_space] ) && $_POST[$bg_strip_space] ) ? $_POST[$bg_strip_space] : '') ;
		update_option( $bg_strip_space, $bg_strip_space_val );

		$bg_perm_exceptions_val = sanitize_textarea_field(( isset( $_POST[$bg_perm_exceptions] ) && $_POST[$bg_perm_exceptions] ) ? $_POST[$bg_perm_exceptions] : '') ;
		update_option( $bg_perm_exceptions, $bg_perm_exceptions_val );

		$bg_curl_val = sanitize_text_field(( isset( $_POST[$bg_curl_name] ) && $_POST[$bg_curl_name] ) ? $_POST[$bg_curl_name] : '') ;
		update_option( $bg_curl_name, $bg_curl_val );

		$bg_fgc_val = sanitize_text_field(( isset( $_POST[$bg_fgc_name] ) && $_POST[$bg_fgc_name] ) ? $_POST[$bg_fgc_name] : '') ;
		update_option( $bg_fgc_name, $bg_fgc_val );

		$bg_fopen_val = sanitize_text_field(( isset( $_POST[$bg_fopen_name] ) && $_POST[$bg_fopen_name] ) ? $_POST[$bg_fopen_name] : '') ;
		update_option( $bg_fopen_name, $bg_fopen_val );

		$bg_bibrefs_pload_val = sanitize_text_field(( isset( $_POST[$bg_bibrefs_pload] ) && $_POST[$bg_bibrefs_pload] ) ? $_POST[$bg_bibrefs_pload] : '') ;
		update_option( $bg_bibrefs_pload, $bg_bibrefs_pload_val );

		$bg_bibrefs_preq_val = sanitize_text_field(( isset( $_POST[$bg_bibrefs_preq] ) && $_POST[$bg_bibrefs_preq] ) ? $_POST[$bg_bibrefs_preq] : '') ;
		update_option( $bg_bibrefs_preq, $bg_bibrefs_preq_val );

		$bg_bibrefs_maxtime_val = (int) sanitize_text_field(( isset( $_POST[$bg_bibrefs_maxtime] ) && $_POST[$bg_bibrefs_maxtime] ) ? $_POST[$bg_bibrefs_maxtime] : '') ;
		update_option( $bg_bibrefs_maxtime, $bg_bibrefs_maxtime_val );

		$bg_bibrefs_ajaxurl_val = esc_url(( isset( $_POST[$bg_bibrefs_ajaxurl] ) && $_POST[$bg_bibrefs_ajaxurl] ) ? $_POST[$bg_bibrefs_ajaxurl] : '') ;
		update_option( $bg_bibrefs_ajaxurl, $bg_bibrefs_ajaxurl_val );

		$bg_content_val = sanitize_text_field(( isset( $_POST[$bg_content] ) && $_POST[$bg_content] ) ? $_POST[$bg_content] : '') ;
		update_option( $bg_content, $bg_content_val );

		$class_val = sanitize_html_class(( isset( $_POST[$links_class] ) && $_POST[$links_class] ) ? $_POST[$links_class] : '') ;
		update_option( $links_class, $class_val );

		$bg_refs_file_val = esc_url(( isset( $_POST[$bg_refs_file] ) && $_POST[$bg_refs_file] ) ? $_POST[$bg_refs_file] : '') ;
		update_option( $bg_refs_file, $bg_refs_file_val );

 		$bg_bibrefs_debug_val = sanitize_text_field(( isset( $_POST[$bg_bibrefs_debug_name] ) && $_POST[$bg_bibrefs_debug_name] ) ? $_POST[$bg_bibrefs_debug_name] : '') ;
		update_option( $bg_bibrefs_debug_name, $bg_bibrefs_debug_val );

       // Вывести сообщение об обновлении параметров на экран
		echo '<div class="updated"><p><strong>'.__('Options saved.', 'bg_bibrefs' ).'</strong></p></div>';
    }
?>
<!--  форма опций -->
<script>
function c_lang_checked() {
	azbyka_font = document.getElementById('bg_bibrefs_azbyka_font');
	if (document.getElementById('c_lang').checked == true) azbyka_font.style.display = '';
	else azbyka_font.style.display = 'none';
}
function bg_bibrefs_site_checked() {
	elRadio = document.getElementsByName('<?php echo $bg_bibrefs_site ?>');
	azbyka_lang = document.getElementById('bg_bibrefs_azbyka_lang');
	azbyka_font = document.getElementById('bg_bibrefs_azbyka_font');
	permalink = document.getElementById('bg_bibrefs_permalink');
	if (elRadio[0].checked) {
		azbyka_lang.style.display = '';
		c_lang_checked();
	}
	else {
		azbyka_lang.style.display = 'none';
		azbyka_font.style.display = 'none';
	}
	if (elRadio[1].checked) permalink.style.display = '';
	else permalink.style.display = 'none';
}
function bg_verses_checked() {
	if (document.getElementById('bg_verses').checked == true) {
		document.getElementById('bg_bibrefs_pload').disabled = false;
		document.getElementById('bg_bibrefs_preq').disabled = false;
	} else {
		document.getElementById('bg_bibrefs_pload').disabled = true;
		document.getElementById('bg_bibrefs_pload').checked = false;
		document.getElementById('bg_bibrefs_preq').disabled = true;
		document.getElementById('bg_bibrefs_preq').checked = false;
	}
}
function bg_bibrefs_check_preload() {
	if (document.getElementById('bg_bibrefs_pload').checked == true) {
		document.getElementById('bg_bibrefs_preq').checked = false;
	}
}
function bg_bibrefs_check_prereq() {
	if (document.getElementById('bg_bibrefs_preq').checked == true){
		document.getElementById('bg_bibrefs_pload').checked = false;
	}
}
function reading_off_checked() {
	if (document.getElementById('bg_curl').checked == true || document.getElementById('bg_fgc').checked == true || document.getElementById('bg_fopen').checked == true) {
		document.getElementById('bg_verses').disabled = false;
	} else {
		document.getElementById('bg_verses').disabled = true;
		document.getElementById('bg_verses').checked = false;
		document.getElementById('bg_bibrefs_pload').disabled = true;
		document.getElementById('bg_bibrefs_pload').checked = false;
		document.getElementById('bg_bibrefs_preq').disabled = true;
		document.getElementById('bg_bibrefs_preq').checked = false;
	}
}
</script>    
<table width="100%">
<tr><td valign="top">
<!--  Теперь отобразим опции на экране редактирования -->
<div class="wrap">
<!--  Заголовок -->
<h2><?php _e( 'Bg Bible References Plugin Options', 'bg_bibrefs' ); ?></h2>
<div id="bg_bibrefs_resalt"></div>
<p><?php printf( __( 'Version', 'bg_bibrefs' ).' <b>'.get_plugin_version().'</b>' ); ?></p>

<h2 class="nav-tab-wrapper">
	<a href="?page=bg-biblie-references%2Fbg_bibrefs.php&tab=links" class="nav-tab <?php echo $active_tab == 'links' ? 'nav-tab-active' : ''; ?>"><?php _e('Links', 'bg_bibrefs') ?></a>
	<a href="?page=bg-biblie-references%2Fbg_bibrefs.php&tab=permissions" class="nav-tab <?php echo $active_tab == 'permissions' ? 'nav-tab-active' : ''; ?>"><?php _e('Permissions', 'bg_bibrefs') ?></a>
	<a href="?page=bg-biblie-references%2Fbg_bibrefs.php&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Settings', 'bg_bibrefs') ?></a>
	<a href="?page=bg-biblie-references%2Fbg_bibrefs.php&tab=additional" class="nav-tab <?php echo $active_tab == 'additional' ? 'nav-tab-active' : ''; ?>"><?php _e('Additional options', 'bg_bibrefs') ?></a>
	<a href="?page=bg-biblie-references%2Fbg_bibrefs.php&tab=bible" class="nav-tab <?php echo $active_tab == 'bible' ? 'nav-tab-active' : ''; ?>"><?php _e('Bible books', 'bg_bibrefs') ?></a>
</h2>

<!-- Загрузка книг Библии -->
<?php if ($active_tab == 'bible') { 

	include_once ('books.php');

    //Create an instance of our package class...
    $bg_bibrefs_bible_ListTable = new bg_bibrefs_Bible_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $bg_bibrefs_bible_ListTable->prepare_items();
    
?>
<div class="wrap">
	<div id="icon-users" class="icon32"><br/></div>
	<h2><?php _e('Choice Bible books', 'bg_bibrefs') ?></h2>
<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
	<form id="bg_bibrefs_books" method="get"> 
		<!-- For plugins, we also need to ensure that the form posts back to our current page -->
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
		<input type="hidden" name="tab" value="<?php echo $_REQUEST['tab'] ?>" />
		<!-- Now we can render the completed list table -->
		<?php $bg_bibrefs_bible_ListTable->display(); ?>
	</form> 
</div>
<?php } else { ?>

<!-- Форма настроек -->
<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">

<!--  Основные параметры -->

<!--  Адрес ссылки -->
<table class="form-table" style="display: <?php echo $active_tab == 'links' ? '' : 'none'; ?>;">
<tr valign="top">
<th scope="row">
<input type="radio" id="bg_bibrefs_site1" name="<?php echo $bg_bibrefs_site ?>" <?php if($bg_bibrefs_site_val=="azbyka") echo "checked" ?> value="azbyka" onclick='bg_bibrefs_site_checked();'> <?php _e('Links to the Bible on <a href="https://azbyka.ru/biblia/" target=_blank>azbyka.ru</a>', 'bg_bibrefs' ); ?>
</th>
<td id="bg_bibrefs_azbyka_lang">
<div>
<?php printf(__('Languages of the Bible text on', 'bg_bibrefs' ).' <a href="https://azbyka.ru/biblia/" target=_blank>azbyka.ru</a>'); ?><br />
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<input type="checkbox" id="c_lang" name="<?php echo $c_lang_name ?>" <?php if($c_lang_val=="c") echo "checked" ?> value="c" onclick='c_lang_checked();'> <?php _e('Church Slavic', 'bg_bibrefs' ); ?><br />
<input type="checkbox" id="r_lang" name="<?php echo $r_lang_name ?>" <?php if($r_lang_val=="r") echo "checked" ?>  value="r"> <?php _e('Russian', 'bg_bibrefs' ); ?><br />
<input type="checkbox" id="k_lang" name="<?php echo $k_lang_name ?>" <?php if($k_lang_val=="k") echo "checked" ?>  value="k"> <?php _e('Ukrainian', 'bg_bibrefs' ); ?><br />
<input type="checkbox" id="v_lang" name="<?php echo $v_lang_name ?>" <?php if($v_lang_val=="v") echo "checked" ?>  value="v"> <?php _e('Belorussian', 'bg_bibrefs' ); ?><br />
<input type="checkbox" id="z_lang" name="<?php echo $z_lang_name ?>" <?php if($z_lang_val=="z") echo "checked" ?>  value="z"> <?php _e('Serbian', 'bg_bibrefs' ); ?><br />
<input type="checkbox" id="a_lang" name="<?php echo $a_lang_name ?>" <?php if($a_lang_val=="a") echo "checked" ?>  value="a"> <?php _e('English', 'bg_bibrefs' ); ?><br />
<input type="checkbox" id="h_lang" name="<?php echo $h_lang_name ?>" <?php if($h_lang_val=="h") echo "checked" ?>  value="h"> <?php _e('French', 'bg_bibrefs' ); ?><br />
<input type="checkbox" id="g_lang" name="<?php echo $g_lang_name ?>" <?php if($g_lang_val=="g") echo "checked" ?>  value="g"> <?php _e('Greek', 'bg_bibrefs' ); ?><br />
<input type="checkbox" id="l_lang" name="<?php echo $l_lang_name ?>" <?php if($l_lang_val=="l") echo "checked" ?>  value="l"> <?php _e('Latin', 'bg_bibrefs' ); ?><br />
<input type="checkbox" id="i_lang" name="<?php echo $i_lang_name ?>" <?php if($i_lang_val=="i") echo "checked" ?>  value="i"> <?php _e('Hebrew', 'bg_bibrefs' ); ?><br />
</div>
</td></tr>

<tr valign="top" id="bg_bibrefs_azbyka_font">
<th scope="row"></th>
<td>
<?php _e('Font for Church Slavonic text', 'bg_bibrefs' ); ?><br />
<input type="radio" id="ucs" name="<?php echo $c_font_name ?>" <?php if($font_val=="ucs") echo "checked" ?> value="ucs"> <?php _e('Church Slavic font', 'bg_bibrefs' ); ?><br />
<input type="radio" id="rus" name="<?php echo $c_font_name ?>" <?php if($font_val=="rus") echo "checked" ?> value="rus"> <?php _e('Russian font ("Old" style)', 'bg_bibrefs' ); ?><br />
<script>
c_lang_checked();
</script>
</td></tr>

<tr valign="top">
<th scope="row">
<input type="radio" id="bg_bibrefs_site2" name="<?php echo $bg_bibrefs_site ?>" <?php if($bg_bibrefs_site_val=="this") echo "checked" ?> value="this" onclick='bg_bibrefs_site_checked();'> <?php _e('Links to the Bible on this site', 'bg_bibrefs' ); ?><br />
</th>
<td id="bg_bibrefs_permalink">
<?php _e('Permalink to page for search result', 'bg_bibrefs' ); ?><br />
<input type="text" id="bg_bibrefs_page" name="<?php echo $bg_bibrefs_page ?>" size="60" value="<?php echo $bg_bibrefs_page_val ?>"><br />
</td></tr>


<tr valign="top">
<th scope="row">
<input type="radio" id="bg_bibrefs_site3" name="<?php echo $bg_bibrefs_site ?>" <?php if($bg_bibrefs_site_val=="none") echo "checked" ?> value="none" onclick='bg_bibrefs_site_checked();'> <?php _e('No links, popup only', 'bg_bibrefs' ); ?><br />
</th><td>
<script>
bg_bibrefs_site_checked();
</script>
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Enable links to the interpretation of the Holy Scriptures', 'bg_bibrefs' ); ?></th>
<td>
<input type="radio" id="bg_interpret_opt" name="<?php echo $bg_interpret ?>" <?php if($bg_interpret_val=="on") echo "checked" ?> value="on"> <?php _e('on Optina Pustyn site', 'bg_bibrefs' ); ?><br />
<input type="radio" id="bg_interpret_lop" name="<?php echo $bg_interpret ?>" <?php if($bg_interpret_val=="lopuhin") echo "checked" ?> value="lopuhin"> <?php _e('on <a href="https://azbyka.ru/biblia/" target=_blank>azbyka.ru</a>', 'bg_bibrefs' ); ?><br />
<input type="radio" id="bg_interpret_lnk" name="<?php echo $bg_interpret ?>" <?php if($bg_interpret_val=="link") echo "checked" ?> value="link"> <?php _e('link to the Bible (see above)', 'bg_bibrefs' ); ?><br />
<input type="radio" id="bg_interpret_off" name="<?php echo $bg_interpret ?>" <?php if($bg_interpret_val=="") echo "checked" ?> value=""> <?php _e('disabled', 'bg_bibrefs' ); ?><br />
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Enable links to the parallel passages in the Bible', 'bg_bibrefs' ); ?></th>
<td>
<input type="checkbox" id="bg_parallel" name="<?php echo $bg_parallel ?>" <?php if($bg_parallel_val=="on") echo "checked" ?>  value="on"> <?php _e('<br><i>(Tooltips and Short Codes)</i>', 'bg_bibrefs' ); ?> <br />
</td></tr>

</table>

<!--  Допустимые отклонения от стандарта ссылок -->
<table class="form-table" style="display: <?php echo $active_tab == 'permissions' ? '' : 'none'; ?>;">
<tr valign="top">
<th scope="row"><?php _e('Allow no dot after the book title', 'bg_bibrefs' ); ?></th>
<td>
<input type="checkbox" id="bg_perm_dot" name="<?php echo $bg_perm_dot ?>" <?php if($bg_perm_dot_val=="on") echo "checked" ?>  value="on"> <br />
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Allow Roman numerals', 'bg_bibrefs' ); ?></th>
<td>
<input type="checkbox" id="bg_perm_romeh" name="<?php echo $bg_perm_romeh ?>" <?php if($bg_perm_romeh_val=="on") echo "checked" ?>  value="on"> <br />
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Allow the comma as divider between chapter and verses (western tradition)', 'bg_bibrefs' ); ?></th>
<td>
<input type="checkbox" id="bg_perm_sepc" name="<?php echo $bg_perm_sepc ?>" <?php if($bg_perm_sepc_val=="on") echo "checked" ?>  value="on"> <br />
<?php _e('The plugin highlights references in both eastern and western notation. There is collision what is mean the reference containing two numbers devided by a comma (for example, Ps. 4,6). In the Western tradition, this is reference to Psalm 4 verse 6, but in the east tradition it is reference to Psalms 4 and 6. You can choose how to interpret such links by specifying it in the settings.', 'bg_bibrefs' ); ?>
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Delete spaces between digit and letter in the book notation', 'bg_bibrefs' ); ?></th>
<td>
<input type="checkbox" id="bg_strip_space" name="<?php echo $bg_strip_space ?>" <?php if($bg_strip_space_val=="on") echo "checked" ?>  value="on"> <br />
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Convert references to the normalized form', 'bg_bibrefs' ); ?></th>
<td>
<input type="checkbox" id="bg_norm_refs" name="<?php echo $bg_norm_refs ?>" <?php if($bg_norm_refs_val=="on") echo "checked" ?>  value="on"> <br />
</th><td>
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Phrases are not Bible reference', 'bg_bibrefs' ); ?></th>
<td>
<textarea id="bg_perm_exceptions" name="<?php echo $bg_perm_exceptions ?>" rows="10" cols="60"><?php echo get_option($bg_perm_exceptions); ?></textarea><br>
<i><?php _e('use a semicolon or new line as delimiter', 'bg_bibrefs') ?></i>
</td></tr>

</table>


<!--  Главные настройки -->
<table class="form-table" style="display: <?php echo $active_tab == 'settings' ? '' : 'none'; ?>;">
<tr valign="top">
<th scope="row"><?php _e('Language of references and tooltips', 'bg_bibrefs' ); ?></th>
<td>
<select id="bg_verses_lang" name="<?php echo $bg_verses_lang ?>"> 
	<option <?php if($bg_verses_lang_val=="") echo "selected" ?> value=""><?php _e('Default', 'bg_bibrefs' ); ?></option>
	<?php
		$path = dirname(dirname( __FILE__ )).'/bible/';
		if ($handle = opendir($path)) {
			while (false !== ($dir = readdir($handle))) { 
				if (is_dir ( $path.$dir ) && $dir != '.' && $dir != '..') {
					include ($path.$dir.'/books.php');
					echo "<option ";
					if($bg_verses_lang_val==$dir) echo "selected";
					echo " value=".$dir.">".$bg_bibrefs_lang_name."</option>\n";
				}
			}
			closedir($handle); 
		}
		$path = BG_BIBREFS_UPLOAD_DIR.'/bible/';
		if ($handle = opendir($path)) {
			while (false !== ($dir = readdir($handle))) { 
				if (is_dir ( $path.$dir ) && $dir != '.' && $dir != '..') {
					include ($path.$dir.'/books.php');
					echo "<option ";
					if($bg_verses_lang_val==$dir) echo "selected";
					echo " value=".$dir.">".$bg_bibrefs_lang_name."</option>\n";
				}
			}
			closedir($handle); 
		}
	?>
</select>
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Show original verse numbers', 'bg_bibrefs' ); ?></th>
<td>
<input type="checkbox" id="bg_show_fn" name="<?php echo $bg_show_fn ?>" <?php if($bg_show_fn_val=="on") echo "checked" ?>  value="on"> <?php _e('<br><i>(Show the original verse numbers in parentheses after the verse numbers of Russian Synodal Translation in the tooltips and quotes.<br>Verses marked with asterisk * are absent in the original translation. * - always visible!)</i>', 'bg_bibrefs' ); ?> <br />
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Open links', 'bg_bibrefs' ); ?></th>
<td>
<input type="radio" id="blank_window" name="<?php echo $target_window ?>" <?php if($target_val=="_blank") echo "checked" ?> value="_blank"> <?php _e('in new window', 'bg_bibrefs' ); ?><br />
<input type="radio" id="self_window" name="<?php echo $target_window ?>" <?php if($target_val=="_self") echo "checked" ?> value="_self"> <?php _e('in current window', 'bg_bibrefs' ); ?><br />
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Highlight references in the headers H1...H6', 'bg_bibrefs' ); ?></th>
<td>
<input type="checkbox" id="bg_headers" name="<?php echo $bg_headers ?>" <?php if($bg_headers_val=="on") echo "checked" ?>  value="on"> <br />
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Show Bible verses in popup', 'bg_bibrefs' ); ?></th>
<td>
<input type="checkbox" id="bg_verses" name="<?php echo $bg_verses_name ?>" <?php if($bg_verses_val=="on") echo "checked" ?>  value="on" onclick='bg_verses_checked();'> <?php _e('<br><i>(If this option is disabled or data are not received from the server,<br>popup showing the Bible book title, chapter number and verse numbers)</i>', 'bg_bibrefs' ); ?> <br />
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Preload Bible verses in tooltips', 'bg_bibrefs' ); ?></th>
<td>
<input type="checkbox" id="bg_bibrefs_pload" name="<?php echo $bg_bibrefs_pload ?>" <?php if($bg_bibrefs_pload_val=="on") echo "checked" ?>  value="on" onclick='bg_bibrefs_check_preload();'> <?php _e(' - before upload of the post (using PHP)', 'bg_bibrefs' ); ?><?php _e('<br><i>(Requires a lot of of time to prepare and upload of the post.<br><u>Warning:</u> You can have a problem with limiting the maximum execution time for script on the server.)</i>', 'bg_bibrefs' ); ?><br /><br />
<input type="checkbox" id="bg_bibrefs_preq" name="<?php echo $bg_bibrefs_preq ?>" <?php if($bg_bibrefs_preq_val=="on") echo "checked" ?>  value="on" onclick='bg_bibrefs_check_prereq();'> <?php _e(' - after upload of the post (using AJAX)', 'bg_bibrefs' ); ?><?php _e('<br><i>(Try this option on a slow server.<br><u>Warning:</u> You can have a problem with ajax-requests limiting on the server.)</i>', 'bg_bibrefs' ); ?> <br />
</td></tr>
<script>
bg_verses_checked();
bg_bibrefs_check_preload();
bg_bibrefs_check_prereq();
</script>
 
</table>

<!--  Дополнительные параметры -->
<table class="form-table" style="display: <?php echo $active_tab == 'additional' ? '' : 'none'; ?>;">
<tr valign="top">
<th scope="row"><?php _e('The maximum execution time', 'bg_bibrefs') ?></th>
<td>
<input type="number" name="bg_bibrefs_maxtime" value="<?php echo $bg_bibrefs_maxtime_val; ?>" /> <?php _e('sec.', 'bg_bibrefs' ); ?>
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Method of reading files', 'bg_bibrefs' ); ?></th>
<td>
<input type="checkbox" id="bg_fgc" name="<?php echo $bg_fgc_name ?>" <?php if($bg_fgc_val=="on") echo "checked" ?>  value="on" onclick='reading_off_checked();'> file_get_contents()<br />
<input type="checkbox" id="bg_fopen" name="<?php echo $bg_fopen_name ?>" <?php if($bg_fopen_val=="on") echo "checked" ?>  value="on" onclick='reading_off_checked();'> fopen() - fread() - fclose()<br />
<input type="checkbox" id="bg_curl" name="<?php echo $bg_curl_name ?>" <?php if($bg_curl_val=="on") echo "checked" ?> value="on" onclick='reading_off_checked();'> cURL<br />
<?php _e('<i>(Plugin tries to read Bible files with marked methods in the order listed.<br>To do the reading faster, disable unnecessary methods - you need one only. <br><u>Warning:</u> Some methods may not be available on your server.)</i>', 'bg_bibrefs' ); ?> <br />
</td></tr>
<script>
reading_off_checked();
</script>

<tr valign="top">
<th scope="row"><?php _e('External AJAX Proxy', 'bg_bibrefs' ); ?></th>
<td>
<input type="text" id="bg_bibrefs_ajaxurl" name="<?php echo $bg_bibrefs_ajaxurl ?>" size="60" value="<?php echo $bg_bibrefs_ajaxurl_val ?>"><br />
<details>
<summary><?php _e('Add into <em>functions.php</em> on this server the following PHP-code (see bellow)', "bg_bibrefs"); ?></summary>
<?php printf ('<code>function allow_origin () {<br>&nbsp;&nbsp;&nbsp;&nbsp;header ( "Access-Control-Allow-Origin: %1$s" );<br>}<br>add_action ( "init", "allow_origin" );</code>', get_site_url()); ?>
</details>
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Container, inside which will display tooltips', 'bg_bibrefs' ); ?></th>
<td>
<input type="text" id="bg_content" name="<?php echo $bg_content ?>" size="20" value="<?php echo $bg_content_val ?>"><br />
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Reference links CSS class', 'bg_bibrefs' ); ?></th>
<td>
<input type="text" id="links_class" name="<?php echo $links_class ?>" size="20" value="<?php echo $class_val ?>"><br />
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Custom file of Bible quotes', 'bg_bibrefs' ); ?></th>
<td>
<input type="text" id="bg_refs_file" name="<?php echo $bg_refs_file ?>" size="60" value="<?php echo $bg_refs_file_val ?>"><br />
</td></tr>

<tr valign="top">
<th scope="row"><?php _e('Debug', 'bg_bibrefs' ); ?></th>
<td>
<input type="checkbox" id="bg_bibrefs_debug" name="<?php echo $bg_bibrefs_debug_name ?>" <?php if($bg_bibrefs_debug_val=="on") echo "checked" ?>  value="on"'> <?php _e('<br><i>(If you enable this option the debug information will written to the file "debug.log" in the plugin directory.<br>The file will be updated in 30 minutes after the last record, or the filesize exceed 2 Mb.<br><font color="red"><b>Disable this option after the end of debugging!</b></font>)</i>', 'bg_bibrefs' ); ?> <br />
</td></tr>

</table>

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php _e('Update Options', 'bg_bibrefs' ) ?>" />
</p>

</form>

<?php } ?>

</div>
</td>

<!-- Информация о плагине -->
<td valign="top" align="left" width="45em">

<div class="bg_bibrefs_info_box">

	<h3><?php _e('Thanks for using Bg Biblie References', 'bg_bibrefs') ?></h3>
	<p class="bg_bibrefs_gravatar"><a href="https://bogaiskov.ru" target="_blank"><?php echo get_avatar("vadim.bogaiskov@gmail.com", '64'); ?></a></p>
	<p><?php _e('Dear brothers and sisters!<br />Thank you for using my plugin!<br />I hope it is useful for your site.', 'bg_bibrefs') ?></p>
	<p class="bg_bibrefs_author"><a href="https://bogaiskov.ru" target="_blank"><?php _e('Vadim Bogaiskov', 'bg_bibrefs') ?></a></p>

	<h3><?php _e('I like this plugin<br>– how can I thank you?', 'bg_bibrefs') ?></h3>
	<p><?php _e('There are several ways for you to say thanks:', 'bg_bibrefs') ?></p>
	<ul>
		<li><?php printf(__('<a href="%1$s" target="_blank">Give a donation</a>  for the construction of the church of Sts. Peter and Fevronia in Marino', 'bg_bibrefs'), "https://hpf.ru.com/donate/") ?></li>
		<li><?php printf(__('Share infotmation or make a nice blog post about the plugin', 'bg_bibrefs')) ?></li>
	</ul>
	<!-- div class="share42init" align="center" data-url="https://bogaiskov.ru/bg_bibrefs/" data-title="<?php _e('Bg Bible References really cool plugin for Orthodox WordPress sites', 'bg_bibrefs') ?>"></div -->
	<!-- script type="text/javascript" src="<?php printf( plugins_url( 'share42/share42.js' , dirname(__FILE__) ) ) ?>"></script -->

	<h3><?php _e('Support', 'bg_bibrefs') ?></h3>
	<p><?php printf(__('Please see the <a href="$s" target="_blank">plugin\'s site</a> for help.', 'bg_bibrefs'), "http://wp-bible.info/") ?></p>
	
	<p class="bg_bibrefs_close"><?php _e("God protect you!", 'bg_bibrefs') ?></p>
</div>
</td></tr></table>
<?php 

} 