<?php

class Emarsys_Suite2_Model_System_Config_Maxrecord
{
    /**
     * Returns options array
     * 
     * @return array
     */
    public function toOptionArray()
    {
        $listString = Mage::getStoreConfig('emarsys_suite2_smartinsight/api/max_records_per_export_option');
        $list = explode(',', $listString);
        $result = array();
        foreach ($list as $item) {
            $val['value'] = $item;
            $val['label'] = $item;

            $result[] = $val;
        }

        return $result;
    }
}
