<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
require_once __DIR__ . '/../include.php';
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Application;

Loc::loadMessages(__FILE__);

$APPLICATION->SetTitle(Loc::getMessage('WEB_D7_MENU_TITLE'));

\Bitrix\Main\Loader::includeModule('web.d7');

// Вывод таблицы с помощью ORM
$someclass = new WebAlex\D7\Test();
$someclass->get();

// Вывод таблицы с прямого запроса
/*$connection = Application::getConnection();

$recordset = $connection->query("SELECT px_client.ID,
	px_client.NAME,
	SUM(
		CASE
		WHEN px_task_status.CODE='F' THEN
		px_task.PRICE
		ELSE 0
		END ) AS `Выполнено`, SUM(
		CASE
		WHEN px_task_status.CODE= 'P' THEN
		px_task.PRICE
		ELSE 0
		END ) AS `В процессе`, COUNT(px_task.ID) AS 'Общее количество задач клиента'
		FROM `px_client`
		LEFT JOIN `px_task`
		ON px_client.ID=px_task.CLIENT_ID
		JOIN `px_task_status`
		ON px_task.STATUS_ID=px_task_status.ID
		GROUP BY  px_client.ID, px_client.NAME");

$aRows = [];
$mas_table = '<table class="adm-list-table"><thead><tr class="adm-list-table-header"><td class="adm-list-table-cell adm-list-table-cell-sort"><div class="adm-list-table-cell-inner">ID клиента</div></td><td class="adm-list-table-cell adm-list-table-cell-sort"><div class="adm-list-table-cell-inner">Название клиента</div></td><td class="adm-list-table-cell adm-list-table-cell-sort"><div class="adm-list-table-cell-inner">Сумма по задачам в статусе "Выполнено"</div></td><td class="adm-list-table-cell adm-list-table-cell-sort"><div class="adm-list-table-cell-inner">Сумма по задачам в статусе "В процессе"</div></td><td class="adm-list-table-cell adm-list-table-cell-sort"><div class="adm-list-table-cell-inner">Общее количество задач клиента</div></td></tr></thead><tbody>';
while ($row = $recordset->Fetch()) {
	$mas_table .= '<tr class="adm-list-table-row"><td class="adm-list-table-cell">'.$row['ID'].'</td><td class="adm-list-table-cell">'.$row['NAME'].'</td><td class="adm-list-table-cell">'.$row['Выполнено'].'</td><td class="adm-list-table-cell">'.$row['В процессе'].'</td><td class="adm-list-table-cell">'.$row['Общее количество задач клиента'].'</td></tr>';
}
$mas_table .= '</tbody></table>';

echo $mas_table;*/

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php"); ?>