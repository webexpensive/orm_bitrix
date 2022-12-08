<?php
Bitrix\Main\Loader::registerAutoloadClasses(
	null,
	[
		'WebAlex\D7\Test' => '/local/modules/web.d7/lib/test.php',
		'WebAlex\D7\ClientTable' => '/local/modules/web.d7/lib/clienttable.php',
		'WebAlex\D7\StatusTable' => '/local/modules/web.d7/lib/statustable.php',
		'WebAlex\D7\TaskTable' => '/local/modules/web.d7/lib/tasktable.php',
	]
);