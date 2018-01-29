<?php


class PeriodAmount
{
    private $data_period_num = 0;
    //    private $data_start_date;// = date_create();        // 贷款首期借款日期
    private $data_last_date;// = date_create();         // 贷款上期还款日期
    private $data_period_date;// = date_create();       // 贷款本期还款日期
    
    
    function __construct($num)
    {
        //        $this->data_start_date = date_create();
        $this->data_last_date = date_create();
        $this->data_period_date = date_create();

    }
    
}