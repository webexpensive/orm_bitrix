<?php

namespace WebAlex\D7;

use WebAlex\D7\ClientTable;
use WebAlex\D7\StatusTable;
use WebAlex\D7\TaskTable;

class Test
{
    public static function get() 
    {

        // создаем объект Query, в качестве параметра передаем объект сущности (инфоблок)
        $query = new \Bitrix\Main\Entity\Query(
            ClientTable::getEntity()
        );

        $query->registerRuntimeField(
            'TASK',
            new \Bitrix\Main\Entity\ReferenceField(
                'TASK',
                TaskTable::getEntity(),
                ['=this.ID' => 'ref.CLIENT_ID']
            )
        );

        $query->registerRuntimeField(
            'STATUS',
            new \Bitrix\Main\Entity\ReferenceField(
                'STATUS',
                StatusTable::getEntity(),
                ['=ref.ID' => 'this.TASK.STATUS_ID'],
            )
        );

        $query->registerRuntimeField(
            'ELEMENT_COUNT',
            array(
                // тип вычисляемого поля
                'data_type' => 'integer',
                // агрегатная функция (COUNT, MAX, MIN, SUM, AVG) и поле для подстановки
                'expression' => array('COUNT(%s)', 'TASK.ID')
            )
        );

        $query->registerRuntimeField('DL_SORT1',new \Bitrix\Main\Entity\ExpressionField('DL_SORT1' ,"(SUM(CASE WHEN %s = 'F' then %s ELSE 0 END))", ['STATUS.CODE', 'TASK.PRICE']));
        $query->registerRuntimeField('DL_SORT2',new \Bitrix\Main\Entity\ExpressionField('DL_SORT2' ,"(SUM(CASE WHEN %s = 'P' then %s ELSE 0 END))", ['STATUS.CODE', 'TASK.PRICE']));

        $query->setSelect(array('ID', 'NAME','DL_SORT1','DL_SORT2','ELEMENT_COUNT'));

        //echo $query->getQuery();

        $result = $query->exec();
        $aRows = [];
        $mas_table = '<table class="adm-list-table"><thead><tr class="adm-list-table-header"><td class="adm-list-table-cell adm-list-table-cell-sort"><div class="adm-list-table-cell-inner">ID клиента</div></td><td class="adm-list-table-cell adm-list-table-cell-sort"><div class="adm-list-table-cell-inner">Название клиента</div></td><td class="adm-list-table-cell adm-list-table-cell-sort"><div class="adm-list-table-cell-inner">Сумма по задачам в статусе "Выполнено"</div></td><td class="adm-list-table-cell adm-list-table-cell-sort"><div class="adm-list-table-cell-inner">Сумма по задачам в статусе "В процессе"</div></td><td class="adm-list-table-cell adm-list-table-cell-sort"><div class="adm-list-table-cell-inner">Общее количество задач клиента</div></td></tr></thead><tbody>';
        // выводим результат
        while ($row = $result->fetch()) {
            $mas_table .= '<tr class="adm-list-table-row"><td class="adm-list-table-cell">'.$row['ID'].'</td><td class="adm-list-table-cell">'.$row['NAME'].'</td><td class="adm-list-table-cell">'.$row['DL_SORT1'].'</td><td class="adm-list-table-cell">'.$row['DL_SORT2'].'</td><td class="adm-list-table-cell">'.$row['ELEMENT_COUNT'].'</td></tr>';
        }
        $mas_table .= '</tbody></table>';

        echo $mas_table;
    }
}